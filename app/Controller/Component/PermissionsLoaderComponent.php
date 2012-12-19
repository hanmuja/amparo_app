<?php
/**
 * PermissionsLoaderComponent. Provides functions to get the list of ACL granted permissions of any Aro. 
 * Each permission is represented by an Aco path.
 */

class PermissionsLoaderComponent extends Component 
{
	/**
	 * Other components utilized by PermissionsLoaderComponent:
	 * Session: It is used to write on Session the permissions found bye the Component.
	 */
	public $components = array('Session');
			
	/**
	 * The permissions array calculated by the component
	 * @var array
	 */
	protected $permissions = array();
			
	/**
	 * The full acos paths. This is NOT used to get the granted permissions array, but another extra
	 * component's funcionalities.
	 * @var array 
	 */
	protected $full_aco_paths = array();
			
	/**
	 * An array where each position is another array containing a set of Acos ids pointing to a permission ('granted' or 'denied').
	 * Each set of permission correspond to an Aro.
	 * The smaller the index of the set the greater the hierarchy of its permissions. 
	 * So, in case of conflict, the permission written is the one inside the group with greater hierarchy (ie the lowest index).
	 * 
	 * @example
	 * 
	 * $aros_permissions_hierarchy= array
	 * (
	 * 		array
	 * 		(
	 * 			'1'=>'denied',
	 * 			'12'=>'denied',
	 * 			'13'=>'granted'
	 * 		),
	 * 		array
	 * 		(
	 * 			'6'=>'granted',
	 * 			'12'=>'granted'
	 * 		)
	 * );
	 * 
	 * That example is a possible state of $aros_permissions_hierarchy. I has 2 arrays, each one correspond to an Aro.
	 * The second array surely corresponds to an Aro who is parent of the first array's Aro.
	 * So if you ask for the permission to the Aco with id= 6, the permission is 'granted' according to the second array.
	 * If you ask for the permission to the Aco with id= 12, the permission is 'denied'. Why?
	 * Well, the second array says 'granted' and the first says 'denied'. The first array has greater hierarchy so it 'wins'.
	 * 
	 * @var array
	 */
	protected $aros_permissions_hierarchy = array();
			
	/**
	 * Aro object
	 * 
	 * @var string
	 */
	public $Aro;
			
	/**
	 * Aro object
	 * 
	 * @var string
	 */
	public $Aco;
			
	/**
	 * Create the Aro and Aco objects.
	 */
	public function __construct(ComponentCollection $collection, $settings = array()) 
	{
		parent::__construct($collection, $settings);
		$this->Aro = ClassRegistry::init(array('class' => 'Aro', 'alias' => 'Aro'));
		$this->Aco = ClassRegistry::init(array('class' => 'Aco', 'alias' => 'Aco'));
	}

	/**
	 * Construct an aro permissions hierarchy into the $this->aros_permissions_hierarchy.
	 * 
	 * @param array $aro The aro with the structure of a typic find('first'). It must contain the Acos associated to the Aro.
	 * @return void
	 */
	protected function construct_aros_hierarchy($aro) 
	{
		$permissions_set = array();
		
		if ($aro['Aco']) 
		{
			foreach ($aro['Aco'] as $a) 
			{						
				$permission = 'denied';
				
				if ($a['Permission']['_create'] == 1 && $a['Permission']['_read'] == 1 && $a['Permission']['_delete'] == 1) 
				{
					$permission = 'granted';
				}
				$permissions_set[$a['id']] = $permission;
			}
		}
		
		$this->aros_permissions_hierarchy[] = $permissions_set;
		
		if ($aro['Aro']['parent_id']) 
		{
			$parent_aro = $this->Aro->findById($aro['Aro']['parent_id']);
			$this->construct_aros_hierarchy($parent_aro);	
		}
	}
	
	/**
	 * Find the granted permission from an aro and write it in $this->permissions. Each permission is an Aco path.
	 * 
	 * @param string $foreign_key The aros foreign key, or primaryKey in the model refered. It could be int, but for convenience is marked as string.
	 * @param string $model The model where to look for the foreign_key.
	 * 
	 * @return void 
	 */
	public function construct_permissions($foreign_key, $model) 
	{
		//Find the main aro. It contains the acos.
		$main_aro = $this->Aro->findByForeignKeyAndModel($foreign_key, $model);
		
		$this->aros_permissions_hierarchy=array();
		$this->permissions= array();
		//Construct the aros_permissions_hierarchy
		$this->construct_aros_hierarchy($main_aro);
		
		//get the full acos tree
		$this->Aco->recursive = 0;
		$acos_tree = $this->Aco->find('threaded', array('fields'=>array('Aco.id', 'Aco.parent_id', 'Aco.alias')));
		
		//It only makes sense to try to find granted permissions if we have a tree of acos and some permissions (granted and denied) to check.
		if ($acos_tree && $this->aros_permissions_hierarchy) 
		{
			
			//Start at the end of the sets of permission because it has less hierarchy.
			for ($i = count($this->aros_permissions_hierarchy)-1; $i >= 0 ; $i--) 
			{	
				$permissions_set = $this->aros_permissions_hierarchy[$i];
				if ($permissions_set) 
				{
					foreach ($acos_tree as $at) 
					{
						$this->write_permission($at, $permissions_set);
					}
				}
			}
		}
	}

	function write_permission($aco_tree, $permissions_set, $current_aco_path = '', $permission = 'ignore') 
	{
		//extract $Aco and $children
		extract($aco_tree);
		$aco_id = $Aco['id'];
		$aco_path = ($current_aco_path) ? $current_aco_path.'/'.$Aco['alias'] : $Aco['alias'];
		
		//if this aco has permission , overwrite the input permission
		if (isset($permissions_set[$aco_id])) 
		{
			$permission = $permissions_set[$aco_id];
		}
		
		if ($permission == 'granted') 
		{
			//if the permission is granted I write 1 (could be anything) in the $this->permissions with index= $aco_path
			$this->permissions[$aco_path] = 1;
		}

		if ($permission == 'denied') 
		{
			//if the permission is denied and it exist on $this->permissions I delete it
			if (isset($this->permissions[$aco_path])) 
			{
				unset($this->permissions[$aco_path]);
			}
		}	
		
		if ($children) {
			//each child is an aco tree
			foreach($children as $child)
			{
				$this->write_permission($child, $permissions_set, $aco_path, $permission);
			}
		}
		
		unset($aco_tree, $permissions_set, $aco_path, $permission);
	}
		
	/**
	 * $this->permissions getter. If no params is passed, return the current $this->permissions. If $foreign_key and $model
	 * are passed, constructs the permissions and return them.
	 * 
	 * @param string $foreign_key The aros foreign key, or primaryKey in the model refered. It could be int, but for 
	 * convenience is marked as string.
	 * @param string $model The model where to look for the foreign_key.
	 * @return array The array of granted permissions.
	 */
	public function get_permissions($foreign_key=false, $model=false){
		if($foreign_key && $model){
			$this->permissions= array();
			$this->aros_permissions_hierarchy= array();
			$this->construct_permissions($foreign_key, $model);
		}
		
		return $this->permissions;
	}
		
	/**
	 * Write the permissions in the session using the given key. If $foreign_key and $model
	 * are passed, constructs the permissions and write them.
	 * 
	 * @param string $foreign_key The aros foreign key, or primaryKey in the model refered. It could be int, but for 
	 * convenience is marked as string.
	 * @param string $model The model where to look for the foreign_key.
	 * @param string $key The key where to write in session.
	 * @return void.
	 */
	public function write_permissions_in_session($foreign_key=false, $model=false, $key='Auth.Permissions') 
	{
		if ($foreign_key && $model) 
		{
			$this->permissions= array();
			$this->aros_permissions_hierarchy= array();
			$this->construct_permissions($foreign_key, $model);
		}
		
		$this->Session->write($key, $this->permissions);
	}
		
	/**
	 * Construct the granted permissions for the current logged user and write it in session using the key.
	 * 
	 * @param string $key The key where to write in session.
	 * @return void.
	 */
	public function write_logged_permissions($key = 'Auth.Permissions') 
	{
		if ($this->Session->check('Auth.User.id')) 
		{
			$foreign_key = $this->Session->read('Auth.User.id');
			$model= 'User';
			
			$this->write_permissions_in_session($foreign_key, $model, $key);
		}
	}
	
	public function write_developer_permissions($key = 'Auth.Permissions')
	{
		$full_actions= $this->get_acos_paths(true);
		
		$developer_permissions= array();
		foreach($full_actions as $path)
		{
			$developer_permissions[$path]=1;
		}
		
		$this->Session->write($key, $developer_permissions);
	}
		
	public function write_paths($aco_tree, $current_aco_path='') 
	{
		//extract $Aco and $children
		extract($aco_tree);
		$aco_id = $Aco['id'];
		$aco_path = ($current_aco_path) ? $current_aco_path.'/'.$Aco['alias'] : $Aco['alias'];
		
		//if the permission is granted I write 1 (could be anything) in the $this->permissions with index= $aco_path
		$this->full_aco_paths[$aco_id] = $aco_path;
		
		if($children) 
		{
			//each child is an aco tree
			foreach ($children as $child) 
			{
				$this->write_paths($child, $aco_path);
			}
		}
	}
	
	/**
	 * Find the full acos paths list and write it in $this->full_acos_paths.
	 * 
	 * @return void 
	 */
	public function construct_acos_paths() {
		$acos_tree = $this->Aco->find('threaded', array('fields' => array('Aco.id', 'Aco.parent_id', 'Aco.alias'), "order"=>array("Aco.alias ASC")));
		
		foreach($acos_tree as $at) 
		{
			 $this->write_paths($at, array(), '', 'granted');
		}
	}
	
	/**
	 * Return all aco paths available.
	 * 
	 * @return array The aco paths.
	 */
	public function get_acos_paths($include_action_path= false) {
		$this->construct_acos_paths();
			
		$return = $this->full_aco_paths;
		
		if (!$include_action_path && $return) {
			$key= key($return);
			if($return[$key]=="controllers")
			unset($return[$key]);
			
			if ($return) {
				foreach ($return as $i => $path) {
					$return[$i] = substr($path, strlen('controllers/'));
				}
			}
		}	

		return $return; 
	}
		
	/**
	 * Return an array whose index are the plugin names according to @aco_paths
	 * 
	 * @param array $aco_paths A set of aco paths. In base of this the plugin names are found.
	 * @return array The plugins names. The names are the indexes.
	 */
	function get_plugins($aco_paths) 
	{
		/**
		 * Plugins array with this format [plugin_na]=>repeated, where repeated is true or false. If true
		 * that means that the plugins has a controller with the same name.
		 */
		$plugins = array();
		if ($aco_paths) 
		{
			
			foreach ($aco_paths as $ap) 
			{
				$arr = explode('/', $ap);
				
				if (count($arr) == 3) 
				{
					
					if (isset($plugins[$arr[0]])) 
					{
						//if the plugin has a controller with the same name.
						if($arr[0] == $arr[1])
						$plugins[$arr[0]] = true;
					} else {
						//if the plugin has a controller with the same name.
						if ($arr[0] == $arr[1]) 
						{
							$plugins[$arr[0]] = true;
						} 
						else 
						{
							$plugins[$arr[0]] = false;
						}
					}
				}
			}	
		}
		
		return $plugins;
	}
	
	/**
	 * Return an array with the app controllers and the plugins controller grouped.
	 * 
	 * @param array $aco_paths A set of aco paths.
	 * @param array $plugins An array whose indexes are the plugin names.
	 * @return array The app controllers and plugin controllers grouped.
	 */
	function get_controllers($aco_paths, $plugins){
		$app_controllers = array();
		$plugins_controllers = array();
		$structure = array();
		
		if ($aco_paths) 
		{
			
			foreach ($aco_paths as $ap) 
			{
				$arr = explode('/', $ap);
				
				
				if (isset($plugins[$arr[0]])) 
				{
				
					//if the first element is a plugin, then the second is a plugin controller
					if (isset($arr[1])) 
					{
						$plugins_controllers[$arr[0]][$arr[1]] = 1;
					}

				} 
				else 
				{
					
					//if the first element is not a plugin, then is a app controller
					$app_controllers[$arr[0]] = 1;
				}
			}
		}
		
		return compact('app_controllers', 'plugins_controllers');
	}
		
		
	function get_permissions_paths($foreign_key=false, $model=false, $include_action_path=false)
	{
		if($foreign_key && $model){
			$permissions= $this->get_permissions($foreign_key, $model);
		}
		else
		$permissions= $this->permissions;
		
		$return= array_keys($permissions);
		
		if (!$include_action_path && $return) 
		{
			$key= key($return);
			if($return[$key]=="controllers")
			unset($return[$key]);
			
			if ($return) 
			{
				foreach ($return as $i => $path) 
				{
					$return[$i] = substr($path, strlen('controllers/'));
				}
			}
		}
		
		return $return; 
	}
}

?>