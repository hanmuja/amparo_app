<?php

App::uses('DbAcl', 'Model');

class AclExtrasComponent extends Component 
{
	public $components= array("Acl");
	
	
	private $Aco;
	/**
	 * Contains database source to use
	 *
	 * @var string
	 * @access public
	 */
	public $dataSource = 'default';

	/**
	 * Root node name.
	 *
	 * @var string
	 **/
	public $rootNode = 'controllers';

	/**
	 * Internal Clean Actions switch
	 *
	 * @var boolean
	 **/
	public $_clean = false;
	
	/**
	 * The generated logs
	 * 
	 * @var array
	 */
	public $log= array();
	
	public function startup($controller_object) 
	{
		$this->Aco= $this->Acl->Aco;
	}
	
	/**
	 * Sync the ACO table
	 *
	 * @return void
	 **/
	function aco_sync() {
		$this->_clean = true;
		return $this->aco_update();
	}
	
	
	/**
	 * Updates the Aco Tree with new controller actions.
	 *
	 * @return void
	 **/
	function aco_update() 
	{
		$root = $this->_checkNode($this->rootNode, $this->rootNode, null);
		$controllers = $this->getControllerList();
		$this->_updateControllers($root, $controllers);

		$plugins = CakePlugin::loaded();
		foreach ($plugins as $plugin) {
			$controllers = $this->getControllerList($plugin);

			$path = $this->rootNode . '/' . $plugin;
			$pluginRoot = $this->_checkNode($path, $plugin, $root['Aco']['id']);
			$this->_updateControllers($pluginRoot, $controllers, $plugin);
		}
		$this->log[]= 'Aco Update Complete';
		return $this->log;
	}
	
	/**
	 * Updates a collection of controllers.
	 *
	 * @param array $root Array or ACO information for root node.
	 * @param array $controllers Array of Controllers
	 * @param string $plugin Name of the plugin you are making controllers for.
	 * @return void
	 */
	function _updateControllers($root, $controllers, $plugin = null) {
		$dotPlugin = $pluginPath = $plugin;
		if ($plugin) {
			$dotPlugin .= '.';
			$pluginPath .= '/';
		}
		$appIndex = array_search($plugin . 'AppController', $controllers);
		if ($appIndex !== false) {
			App::uses($plugin . 'AppController', $dotPlugin . 'Controller');
			unset($controllers[$appIndex]);
		}
		// look at each controller
		foreach ($controllers as $controller) {
			App::uses($controller, $dotPlugin . 'Controller');
			$controllerName = preg_replace('/Controller$/', '', $controller);

			$path = $this->rootNode . '/' . $pluginPath . $controllerName;
			$controllerNode = $this->_checkNode($path, $controllerName, $root['Aco']['id']);
			$this->_checkMethods($controller, $controllerName, $controllerNode, $pluginPath);
		}
		if ($this->_clean) {
			if (!$plugin) {
				$controllers = array_merge($controllers, App::objects('plugin', null, false));
			}
			$controllerFlip = array_flip($controllers);

			$this->Aco->id = $root['Aco']['id'];
			$controllerNodes = $this->Aco->children(null, true);
			foreach ($controllerNodes as $ctrlNode) {
				$alias = $ctrlNode['Aco']['alias'];
				$name = $alias . 'Controller';
				if (!isset($controllerFlip[$name]) && !isset($controllerFlip[$alias])) {
					if ($this->Aco->delete($ctrlNode['Aco']['id'])) {
						$this->log[]= __('Deleted %s and all children',$this->rootNode . '/' . $ctrlNode['Aco']['alias']);
					}
				}
			}
		}
	}

	/**
	 * Get a list of controllers in the app and plugins.
	 *
	 * Returns an array of path => import notation.
	 *
	 * @param string $plugin Name of plugin to get controllers for
	 * @return array
	 **/
	function getControllerList($plugin = null) 
	{
		if (!$plugin) {
			$controllers = App::objects('Controller', null, false);
		} else {
			$controllers = App::objects($plugin . '.Controller', null, false);
		}
		return $controllers;
	}
	
	/**
	 * Check a node for existance, create it if it doesn't exist.
	 *
	 * @param string $path
	 * @param string $alias
	 * @param int $parentId
	 * @return array Aco Node array
	 */
	function _checkNode($path, $alias, $parentId = null) {
		$node = $this->Aco->node($path);
		if (!$node) {
			$this->Aco->create(array('parent_id' => $parentId, 'model' => null, 'alias' => $alias));
			$node = $this->Aco->save();
			$node['Aco']['id'] = $this->Aco->id;
			$this->log[]= __('Created Aco node: %s', $path);
		} else {
			$node = $node[0];
		}
		return $node;
	}
	
	/**
	 * Check and Add/delete controller Methods
	 *
	 * @param string $controller
	 * @param array $node
	 * @param string $plugin Name of plugin
	 * @return void
	 */
	function _checkMethods($className, $controllerName, $node, $pluginPath = false) {
		$baseMethods = get_class_methods('Controller');
		$actions = get_class_methods($className);
		$methods = array_diff($actions, $baseMethods);
		foreach ($methods as $action) {
			if (strpos($action, '_', 0) === 0) {
				continue;
			}
			$path = $this->rootNode . '/' . $pluginPath . $controllerName . '/' . $action;
			$this->_checkNode($path, $action, $node['Aco']['id']);
		}

		if ($this->_clean) 
		{
			$actionNodes = $this->Aco->children($node['Aco']['id']);
			$methodFlip = array_flip($methods);
			foreach ($actionNodes as $action) 
			{
				if (!isset($methodFlip[$action['Aco']['alias']])) 
				{
					$this->Aco->id = $action['Aco']['id'];
					if ($this->Aco->delete()) 
					{
						$path = $this->rootNode . '/' . $controllerName . '/' . $action['Aco']['alias'];
						$this->log[]= __('Deleted Aco node %s', $path);
					}
				}
			}
		}
		return true;
	}
}

?>
	