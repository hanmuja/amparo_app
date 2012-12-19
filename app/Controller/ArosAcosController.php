<?php
App::uses('AppController', 'Controller');
/**
 * ArosAcos Controller
 *
 * @property ArosAco $ArosAco
 */
class ArosAcosController extends AppController 
{
	public $components= array("PermissionsLoader");
	
	function beforeFilter() 
	{
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$controller= "ArosAcos";
		$model= "ArosAco";
		$item= __("Aro/Aco");
		
		$this->set(compact("model", "controller", "item"));
	}
		
	function about()
	{
	}
	
	function role_permissions()
	{
		$controller= "ArosAcos";
		$model= "ArosAco";
		$item= __("Aro/Aco");
		
		$this->loadModel("Role");
		$this->loadModel("Aro");
		$this->loadModel("Aco");
		
	    $this->Role->recursive = -1;
	    $roles = $this->Role->find('list', array("order"=>array("Role.name ASC")));
	
		$actions = $this->PermissionsLoader->get_acos_paths();
		$plugins = $this->PermissionsLoader->get_plugins($actions);
		
		$permissions = array();
	    $methods     = array();
		
		$roles_permissions= array();
		foreach($roles as $role_id=>$role)
		{
			$roles_permissions[$role_id]= $this->PermissionsLoader->get_permissions_paths($role_id, "Role");
		}
		
	    foreach($actions as $aco_id=>$full_action)
    	{
    		$permissions = array();
    		$arr = array();
	    	$arr = explode('/', $full_action);
			
			$controller_name= "";
			$action= "";
	    	
			if(isset($plugins[$arr[0]]))
			{
				$plugin_name= $arr[0];
			}
			else
			{
				$controller_name= $arr[0];
				$plugin_name= false;
			}
			
			if(isset($arr[1]))
			{
				if($plugin_name)
				{
					$controller_name= $arr[1];
				}
				else
				{
					$action= $arr[1];
				}
			}
			
			//is a plugin action
			if(isset($arr[2]))
			{
				$action= $arr[2];
			}
    		
		    foreach($roles as $role_id => $role)
    		{	
	    		$role_node= array("model"=>"Role", "foreign_key"=>$role_id);
	    	    $this->Role->id = $role_id;
				$aro_node = $this->Role->node();
	            if(!empty($aro_node))
	            {
	            	$aco_node = $this->Aco->node($full_action);
	        	    if(!empty($aco_node))
	        	    {
	        	    	$authorized= in_array($full_action, $roles_permissions[$role_id]);
	        	    	$permissions[$role] = $authorized ? 1 : 0 ;
					}
	            }
	    		else
        	    {
        	        //No check could be done as the ARO is missing
        	        $permissions[$role] = -1;
        	    }	
			}
    		
			$full_action= str_replace("/", ACL_ACO_PATH_SEPARATOR, $full_action);
    		if($plugin_name)
            {
            	$methods['plugin'][$plugin_name][$controller_name][$aco_id] = array('name' => $action, 'permissions' => $permissions, "aco_path"=>$full_action);
            }
            else
            {
        	    $methods['app'][$controller_name][$aco_id] = array('name' => $action, 'permissions' => $permissions, "aco_path"=>$full_action);
            }
    	}
	
		$this->set(compact('roles'));
	    $this->set('actions', $methods);
		
		$this->set("link_group", "acl");
		$this->set("current_link", "RolesPermissions");
	}

	function role_authorize_all($role_id)
	{
		$this->loadModel("Role");
		$this->loadModel("Aro");
		$this->loadModel("Aco");
		
		$role =& $this->Role;
        $role->id = $role_id;
        
		/*
         * Check if the Role exists in the ARO table
         */
        $node = $this->Aro->node($role);
        if(empty($node))
        {
            //$asked_group = $role->read(null, $role_id);
        }
        else
        {
            //Allow to everything
            $this->Acl->allow($role, 'controllers');
    	}
		
		$this->redirect(array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"role_permissions"));
	}
	
	function role_block_all($role_id)
	{
		$this->loadModel("Role");
		$this->loadModel("Aro");
		$this->loadModel("Aco");
		
		$role =& $this->Role;
        $role->id = $role_id;
        
		/*
         * Check if the Role exists in the ARO table
         */
        $node = $this->Aro->node($role);
        if(empty($node))
        {
            //$asked_role = $role->read(null, $role_id);
        }
        else
        {
            //Allow to everything
            $this->Acl->deny($role, 'controllers');
    	}
		
		$this->redirect(array("plugin"=>null, "controller"=>"ArosAcos", "action"=>"role_permissions"));
	}
	
	function toggle_role_permission($role_id, $aco_path, $aco_id)
	{
		$this->loadModel("Role");
		$this->loadModel("Aco");
		
		$role =& $this->Role;
		$model= $role->alias;
		
		//Save the original value to send it to the view.
		$aco_path_tmp= $aco_path;
		
		$aco_path= str_replace(ACL_ACO_PATH_SEPARATOR, "/", $aco_path);
		$aco_path= "controllers/".$aco_path;
		
		//A superadmin permission only can be changed by a superadmin
		if($role_id!=SUPERADMIN_ROLE_ID || ($role_id==SUPERADMIN_ROLE_ID && $role_id==$this->Auth->user("role_id")))
		{	
			//find the aro's current permission
			$permission= $this->Acl->check(array($model=>array("id"=>$role_id)), $aco_path);
			
			if($permission)
			{
				$this->Acl->deny(array('model' => $model, 'foreign_key' => $role_id), $aco_path);
			}
			else
			{
				$this->Acl->allow(array('model' => $model, 'foreign_key' => $role_id), $aco_path);
			}
		}
		
		$permission= $this->Acl->check(array($model=>array("id"=>$role_id)), $aco_path);
		
		$permissions= array();
		$permissions["permission_".$aco_id."_".$role_id]= $permission;
		$children= $this->Aco->children($aco_id, true, array("Aco.id", "Aco.alias"));
		if($children)
		{
			foreach ($children as $child) 
			{
				$permissions= $this->child_permission($model, $role_id, $child, $aco_path, $permissions);
			}
		}
		
		$this->Role->recursive= -1;
		$role= $this->Role->findById($role_id);
		
		$aco_path= $aco_path_tmp;
		$this->set(compact("permissions", "role", "aco_path"));
		
        if(!$this->RequestHandler->isAjax())
        {
            $this->redirect($this->referer());
        }
	}

	private function child_permission($model, $foreign_key, $aco_array, $current_path="", $current_permissions= array())
	{
		$this->loadModel("Aco");
		
		$aco_path= $current_path."/".$aco_array["Aco"]["alias"];
		
		$permission= $this->Acl->check(array($model=>array("id"=>$foreign_key)), $aco_path);
		$current_permissions["permission_".$aco_array["Aco"]["id"]."_".$foreign_key]= $permission;
		$children= $this->Aco->children($aco_array["Aco"]["id"], true, array("Aco.id", "Aco.alias"));
		if($children)
		{
			foreach ($children as $child) 
			{
				$current_permissions= $this->child_permission($model, $foreign_key, $child, $aco_path, $current_permissions);
			}
		}
		return $current_permissions;
	}
	
	function users_permissions()
	{
		$this->loadModel("User");
        $this->set("title_for_layout", __("Users Permissions"));   
		
		$this->CustomTable->custom_startup($this, "Users");
		$conditions= $this->CustomTable->get_conditions("Users");
		$paginated= $this->CustomTable->isPaginated();
		
		$this->User->contain("Role.name");
		$all= $this->paginate("User", $conditions);
		
		$this->set(compact('all'));
        $this->set(compact("paginated"));
		
		$this->set("link_group", "acl");
		$this->set("current_link", "UsersPermissions");
	}
	
	function user_permissions($user_id)
	{
		$controller= "ArosAcos";
		$model= "ArosAco";
		$item= __("Aro/Aco");
		
		$this->loadModel("User");
		$this->loadModel("Aro");
		$this->loadModel("Aco");
		
	    $this->User->recursive = -1;
	    $user = $this->User->find('first', array("conditions"=>array("User.id"=>$user_id), "fields"=>array("id", "fullname")));
	
		if(!$user)
		{
			if($this->request->is('ajax'))
			{
				/**
				 * If this was an ajax request, we are inside a dialog, so we need to close the dialog and reload the index.
				 */
				
				$this->layout= "empty";
				$this->set("close", true);
				$this->set("manual_flash", __("The user does not exist."));
				$this->set("manual_flash_type", "error_box");
				return;
			}
			else
			{
				/**
				 * If this wasn't an ajax request, so we just redirect to the index.
				 */
				$this->Utils->flash_simple(__("The user does not exist."), "error");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'users_permissions'));
			}
		}
		
		$this->User->id = $user_id;
		$aro_node = $this->User->node();
        if(empty($aro_node))
		{
			if($this->request->is('ajax'))
			{
				/**
				 * If this was an ajax request, we are inside a dialog, so we need to close the dialog and reload the index.
				 */
				$this->layout= "empty";
				$this->set("close", true);
				$this->set("manual_flash", __("The user's ARO does not exist."));
				$this->set("manual_flash_type", "error_box");
				return;
			}
			else
			{
				/**
				 * If this wasn't an ajax request, so we just redirect to the index.
				 */
				$this->Utils->flash_simple(__("The user's ARO does not exist."), "error");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'users_permissions'));
			}
		}
	
		$actions = $this->PermissionsLoader->get_acos_paths();
		$plugins = $this->PermissionsLoader->get_plugins($actions);
		
	    $methods= array();
		
		$permissions= $this->PermissionsLoader->get_permissions_paths($user_id, "User");
		
		
	    foreach($actions as $aco_id=>$full_action)
    	{
    		$arr = array();
	    	$arr = explode('/', $full_action);
			
			$controller_name= "";
			$action= "";
	    	
			if(isset($plugins[$arr[0]]))
			{
				$plugin_name= $arr[0];
			}
			else
			{
				$controller_name= $arr[0];
				$plugin_name= false;
			}
			
			if(isset($arr[1]))
			{
				if($plugin_name)
				{
					$controller_name= $arr[1];
				}
				else
				{
					$action= $arr[1];
				}
			}
			
			//is a plugin action
			if(isset($arr[2]))
			{
				$action= $arr[2];
			}
    		
    		$role_node= array("model"=>"User", "foreign_key"=>$user_id);
        	$aco_node = $this->Aco->node($full_action);
    	    if(!empty($aco_node))
    	    {
    	    	$authorized= in_array($full_action, $permissions);
			}
    		
			$full_action= str_replace("/", ACL_ACO_PATH_SEPARATOR, $full_action);
    		if($plugin_name)
            {
            	$methods['plugin'][$plugin_name][$controller_name][$aco_id] = array('name' => $action, 'permission' => $authorized, "aco_path"=>$full_action);
            }
            else
            {
        	    $methods['app'][$controller_name][$aco_id] = array('name' => $action, 'permission' => $authorized, "aco_path"=>$full_action);
            }
    	}
	    $this->set('actions', $methods);
		$this->set(compact("user_id", "user"));
	}

	function toggle_user_permission($user_id, $aco_path, $aco_id)
	{
		$this->loadModel("User");
		$this->loadModel("Aco");
		
		$user =& $this->User;
		$model= $user->alias;
		
		//Save the original value to send it to the view.
		$aco_path_tmp= $aco_path;
		
		$aco_path= str_replace(ACL_ACO_PATH_SEPARATOR, "/", $aco_path);
		$aco_path= "controllers/".$aco_path;
		
		//find the aro's current permission
		$permission= $this->Acl->check(array($model=>array("id"=>$user_id)), $aco_path);
		
		if($permission)
		{
			$this->Acl->deny(array('model' => $model, 'foreign_key' => $user_id), $aco_path);
		}
		else
		{
			$this->Acl->allow(array('model' => $model, 'foreign_key' => $user_id), $aco_path);
		}
		
		$permission= $this->Acl->check(array($model=>array("id"=>$user_id)), $aco_path);
		
		$permissions= array();
		$permissions["permission_".$aco_id."_".$user_id]= $permission;
		$children= $this->Aco->children($aco_id, true, array("Aco.id", "Aco.alias"));
		if($children)
		{
			foreach ($children as $child) 
			{
				$permissions= $this->child_permission($model, $user_id, $child, $aco_path, $permissions);
			}
		}
		
		$aco_path= $aco_path_tmp;
		$this->set(compact("permissions", "aco_path"));
		
        if(!$this->RequestHandler->isAjax())
        {
            $this->redirect($this->referer());
        }
	}

	function friendly_roles_permissions()
	{
		$selected_permissions= selected_permissions(); 
		
		$role_model_name = ACL_ARO_ROLE_MODEL;
        
		$this->loadModel($role_model_name);
		$this->loadModel("Aro");
		$this->loadModel("Aco");
		
	    $this->{$role_model_name}->recursive = -1;
		
		$conditions= array();
		if($this->Auth->user("role_id")!=SUPERADMIN_ROLE_ID)
		$conditions= array("NOT"=>array("Role.id"=>superadmin_roles()));
		
	    $roles = $this->{$role_model_name}->find('list', array("conditions"=>$conditions));
	
		$actions = $this->PermissionsLoader->get_acos_paths();
		$plugins = $this->PermissionsLoader->get_plugins($actions);
		
		$permissions = array();
	    $methods     = array();
		
		$roles_permissions= array();
		foreach($roles as $role_id=>$role)
		{
			$roles_permissions[$role_id]= $this->PermissionsLoader->get_permissions_paths($role_id, $role_model_name);
		}
		
	    foreach($actions as $aco_id=>$full_action)
    	{
    		$permissions = array();
    		$use= false;
			$parent_label= false;
			$action_label= false;
    		foreach($selected_permissions as $parent_name=>$selected_paths)
			{
				foreach($selected_paths as $selected_path=>$label)
				{
					if($selected_path==$full_action)
					{
						$use= true;
						$parent_label= $parent_name;
						$action_label= $label;
						break;
					}
				}
				if($use)
				break;
			}
			
			if($use)
			{
	    		$arr = array();
		    	$arr = explode('/', $full_action);
				
				$controller_name= "";
				$action= "";
		    	
				if(isset($plugins[$arr[0]]))
				{
					$plugin_name= $arr[0];
				}
				else
				{
					$controller_name= $arr[0];
					$plugin_name= false;
				}
				
				if(isset($arr[1]))
				{
					if($plugin_name)
					{
						$controller_name= $arr[1];
					}
					else
					{
						$action= $arr[1];
					}
				}
				
				//is a plugin action
				if(isset($arr[2]))
				{
					$action= $arr[2];
				}
	    		
			    foreach($roles as $role_id => $role)
	    		{	
		    		$role_node= array("model"=>$role_model_name, "foreign_key"=>$role_id);
		    	    $this->$role_model_name->id = $role_id;
					$aro_node = $this->$role_model_name->node();
		            if(!empty($aro_node))
		            {
		            	$aco_node = $this->Aco->node($full_action);
		        	    if(!empty($aco_node))
		        	    {
		        	    	$authorized= in_array($full_action, $roles_permissions[$role_id]);
		        	    	//$authorized = $this->Acl->check($role_node, $full_action);
		        	    	$permissions[$role] = $authorized ? 1 : 0 ;
						}
		            }
		    		else
	        	    {
	        	        //No check could be done as the ARO is missing
	        	        $permissions[$role] = -1;
	        	    }	
    			}
	    		
				$full_action= str_replace("/", ACL_ACO_PATH_SEPARATOR, $full_action);
	    		$methods[$parent_label][$aco_id] = array('name' => $action_label, 'permissions' => $permissions, "aco_path"=>$full_action);	
			}
    	}
	
		$this->set('roles', $roles);
	    $this->set('actions', $methods);
	}

	function friendly_users_permissions()
	{
		$this->loadModel("User");
		
		$users= $this->paginate("User");
		
		$this->set('leftcol', 'acl/lawyer_admin_left');
		$this->set(compact("users"));
	}	

	function friendly_user_permissions($user_id)
	{
		$selected_permissions= selected_permissions();
		
		$this->loadModel("User");
		$this->loadModel("Aro");
		$this->loadModel("Aco");
		
	    $this->User->recursive = -1;
	    $user = $this->User->find('first', array("conditions"=>array("User.id"=>$user_id), "fields"=>array("id", "name")));
	
		if(!$user)
		{
			$this->Session->setFlash(__("The user does not exist.", true));
			$this->redirect(array("plugin"=>null, "controller"=>"aros_acos", "action"=>"users_permissions"));
		}
		
		$this->User->id = $user_id;
		$aro_node = $this->User->node();
        if(empty($aro_node))
		{
			$this->Session->setFlash(__("The user's ARO does not exist.", true));
			$this->redirect(array("plugin"=>null, "controller"=>"aros_acos", "action"=>"users_permissions"));
		}
	
		$actions = $this->PermissionsLoader->get_acos_paths();
		$plugins = $this->PermissionsLoader->get_plugins($actions);
		
	    $methods     = array();
		
		$permissions= $this->PermissionsLoader->get_permissions_paths($user_id, "User");
		
	    foreach($actions as $aco_id=>$full_action)
    	{
    		$use= false;
			$parent_label= false;
			$action_label= false;
    		foreach($selected_permissions as $parent_name=>$selected_paths)
			{
				foreach($selected_paths as $selected_path=>$label)
				{
					if($selected_path==$full_action)
					{
						$use= true;
						$parent_label= $parent_name;
						$action_label= $label;
						break;
					}
				}
				if($use)
				break;
			}
			
			if($use)
			{
	    		$arr = array();
		    	$arr = explode('/', $full_action);
				
				$controller_name= "";
				$action= "";
		    	
				if(isset($plugins[$arr[0]]))
				{
					$plugin_name= $arr[0];
				}
				else
				{
					$controller_name= $arr[0];
					$plugin_name= false;
				}
				
				if(isset($arr[1]))
				{
					if($plugin_name)
					{
						$controller_name= $arr[1];
					}
					else
					{
						$action= $arr[1];
					}
				}
				
				//is a plugin action
				if(isset($arr[2]))
				{
					$action= $arr[2];
				}
	    		
			    $role_node= array("model"=>"User", "foreign_key"=>$user_id);
            	$aco_node = $this->Aco->node($full_action);
        	    if(!empty($aco_node))
        	    {
        	    	$authorized= in_array($full_action, $permissions);
				}
	    		
				$full_action= str_replace("/", ACL_ACO_PATH_SEPARATOR, $full_action);
	    		$methods[$parent_label][$aco_id] = array('name' => $action_label, 'permission' => $authorized, "aco_path"=>$full_action);	
			}
    	}
	
	    $this->set('actions', $methods);
		$this->set(compact("user_id", "user"));
	}
}
