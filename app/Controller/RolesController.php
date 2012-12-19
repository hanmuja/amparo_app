<?php
App::uses('AppController', 'Controller');
/**
 * Roles Controller
 *
 * @property Role $Role
 */
class RolesController extends AppController 
{
	public $components= array("FriendlyPermissions");
	
	function beforeFilter() 
	{
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$model= "Role";
		$controller= "Roles";
		$item= __("Role");
		
		$this->set(compact("model", "controller", "item"));
	}
	
	function index()
    {
    	/**
		 * Add this at the begining of every action, so inside the action we always know the current controller, model and item name.
		 */
        $model= "Role";
		$controller= "Roles";
		$item= __("Role");
     	
        $this->set("title_for_layout", __("Roles"));   
		
		$conditions= $this->CustomTable->get_conditions($controller);
		
		$this->Paginator->settings= array($model=>array("order"=>array("Role.name"=>"asc")));
	
		$paginated= $this->CustomTable->isPaginated();
		
		$this->$model->contain("User.id");
		$all= $this->paginate($conditions);
		
		$this->set(compact('all'));
        $this->set(compact("paginated"));
		$this->set("link_group", "users_and_permissions");
		$this->set("current_link", "Roles");
    }
	
	function add()
	{
		$model= "Role";
		$controller= "Roles";
		$item= __("Role");
     	
        $this->set("title_for_layout", __("Add ".$item));   
		
		if($this->request->is('post'))
		{
			$this->request->data[$model]["editable"]=1;
			
			//TODO:
			//$this->request->data[$model]["created_by"]= $this->Auth->user("id");
			
			$this->$model->create();
			if ($this->$model->save($this->request->data)) 
			{
				$this->Utils->flash($item, "success_add");
				
				if($this->request->is('ajax'))
				{
					/**
					 * If this was an ajax request, we are inside a dialog, so we need to close the dialog and reload the index.
					 */
					$this->layout= "empty";
					$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
					$this->set("close", true);
					$this->render("form");
					return;
				}
				else
				{
					/**
					 * If this wasn't an ajax request, so we just redirect to the index.
					 */
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
				}
			} 
			else 
			{
				$this->Utils->flash($item, "error_add");
			}
		}
		
		$this->$model->Language->recursive = -1;
		$languages = $this->$model->Language->find('list');
		
		$this->set(compact('languages'));
		
		$this->set("edit", false);
		$this->set("save_label", __("Add"));
		$this->render("form");
	}
	
	function edit($id)
	{
		$model= "Role";
		$controller= "Roles";
		$item= __("Role");
     	
        $this->set("title_for_layout", __("Edit ".$item));   
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			$this->$model->create();
			if ($this->$model->save($this->request->data)) 
			{
				$this->Utils->flash($item, "success_add");
				if($this->request->is('ajax'))
				{
					$this->layout= "empty";
					$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
					$this->set("close", true);
					$this->render("form");
					return;
				}
				else
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
			} 
			else 
			{
				$this->Utils->flash($item, "error_add");
			}
		}
		else
		{
			$this->request->data = $this->$model->read(null, $id);
			
			if($this->data[$model]["editable"]==0)
			{
				$this->Utils->flash_simple(__("The role %s is not editable.", $this->data[$model]["name"]), "error");
				if($this->request->is('ajax'))
				{
					$this->layout= "empty";
					$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
					$this->set("close", true);
					$this->render("form");
					return;
				}
				else
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
			}
		}
		
		$this->$model->Language->recursive = -1;
		$languages = $this->$model->Language->find('list');
		
		$this->set(compact('languages'));
		
		$this->set("edit", true);
		$this->set("save_label", __("Edit"));
		$this->render("form");
	}

	function delete($id = null) 
	{
		$model= "Role";
		$controller= "Roles";
		$item= __("Role");
     	
		if (!$this->request->is('post')) 
		{
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if ($this->$model->delete($id)) 
		{
			$this->Utils->flash($item, "success_delete");
			$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
		}
		$this->Utils->flash($item, "error_delete");
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}
	
	function full_permissions($id= null)
    {
            $model= "Role";
            $controller= "Roles";
            $item= __("Role");
            
            //I will use a couple of tabs. Each tab will be called via ajax. By default, the first tab is displayed:
            //1. Application 
            //2. Locations
            
            $tabs_data= array();
            $data= array();
            $data["label"]= __("Application");
            $data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"permissions", $id);
            $tabs_data[]= $data;
			
			$data= array();
			$data["label"]= __("Locations");
			$data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"locations_permissions", $id);
			$tabs_data[]= $data;
            
            $data= array();
            $data["label"]= __("Visible Roles");
            $data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"roles_permissions", $id);
            $tabs_data[]= $data;
            
			$data= array();
            $data["label"]= __("Visible Folders");
            $data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"visible_folders", $id);
            $tabs_data[]= $data;
            
            $this->set(compact("tabs_data"));
    }
	
	function permissions($id = null, $tab=false) 
	{
		$model= "Role";
		$controller= "Roles";
		$item= __("Role");
		
		if($tab)
                {
                        list($aux, $tab)= explode("_", $tab);
                        $this->Session->write("TabPermissions", $tab);
                }
		
		$this->set("title_for_layout", __("Edit")." ".$item." ".__("Permissions"));   
		
		$this->$model->recursive = -1;
	    $one = $this->$model->find('first', array("conditions"=>array($model.".id"=>$id), "fields"=>array("id", "name")));
	
		if(!$one)
		{
			if($this->request->is('ajax'))
			{
				$this->layout= "empty";
				$this->set("close", true);
				$this->set("manual_flash", __("The Role does not exist."));
				$this->set("manual_flash_type", "error_box");
				return;
			}
			else
			{
				$this->Utils->flash_simple(__("The Role does not exist."), "error");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
			}
		}
		
		$this->$model->id = $id;
		$aro_node = $this->$model->node();
        if(empty($aro_node))
		{
			if($this->request->is('ajax'))
			{
				$this->layout= "empty";
				$this->set("close", true);
				$this->set("manual_flash", __("The Role's ARO does not exist."));
				$this->set("manual_flash_type", "error_box");
				return;
			}
			else
			{
				$this->Utils->flash_success(__("The Role's ARO does not exist."), "error");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'permissions'));
			}
		}
		
		$permissions= $this->PermissionsLoader->get_permissions_paths($id, $model);
		$this->loadModel('FriendlyPermissionsItem');
		$permissionsMenu = $this->FriendlyPermissionsItem->getPermissionsMenu($permissions);
		$this->set(compact('boxes_roles', 'one', 'permissionsMenu'));
	}
	
	function roles_permissions($id = null, $tab=false) 
        {
                $model= "Role";
                $controller= "Roles";
                $item= __("Role");
                
                if($tab)
                {
                        list($aux, $tab)= explode("_", $tab);
                        $this->Session->write("TabPermissions", $tab);
                }
                
                $this->set("title_for_layout", __("Edit")." ".$item." ".__("Roles Initial Permissions"));   
                
                $this->$model->id = $id;
                if (!$this->$model->exists()) 
                {
                        throw new NotFoundException(__('Invalid '.$item));
                }
                
                if($this->request->is('post') || $this->request->is('put'))
                {
                	if($this->data['AuxElm']['process'] == 1 || $this->data['AuxElm']['process'] == 3)
					{
                        $this->request->data["InitialRole"]= array();
            
                     if($this->data["AuxElm"]["InitialRole"])
                        {
                        	foreach($this->data["AuxElm"]["InitialRole"] as $role_id=>$include)
                            {
                            	if($include)
                                	$this->request->data["InitialRole"][]= $role_id;
                         }
                        }
                        
                        $this->$model->create();
                     if ($this->$model->saveAll($this->request->data))
                        {
                                $this->Utils->flash($item, "success_add");
                     } 
                        else 
                        {
                                $this->Utils->flash($item, "error_add");
                     }
					}
					
					if($this->data['AuxElm']['process'] == 2 || $this->data['AuxElm']['process'] == 3)
					{
						$conditions = array();
						$conditions['and']['role_id'] = $id;
						$this->$model->User->recursive = -1;
						$users = $this->$model->User->find('all', array('conditions' => $conditions));
						
						$users_ids = array();
						foreach($users as $user)
						{
							$users_ids[] = $user['User']['id'];
						}
						
						$conditions = array();
						$conditions['and']['user_id'] = $users_ids;
						$role_users = $this->$model->User->UsersRole->find('all', array('conditions' => $conditions));
						foreach($role_users as $lu)
							$this->$model->User->UsersRole->delete($lu['UsersRole']['id']);
						
						foreach($users_ids as $user_id)
						{
							if($this->data["AuxElm"]["InitialRole"])
	                        {
	                        	foreach($this->data["AuxElm"]["InitialRole"] as $role_id=>$include)
	                            {
	                            	if($include)
									{
										$role_user_save = array();
										$role_user_save['UsersRole'] = array();
										$role_user_save['UsersRole']['user_id'] = $user_id;
										$role_user_save['UsersRole']['role_id'] = $role_id;
										$this->$model->User->UsersRole->saveAll($role_user_save);
									}
	                         }
	                        }
						}
					}
                }
                else
                {
                        $this->$model->contain(array("InitialRole"));
                        $this->request->data = $this->$model->read(null, $id);
                        
                        $my_roles= $this->data["InitialRole"];
                        if($my_roles)
                        {
                                foreach($my_roles as $role)
                                {
                                        $this->request->data["AuxElm"]["InitialRole"][$role["id"]]=1;
                                }
                        }
                }
                
                //$roles= $this->$model->Location->find("all");
                
                //Example of HABTM
                $roles = $this->$model->find("list");
                $this->set(compact("roles"));
        }

	function visible_folders($id, $tab=false)
	{
		$model= "Role";
		$controller= "Roles";
		$item= __("Folder");
		
		if($tab)
		{
			list($aux, $tab)= explode("_", $tab);
			$this->Session->write("TabPermissions", $tab);
		}
		
		$this->set("title_for_layout", __("Edit")." ".$item." ".__("Selected Folders"));
		
		$this->$model->id = $id;
	    if (!$this->$model->exists()) 
	    {
			throw new NotFoundException(__('Invalid '.$item));
	    }
		
		$conditions = array();
		$conditions['and']['DefaultFolders.role_id'] = $id;
		
        $folders = $this->$model->DefaultFolders->find("all", array('conditions' => $conditions, 'order' => array('DefaultFolders.folder ASC')));
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			
			if($this->data['AuxElm']['process'] == 1 || $this->data['AuxElm']['process'] == 3)
			{
			
				foreach($folders as $folder)
				{
					$this->$model->DefaultFolders->delete($folder['DefaultFolders']['id']);
				}
				
				foreach($this->data[$model] as $data_folder)
				{
					$data_to_save_folder = array();
					$data_to_save_folder['DefaultFolders'] = array();
					
					
					$folder = $data_folder['DefaultFolders']['folder'];
					$data_to_save_folder['role_id'] = $id;
					$data_to_save_folder['folder'] = $folder;
					
					$this->$model->DefaultFolders->saveAll($data_to_save_folder);
				}
			}
			
			if($this->data['AuxElm']['process'] == 2 || $this->data['AuxElm']['process'] == 3)
			{
				$conditions = array();
				$conditions['and']['User.role_id'] = $id;
				$users = $this->$model->User->find('list', array('conditions' => $conditions));
				
				$users_ids = array();
				foreach($users as $user_id => $name)
				{
					$users_ids[] = $user_id;
				}
				
				$conditions = array();
				$conditions['and']['user_id'] = $users_ids;
				$folders = $this->$model->User->Folders->find('list',  array('conditions' => $conditions));
				
				foreach($folders as $folder_id => $folder_name)
				{
					$this->$model->User->Folders->delete($folder_id);
				}
				
				foreach($users_ids as $user_id)
				{
					foreach($this->data[$model] as $data_folder)
					{
						$data_to_save_folder = array();
						$data_to_save_folder['Folders'] = array();
						
						
						$folder = $data_folder['DefaultFolders']['folder'];
						$data_to_save_folder['user_id'] = $user_id;
						$data_to_save_folder['folder'] = $folder;
						
						$this->$model->User->Folders->saveAll($data_to_save_folder);
					}
				}
			}
			
			$this->Utils->flash($item, "success_update");
           /* if($this->request->is('ajax'))
            {
                    $this->layout= "empty";
                    $this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
                    $this->set("close", true);
                    return;
            }
            else
            	$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
			*/
			$folders = $this->data[$model];
		}
        
        $this->request->data[$model] = $folders;
        
        $this->set(compact("folders"));
	}

	function select_folder($i=null)
	{
		$childrens = $this->getDirectory('files');
		
		$x = array();
		$x[0]['data'] = "/";
		$x[0]['attr'] = array('id' => '_', 'path' => '/');
		
		if($childrens)
			$x[0]['children'] = $childrens;
		
		$this->set(compact('x', 'i'));
	}
	
	function getDirectory( $path = '.', $level = 0, $only_folders = true ){
		
		$arreglo = array();
		
		$i = 0;

    $ignore = array( 'cgi-bin', '.', '..' );
    // Directories to ignore when listing output. Many hosts 
    // will deny PHP access to the cgi-bin. 

    $dh = @opendir( $path ); 
    // Open the directory to the handle $dh
    
	$view_path = preg_replace("/files\/{0,1}/", "", $path);
     
    while( false !== ( $file = readdir( $dh ) ) ){ 
    // Loop through the directory 
        if( !in_array( $file, $ignore ) ){ 
        // Check that this file is not to be ignored 
             
            //$spaces = str_repeat( '&nbsp;', ( $level * 4 ) ); 
            // Just to add spacing to the list, to better 
            // show the directory tree. 
             
            if( is_dir( "$path/$file" ) ){ 
            // Its a directory, so we need to keep reading down... 
             
                //echo "<strong>$spaces $file</strong><br />";
                $arreglo[$i]['data'] = $file;
				if($view_path != "")
				{
                	$arreglo[$i]['attr'] = array('id' => str_replace("/", "_", "/$view_path/$file"), 'path' => "/$view_path/$file");
                }
				else
				{
					$arreglo[$i]['attr'] = array('id' => str_replace("/", "_", "/$file"), 'path' => "/$file");
				}
				
				if($this->getDirectory( "$path/$file", ($level+1) ) != null)
				{
                	$arreglo[$i]['children'] = $this->getDirectory( "$path/$file", ($level+1) );
				}
				$i++;
                // Re-call this same function but on a new directory. 
                // this is what makes function recursive. 
             
            } else { 
             
                //echo "$spaces $file<br />"; 
                // Just print out the filename 
             
            } 
         
        } 
     
    } 
     return $arreglo ? $arreglo : null;
    closedir( $dh );
    // Close the directory handle 

	}
	
	function locations_permissions($id = null, $tab=false) 
	{
		$model= "Role";
		$controller= "Roles";
		$item= __("Role");
		
		if($tab)
		{
			list($aux, $tab)= explode("_", $tab);
			$this->Session->write("TabPermissions", $tab);
		}
		
		$this->set("title_for_layout", __("Edit")." ".$item." ".__("Locations Permissions"));   
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			if($this->data['AuxElm']['process'] == 1 || $this->data['AuxElm']['process'] == 3)
			{
				$this->request->data["DefaultLocation"]= array();
				
				$conditions = array();
				$conditions['and']['role_id'] = $id;
				$this->$model->DefaultLocations->recursive = -1;
				$d_locations = $this->$model->DefaultLocations->find('all', array('conditions' => $conditions));
				
				foreach($d_locations as $d_location)
				{
					$this->$model->DefaultLocations->delete($d_location['DefaultLocations']['id']);
				}
	            
				if($this->data["AuxElm"]["Locations"])
				{
					foreach($this->data["AuxElm"]["Locations"] as $location_id=>$include)
					{
						if($include)
							$this->request->data["DefaultLocations"][]['location_id']= $location_id;
					}
				}
				
				$this->$model->create();
				if ($this->$model->saveAll($this->request->data)) 
				{
					$this->Utils->flash($item, "success_add");
				} 
				else 
				{
					$this->Utils->flash($item, "error_add");
				}
			}
			
			if($this->data['AuxElm']['process'] == 2 || $this->data['AuxElm']['process'] == 3)
			{
				$conditions = array();
				$conditions['and']['role_id'] = $id;
				$this->$model->User->recursive = -1;
				$users = $this->$model->User->find('all', array('conditions' => $conditions));
				
				$users_ids = array();
				foreach($users as $user)
				{
					$users_ids[] = $user['User']['id'];
				}
				
				$conditions = array();
				$conditions['and']['user_id'] = $users_ids;
				$this->$model->User->LocationsUser->recursive = -1;
				$locations_users = $this->$model->User->LocationsUser->find('all', array('conditions' => $conditions));
				foreach($locations_users as $lu)
					$this->$model->User->LocationsUser->delete($lu['LocationsUser']['id']);
				
				foreach($users_ids as $user_id)
				{
					if($this->data["AuxElm"]["Locations"])
					{
						$user_save = array();
						$user_save['User']['id'] = $user_id;
						foreach($this->data["AuxElm"]["Locations"] as $location_id=>$include)
						{
							if($include)
							{
								$user_save['Location']['Location'][] = $location_id;
							}
						}
						$this->$model->User->saveAll($user_save);
					
					}
				}
				$this->Utils->flash($item, "success_add");
			}
			
		}
		else
		{
			$this->$model->contain(array("DefaultLocations"));
			$this->request->data = $this->$model->read(null, $id);
			
			$my_locations= $this->data["DefaultLocations"];
			
			if($my_locations)
			{
				foreach($my_locations as $location)
				{
					$this->request->data["AuxElm"]["Locations"][$location["location_id"]]=1;
				}
			}
		}
		
		$this->$model->User->Location->contain("Route.name");
		$locations= $this->$model->User->Location->find("all");
		
		$grouped_locations= array();
		
		if($locations)
		{
			foreach($locations as $location)
			{
				$grouped_locations[$location["Location"]["route_id"]][]= $location;		
			}	
		}
		
		$this->set(compact("grouped_locations"));
	}

	function list_roles()
	{
		$model = "Role";
		
		$roles= $this->$model->find("list", array("order"=>array("Role.name ASC")));
		return $roles;
	}
	
	function select()
	{
		$model = "Role";
		if($this->request->is("post"))
		{
			$this->Session->write("role_id", $this->request->data[$model]['id']);
			
			$this->Utils->flash_simple(__("The role has been changed"), "success");
			
			$referer = Router::parse($this->referer(null, true));
			
			$redirect =  array("plugin"=>null, "controller"=>$referer['controller']);
			
			foreach($referer['pass'] as $param)
			{
				array_push($redirect, $param);
			}
			
			$this->redirect($redirect);
		}
	}
	
	function path_domain()
	{
		$childrens = $this->getDirectory('files');
		
		$x = array();
		$x[0]['data'] = "/";
		$x[0]['attr'] = array('id' => '_', 'path' => '/');
		
		if($childrens)
			$x[0]['children'] = $childrens;
		
		$this->set(compact('x'));
	}

}
