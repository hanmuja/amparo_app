<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController 
{
	public $components= array("FriendlyPermissions");
	
	function beforeFilter(){
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
		$this->set(compact("model", "controller", "item"));
	}
	
	function index(){
    	/**
		 * Add this at the begining of every action, so inside the action we always know the current controller, model and item name.
		 */
        $model= "User";
		$controller= "Users";
		$item= __("User");
     	
        $this->set("title_for_layout", __("Users"));   
		
		$conditions= $this->CustomTable->get_conditions($controller);
		$conditions["and"]["$model.pending ="]= 0;
		
		$this->Paginator->settings= array($model=>array("order"=>array($model.".fullname"=>"asc")));
	
		$paginated= $this->CustomTable->isPaginated();
		
		$this->$model->contain("Role.name");
		
		if(!$this->request->is("ajax"))
                {
                  $conditions["and"]["$model.retired ="]= 0;
                  $this->Session->write("Comparators.$controller.$model.retired", "equal");
                  $this->Session->write("Filters.$controller.$model.retired", "0");
                }
		
		$all= $this->paginate($conditions);
		
		$this->set(compact('all'));
        $this->set(compact("paginated"));
		$this->set("link_group", "users_and_permissions");
		$this->set("current_link", "Users");
		
		$retired_options= array();
                $retired_options[]= array("value"=>"1", "display"=>__("Yes"), "comparator"=>"equal");
                $retired_options[]= array("value"=>"0", "display"=>__("No"), "comparator"=>"equal");
                
                $this->set(compact("retired_options"));
    }
    
    
    function pending(){
        /**
         * Add this at the begining of every action, so inside the action we always know the current controller, model and item name.
         */
        $model= "User";
        $controller= "Users";
        $item= __("User");
        
        $this->set("title_for_layout", __("Users"));   
        
        $conditions= $this->CustomTable->get_conditions($controller);
        $conditions["and"]["$model.pending ="]= 1;
        
        $this->Paginator->settings= array($model=>array("order"=>array($model.".fullname"=>"asc")));
        
        $paginated= $this->CustomTable->isPaginated();
        
        $this->$model->contain("Role.name");
        
        if(!$this->request->is("ajax"))
        {
            $conditions["and"]["$model.retired ="]= 0;
            $this->Session->write("Comparators.$controller.$model.retired", "equal");
            $this->Session->write("Filters.$controller.$model.retired", "0");
        }
        
        $all= $this->paginate($conditions);
        
        $this->set(compact('all'));
            $this->set(compact("paginated"));
            $this->set("link_group", "users_and_permissions");
            $this->set("current_link", "Users");
    }
    
	
	function add(){
		$model= "User";
		$controller= "Users";
		$item= __("User");
     	
        $this->set("title_for_layout", __("Add ".$item));   
		
		if($this->request->is('post')){
			//password with length=8 including 2 capital letters, 1 number, 2 symbols
			$password= $this->Utils->generate_password(8, 2, 1, 2);
			
			//This password will be encrypted by the beforeSave in the User model.
			$this->request->data[$model]["password"]= $password;	
			
			//Some default values
			$this->request->data[$model]["retired"]=0;
			$this->request->data[$model]["active_account"]=1;
			$this->request->data[$model]["password_changed"]=1;
			$this->request->data[$model]["is_developer"]=0;
			
			if($this->Auth->user())
				$this->request->data[$model]["created_by"]= $this->Auth->user("id");
			
			/*****INITIAL LOCATIONS USERS*****/
                                
			$this->$model->contain('Role');
			$this->$model->Role->contain('DefaultLocations.location_id');
			$initial_locations = $this->$model->Role->read(null, $this->request->data[$model]['role_id']);
			
			$this->request->data['LocationsUser'] = array();
			
			if($initial_locations)
			{
			  foreach($initial_locations['DefaultLocations'] as $initial_location)
			  {
			  	$this->request->data["Location"]["Location"][]= $initial_location['location_id'];
			  }
			}
			
			/*****END LOCATIONS***/
			
			/*****INITIAL ROLES USERS*****/
                                
			$this->$model->contain('Role');
			$this->$model->Role->contain('InitialRole.id');
			$initial_roles = $this->$model->Role->read(null, $this->request->data[$model]['role_id']);
			
			$this->request->data['RoleCanSee'] = array();
			
			if($initial_roles)
			{
			  foreach($initial_roles['InitialRole'] as $initial_role)
			  {
				$this->request->data['RoleCanSee'][] = $initial_role['id'];
			  }
			}
			
			/*****END ROLES***/
			
			$this->$model->create();
			if ($this->$model->save($this->request->data)){
                          /****EMAIL****/
				App::uses("View", "View");
				App::uses("HtmlHelper", "View/Helper");
				
				$v= new View($this);
				$h= new HtmlHelper($v);
				
				//Send the email with the password information
				
                                $bcc = "";
                                $this->loadModel("Setting");
                                $conditions = array();
                                $conditions['and']['name']=SETTING_EMAIL_USER;
                                $smtt = $this->Setting->find('first', array('conditions'=> $conditions));
                                if($value = $smtt['Setting']['val'])
                                {
                                    $bcc = $value;
                                }
				
				$tag_values= array();
				$tag_values["RECIPIENT_FIRST"]= $this->data[$model]["first_name"];
				$tag_values["RECIPIENT_LAST"]= $this->data[$model]["last_name"];
				$tag_values["USERNAME"]= $this->data[$model]["username"];
				$tag_values["PASSWORD"]= $this->data[$model]["password"];
				$tag_values["APP_LINK"]= $h->url("/", true);
				$tag_values["APP_URL"]= $tag_values["APP_LINK"];
				$tag_values["ROOT_URL"]= $h->url('/', true);
				$conditions= array("EmailTemplate.name"=>USER_CREATION_TEMPLATE);
				$email= $this->data[$model]["email"];
				$this->Correo->send($email, $conditions, $tag_values, 'default', null, $bcc);
				
				/*****END EMAIL****/
				
				/**
				 * INITIAL VISIBLE FOLDERS
				 */
				$this->loadModel("DefaultFolders");
				$conditions = array();
				$conditions['and']['role_id'] = $this->request->data[$model]['role_id'];
				$this->DefaultFolders->recursive = -1;
				$default_folders = $this->DefaultFolders->find('all', array('conditions' => $conditions));
				$user_id = $this->$model->id;
				
				foreach($default_folders as $folder)
				{
					$folders = array();
					$folders['Folders'] = array();
					$folders['Folders']['user_id'] = $user_id;
					$folders['Folders']['folder'] = $folder['DefaultFolders']['folder'];
					$this->$model->Folders->saveAll($folders);
				}
				
				$this->Utils->flash($item, "success_add");
				
				if($this->request->is('ajax')){
					/**
					 * If this was an ajax request, we are inside a dialog, so we need to close the dialog and reload the index.
					 */
					if($this->request->data['Extra']['order'])
					{
						$this->layout= "empty";
						$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
						$this->set("url_load", array("plugin"=>null, "controller"=>$controller, "action"=>"full_permissions", $this->$model->id));
						$this->set("close", true);
						$this->set("permissions", true);
					}
					else
					{
						$this->layout= "empty";
						$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
						$this->set("close", true);
					}
					$this->render("form");
					return;
				}else{
					/**
					 * If this wasn't an ajax request, so we just redirect to the index.
					 */
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
				}
			}else{
				$this->Utils->flash($item, "error_add");
			}
		}
		
		$roles= $this->$model->Role->find("list", array("order"=>array("Role.name ASC")));
		$this->set(compact("roles"));
		
		$this->set("edit", false);
		$this->set("save_label", __("Add"));
		$this->render("form");
	}
	
	function edit($id){
		$model= "User";
		$controller= "Users";
		$item= __("User");
     	
        $this->set("title_for_layout", __("Edit ".$item));   
		
		$this->$model->id = $id;
		if (!$this->$model->exists()){
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if($this->request->is('post') || $this->request->is('put')){
			$this->$model->create();
			if($this->request->data['User']['last_four'] == '****')
                        {
                          unset($this->request->data['User']['last_four']);
                        }
			if ($this->$model->save($this->request->data)){
				$this->Utils->flash($item, "success_add");
				if($this->request->is('ajax')){
					
					if($this->request->data['Extra']['order'])
					{
						$this->layout= "empty";
						$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
						$this->set("url_load", array("plugin"=>null, "controller"=>$controller, "action"=>"full_permissions", $this->$model->id));
						$this->set("close", true);
						$this->set("permissions", true);
					}
					else
					{
						$this->layout= "empty";
						$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
						$this->set("close", true);
					}
					$this->render("form");
					return;
					
				}else{
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));	
				}
			}else{
				$this->Utils->flash($item, "error_add");
			}
		}else{
			$this->request->data = $this->$model->read(null, $id);
			if($this->request->data['User']['last_four'] != '')
                        {
                          $this->request->data['User']['last_four'] = '****';
                        }
		}
		$roles= $this->$model->Role->find("list", array("order"=>array("Role.name ASC")));
		$this->set(compact("roles"));
		
		$this->set("edit", true);
		$this->set("save_label", __("Edit"));
		$this->render("form");
	}
	
	function accept($id){
            $model= "User";
            $controller= "Users";
            $item= __("User");
            
            $this->set("title_for_layout", __("Accept Pending ".$item));   
            
            $this->$model->id = $id;
            if (!$this->$model->exists()){
                throw new NotFoundException(__('Invalid '.$item));
            }
            
            if($this->request->is('post') || $this->request->is('put')){
                
                //password with length=8 including 2 capital letters, 1 number, 2 symbols
                $password= $this->Utils->generate_password(8, 2, 1, 2);
                
                //This password will be encrypted by the beforeSave in the User model.
                $this->request->data[$model]["password"]= $password;    
                
                //Some default values
                $this->request->data[$model]["retired"]=0;
                $this->request->data[$model]["active_account"]=1;
                $this->request->data[$model]["password_changed"]=1;
                $this->request->data[$model]["is_developer"]=0;
                $this->request->data[$model]["pending"]=0;
                
                if($this->Auth->user())
                    $this->request->data[$model]["created_by"]= $this->Auth->user("id");
                
				/*****INITIAL LOCATIONS USERS*****/
                                
				$this->$model->contain('Role');
				$this->$model->Role->contain('DefaultLocations.id');
				$initial_locations = $this->$model->Role->read(null, $this->request->data[$model]['role_id']);
				
				$this->request->data['LocationsUser'] = array();
				
				if($initial_locations)
				{
				  foreach($initial_locations['DefaultLocations'] as $initial_location)
				  {
					$this->request->data["Location"]["Location"][]= $initial_location['location_id'];
				  }
				}
				
				/*****END LOCATIONS***/
				
                /*****INITIAL ROLES USERS*****/
                
                $this->$model->contain('Role');
                $this->$model->Role->contain('InitialRole.id');
                $initial_roles = $this->$model->Role->read(null, $this->request->data[$model]['role_id']);
                
                $this->request->data['RoleCanSee'] = array();
                
                if($initial_roles)
                {
                    foreach($initial_roles['InitialRole'] as $initial_role)
                    {
                        $this->request->data['RoleCanSee'][] = $initial_role['id'];
                    }
                }
                
                /*****END ROLES***/
                
				                
                $this->$model->create();
                
                if ($this->$model->save($this->request->data)){
					
					/**
					 * INITIAL VISIBLE FOLDERS
					 */
					$this->loadModel("DefaultFolders");
					$conditions = array();
					$conditions['and']['role_id'] = $this->request->data[$model]['role_id'];
					$this->DefaultFolders->recursive = -1;
					$default_folders = $this->DefaultFolders->find('all', array('conditions' => $conditions));
					$user_id = $this->$model->id;
					
					foreach($default_folders as $folder)
					{
						$folders = array();
						$folders['Folders'] = array();
						$folders['Folders']['user_id'] = $user_id;
						$folders['Folders']['folder'] = $folder['DefaultFolders']['folder'];
						$this->$model->Folders->saveAll($folders);
					}
					
                    $this->Utils->flash($item, "success_add");
                    
                    /******EMAIL ACCEPT********/
                    
                    App::uses("View", "View");
                    App::uses("HtmlHelper", "View/Helper");
                    
                    $v= new View($this);
                    $h= new HtmlHelper($v);
                    
                    //Send the email with the password information
                    
                    $bcc = "";
                    $this->loadModel("Setting");
                    $conditions = array();
                    $conditions['and']['name']=SETTING_EMAIL_USER;
                    $smtt = $this->Setting->find('first', array('conditions'=> $conditions));
                    if($value = $smtt['Setting']['val'])
                    {
                        $bcc = $value;
                    }
                    
                    $tag_values= array();
                    $tag_values["RECIPIENT_FIRST"]= $this->data[$model]["first_name"];
					$tag_values["RECIPIENT_LAST"]= $this->data[$model]["last_name"];
                    $tag_values["USERNAME"]= $this->data[$model]["username"];
                    $tag_values["PASSWORD"]= $this->data[$model]["password"];
                    $tag_values["APP_LINK"]= $h->url("/", true);
                    $tag_values["APP_URL"]= $tag_values["APP_LINK"];
					$tag_values["ROOT_URL"]= $h->url('/', true);
                    $conditions= array("EmailTemplate.name"=>USER_CREATION_TEMPLATE);
                    $email= $this->data[$model]["email"];
                    $this->Correo->send($email, $conditions, $tag_values, 'default', null, $bcc);
                    
                    /******END EMAIL ACCEPT********/
                    
					if($this->request->is('ajax')){
						/**
						 * If this was an ajax request, we are inside a dialog, so we need to close the dialog and reload the index.
						 */
						if($this->request->data['Extra']['order'])
						{
							$this->layout= "empty";
							$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"pending"));
							$this->set("url_load", array("plugin"=>null, "controller"=>$controller, "action"=>"full_permissions", $this->$model->id, 'pending'));
							$this->set("close", true);
							$this->set("permissions", true);
						}
						else
						{
							$this->layout= "empty";
							$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"pending"));
							$this->set("close", true);
						}
						$this->render("form");
						return;
					}else{
						/**
						 * If this wasn't an ajax request, so we just redirect to the index.
						 */
						$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'pending'));
					}
					
                }else{
                    $this->Utils->flash($item, "error_add");
                }
        }else{
            $this->request->data = $this->$model->read(null, $id);
            if($this->request->data['User']['last_four'] != '')
            {
                $this->request->data['User']['last_four'] = '****';
            }
        }
        $roles= $this->$model->Role->find("list", array("order"=>array("Role.name ASC")));
        $this->set(compact("roles"));
        
        $this->set("edit", true);
        $this->set("save_label", __("Accept"));
        $this->render("form");
    }       
	
	function delete($id = null) 
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
     	
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
	
	function delete_pending($id = null) 
	{
            $model= "User";
            $controller= "Users";
            $item= __("User");
            
            if ($this->request->is('post') || $this->request->is('put')) 
            {
                $this->$model->id = $id;
                if (!$this->$model->exists()) 
                {
                    throw new NotFoundException(__('Invalid '.$item));
                }
                
                $user = $this->$model->read(null, $id);
                
                if ($this->$model->delete($id)) 
                {
                    if($this->data[$model]['send_notification'])
                    {
                    /*******EMAIL******/
                        App::uses("View", "View");
                        App::uses("HtmlHelper", "View/Helper");
                        
                        $v= new View($this);
                        $h= new HtmlHelper($v);
                        
                        //Send the email with the password information
                        
                        $tag_values= array();
                        $tag_values["RECIPIENT_FIRST"]= $user[$model]["first_name"];
						$tag_values["RECIPIENT_LAST"]= $user[$model]["last_name"];
						$tag_values["ROOT_URL"]= $h->url('/', true);
                        $conditions= array("EmailTemplate.name"=>USER_REJECTED_TEMPLATE);
                        $email= $user[$model]["email"];
                        $this->Correo->send($email, $conditions, $tag_values);
                    /*******END EMAIL*****/
                    }
                    $this->Utils->flash($item, "success_delete");
                    
                    if($this->request->is('ajax'))
                    {
                        $this->layout= "empty";
                        $this->set("just_reload", true);
                        $this->set("close", true);
                        $this->render("delete_pending");
                        return;
                    }
                }
                $this->Utils->flash($item, "error_delete");
                $this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'pending'));
            }
            else
            {
                $this->request->data[$model]['id']= $id;
                $this->render("delete_pending");
                return;
            }
        }
	
	function retire($id = null){
		$model= "User";
		$controller= "Users";
		$item= __("User");
     	
		if (!$this->request->is('post')){
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		$one= array();
		$one[$model]["id"]= $id;
		$one[$model]["retired"]= 1;
		$one[$model]["retired_date"]= time();
		
		$one[$model]["retired_by"]= $this->Auth->user("id");
		
		$this->$model->create();
		if($this->$model->save($one)) 
		{
			$this->Utils->flash($item, "success_delete");
			$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
		}
		$this->Utils->flash($item, "error_delete");
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}

	function unretire($id=null)
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
     	
		if (!$this->request->is('post')) 
		{
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) 
		{
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		$one= array();
		$one[$model]["id"]= $id;
		$one[$model]["retired"]= 0;
		$one[$model]["retired_date"]= 0;
		$one[$model]["retired_by"]= 0;
		
		$this->$model->create();
		if($this->$model->save($one)) 
		{
			$this->Utils->flash($item, "success_update");
			$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
		}
		
		$this->Utils->flash($item, "error_update");
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}
	
	function login() 
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
		if($this->request->is('post')){
	        if($this->Auth->login()){
	        	//Here I write all the needed info in the session.
				$this->$model->Role->recursive= -1;
				$role= $this->$model->Role->findById($this->Auth->user("role_id"));
				$this->Session->write("Auth.Role", $role["Role"]);
				
				//Verify if the user has the secret questions
				/*$questions= $this->Auth->user("question1") && $this->Auth->user("question2") && $this->Auth->user("answer1") && $this->Auth->user("answer2");
				if(!$questions)
				{
					//Some kind of notification
				}*/
				
				//Get my locations
				if($this->Auth->user("all_locations")){
					$this->Session->write("my_locations", "all");
				}else{
					$this->$model->contain("Location");
					$me= $this->$model->findById($this->Auth->user("id"));
					
					$my_locations= array();
					if($me["Location"]){
						foreach($me["Location"] as $location){
							$my_locations[]= $location["id"]; 
						}
					}	
					$this->Session->write("my_locations", $my_locations);
				}
				
				//Get the permissions
				if(!$this->Auth->user("is_developer")){
					$this->PermissionsLoader->write_logged_permissions();
				}else{
					$this->PermissionsLoader->write_developer_permissions();
				}
				
				//Get Folders
				/*if(isset($this->Auth->user("all_folders")) && $this->Auth->user("all_folders"))
				{
					$this->Session->write("all_folders", true);
				}
				else {*/
					$conditions = array();
					$conditions['and']['user_id'] = $this->Auth->user("id");
					
					$this->$model->Folders->recursive = -1;
					$folders = $this->$model->Folders->find('all', array('conditions' => $conditions, 'order' => array('Folders.folder ASC')));
					
					$this->Session->write('folders', $folders);
				//}
				
				$this->Session->write('role_id', $this->Auth->user("role_id"));
				
				$root = '';
				$this->loadModel("Setting");
				$conditions = array();
				$conditions['and']['name']='root';
				$smtt = $this->Setting->find('first', array('conditions'=> $conditions));
				if($value = $smtt['Setting']['val'])
				{
					$root = $value;
					$this->Session->write('root', $root);
				}
				
	            //Before redirect, I must check if the user has any permission. If he doesn't, the app must redirect to a page which notify the user about it.
	            $permissions= $this->Session->read("Auth.Permissions");
				if($permissions){
					/**
					 * If the user has some permissions, need to check if he has permissions to the Auth.redirect url.
					 * I will use the ACL check function because I don't know the url's format.
					 * */
					if($this->Acl->check(array("User"=>array("id"=>$this->Auth->user("id"))), substr($this->Auth->redirect(), 1))){
						$this->redirect($this->Auth->redirect());	
					}else{
						$this->redirect(array("plugin"=>null, "controller"=>"pages", "action"=>"display", "home"));
					}
						
				}else{
					$this->redirect(array("plugin"=>null, "controller"=>"pages", "action"=>"display", "nopermissions"));
				}
	            
	        }else{
	        	$this->Utils->flash_simple(__('Invalid Username/Password combination.'), 'warning');
	        }
	    }else{
			//If this is post, and there is an user logged, redirect to auth redirect
			if($this->Auth->user()){
				if($this->Acl->check(array("User"=>array("id"=>$this->Auth->user("id"))), substr($this->Auth->redirect(), 1))){
					$this->redirect($this->Auth->redirect());	
				}else{
					$this->redirect(array("plugin"=>null, "controller"=>"pages", "action"=>"display", "home"));
				}
			}	
		}
	}

	function logout() 
	{
		//$this->Session->setFlash('Adios y nos vemos.');
		$this->Session->destroy();
		$this->redirect($this->Auth->logout());
	}
	
	function full_permissions($id= null, $action = 'index')
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
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
		$data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"locations_permissions", $id, $action);
		$tabs_data[]= $data;
                
	    $data= array();
	    $data["label"]= __("Visible Roles");
	    $data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"roles_can_see", $id, $action);
	    $tabs_data[]= $data;
		
		$data= array();
	    $data["label"]= __("Visible Folders");
	    $data["url"]= array("plugin"=>null, "controller"=>$controller, "action"=>"visible_folders", $id, $action);
	    $tabs_data[]= $data;
		
		$this->set(compact("tabs_data"));
	}
	
	function permissions($id = null, $tab=false) {
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
		if($tab) {
			list($aux, $tab)= explode("_", $tab);
			$this->Session->write("TabPermissions", $tab);
		}
		
		$this->set("title_for_layout", __('Edit %s Application Permissions', $item));   
		
		$this->$model->recursive = -1;
	    $one = $this->$model->find('first', array("conditions"=>array($model.".id"=>$id), "fields"=>array("id", "fullname")));
	
		if(!$one) {
			if($this->request->is('ajax')) {
				$this->layout= "empty";
				$this->set("close", true);
				$this->set("manual_flash", __("The User does not exist."));
				$this->set("manual_flash_type", "error_box");
				return;
			} else {
				$this->Utils->flash_simple(__("The User does not exist."), "error");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
			}
		}
		
		$this->$model->id = $id;
		$aro_node = $this->$model->node();
        if(empty($aro_node)) {
			if($this->request->is('ajax')) {
				$this->layout= "empty";
				$this->set("close", true);
				$this->set("manual_flash", __("The User's ARO does not exist."));
				$this->set("manual_flash_type", "error_box");
				return;
			} else {
				$this->Utils->flash_success(__("The User's ARO does not exist."), "error");
				$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'permissions'));
			}
		}
		
		$permissions = $this->PermissionsLoader->get_permissions_paths($id, $model);
		$this->loadModel('FriendlyPermissionsItem');
		$permissionsMenu = $this->FriendlyPermissionsItem->getPermissionsMenu($permissions);
		//debug($permissionsMenu);
		$this->set(compact('boxes_roles', 'one', 'permissionsMenu'));
	}
	
	function locations_permissions($id = null, $action='index', $tab=false) 
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
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
			
			if($this->request->data[$model]['all_locations'] == 0)
			{
				$this->request->data["Location"]= array();
	            
				if($this->data["AuxElm"]["Locations"])
				{
					foreach($this->data["AuxElm"]["Locations"] as $location_id=>$include)
					{
						if($include)
						$this->request->data["Location"]["Location"][]= $location_id;
					}
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
		else
		{
			$this->$model->contain(array("Location"));
			$this->request->data = $this->$model->read(null, $id);
			
			$my_locations= $this->data["Location"];
			if($my_locations)
			{
				foreach($my_locations as $location)
				{
					$this->request->data["AuxElm"]["Locations"][$location["id"]]=1;
				}
			}
		}
		
		$this->$model->Location->contain("Route.name");
		$locations= $this->$model->Location->find("all");
		
		$grouped_locations= array();
		
		if($locations)
		{
			foreach($locations as $location)
			{
				$grouped_locations[$location["Location"]["route_id"]][]= $location;		
			}	
		}
		
		$this->set(compact("grouped_locations"));
		
		//Example of HABTM
		/*$locations= $this->$model->Location->find("list");
		$this->set(compact("locations"));*/
	}
	
	function remember($id= null)
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
		if($this->Auth->user())
		{
			if(isset($this->params["named"]["logged"]))
			$this->data[$model]["username"]= $this->Auth->user("username");
		}
		//else
		//$this->layout= "unauth";
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			//If the username was sent, that's because I need to get the secret questions
			if(isset($this->request->data[$model]["username"]))
			{
				$username= $this->request->data[$model]["username"];
			
				if($current_user= $this->$model->findByUsername($username))
				{
					if($current_user[$model]["answer1"] && $current_user[$model]["answer2"])
					{
						unset($current_user[$model]["answer1"], $current_user[$model]["answer2"]);
						$this->set("secret_questions", true);
						$this->set("right_answers", false);
					}
					else
					{
						//If for some reason the user has not setup the secret questions, he still can ask for a reseted password to the email.
						$this->set("secret_questions", false);
					}
					
					unset($current_user[$model]["email"]);
					$this->request->data= $current_user;
				}
				else
				{
					unset($this->request->data[$model]);
					$this->Utils->flash($item, "error_invalid_username");
				}
			}
			//If the username wasn't sent, that's because the user sent the answers to the secret questions
			else
			{
				$this->set("secret_questions", true);
				
				$current_user= $this->$model->findById($this->request->data[$model]["id"]);
				
				if($this->request->data[$model]["answer1"] && $this->request->data[$model]["answer2"])
				{
					
					//If the answers are right
					if($current_user[$model]["answer1"]==AuthComponent::password($this->request->data[$model]["answer1"]) && $current_user[$model]["answer2"]==AuthComponent::password($this->request->data[$model]["answer2"]))
					{
						$this->set("right_answers", true);
					
						//If the answers where right, we can show a form to reset the password.
						//Generate a key to send to the form
						$key_base= AuthComponent::password(rand(1, 1000));
						//Save it on Session
						$this->Session->write("ChangePasswordKeyBase", $key_base);
						
						$key= AuthComponent::password($key_base.$current_user[$model]["id"]);
						$this->set(compact("key"));
						$this->data= $current_user;
					}
					//Si alguna de las respuestas es incorrecta
					else
					{
						$this->set("right_answers", false);
						$this->Utils->flash($item, "error_wrong_answer");
						unset($current_user[$model]["answer1"], $current_user[$model]["answer2"]);
						$this->request->data= $current_user;
					}
				}
				else
				{
					$this->set("right_answers", false);
					$this->Utils->flash($item, "error_wrong_answer");
					unset($current_user[$model]["answer1"], $current_user[$model]["answer2"]);
					$this->request->data= $current_user;
				}
			}
		}
	}
	
	function remember_email()
	{
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
		if (!$this->request->is('put')) 
		{
			throw new MethodNotAllowedException();
		}
		//In this action we must receive a user id and an email
		$current_user= $this->$model->findById($this->data[$model]["id"]);
		
		if($current_user[$model]["email"]==$this->data[$model]["email"])
		{
			$new_password= $this->Utils->generate_password(8, 2, 1, 2);
			
			$one= array();
			$one[$model]["id"]= $current_user[$model]["id"];
			$one[$model]["password"]= $new_password;
			$one[$model]["password_changed"]= 1;
			
			if($this->$model->save($one))
			{
				App::uses("View", "View");
				App::uses("HtmlHelper", "View/Helper");
				
				$v= new View($this);
				$h= new HtmlHelper($v);
				
				//Send the email with the password information
				$tag_values= array();
				$tag_values["RECIPIENT_FIRST"]= $current_user[$model]["first_name"];
				$tag_values["RECIPIENT_LAST"]= $current_user[$model]["last_name"];
				$tag_values["USERNAME"]= $current_user[$model]["username"];
				$tag_values["PASSWORD"]= $new_password;
				$tag_values["APP_LINK"]= $h->url("/", true);
				$tag_values["APP_URL"]= $tag_values["APP_LINK"];
				$tag_values["ROOT_URL"]= $h->url('/', true);
				$conditions= array("EmailTemplate.name"=>PASSWORD_RESET_TEMPLATE);
				$email= $current_user[$model]["email"];
				$this->Correo->send($email, $conditions, $tag_values);
				
				$this->Utils->flash_simple(__("Email sent to %s. Follow the instructions.", $email), "success");
			}
			
			$this->redirect(array("plugin"=>null, "controller"=>"pages", "action"=>"display", "home"));
		}
		//If the sent email is not the equal to the found email
		else
		{
			$this->Utils->flash($item, "error_recovery_email_not_found");
			
			if($current_user[$model]["answer1"] && $current_user[$model]["answer2"])
			{
				unset($current_user[$model]["answer1"], $current_user[$model]["answer2"]);
				$this->set("secret_questions", true);
				$this->set("right_answers", false);
			}
			else
			{
				$this->set("secret_questions", false);
				$this->set("right_answers", false);
			}
			unset($current_user[$model]["email"]);
			$this->request->data= $current_user;
			
			$this->render("remember");
		}
	}	
	
	function update_account()
	{
          $id = $this->Auth->user("id");
          
          $model= "User";
          $controller= "Users";
          $item= __("User");
        
          $this->set("title_for_layout", __("Update my Account"));   
                
          $this->$model->id = $id;
          if (!$this->$model->exists()){
                  throw new NotFoundException(__('Invalid '.$item));
          }
          
          if($this->request->is('post') || $this->request->is('put')){
                  $this->$model->create();
                  if ($this->$model->save($this->request->data)){
                          $this->Utils->flash($item, "success_add");
                          if($this->request->is('ajax')){
                                  $this->layout= "empty";
                                  $this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
                                  $this->set("close", true);
                                  $this->render("form");
                                  return;
                          }else{
                                  $this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index')); 
                          }
                  }else{
                          $this->Utils->flash($item, "error_add");
                  }
          }else{
                  $this->request->data = $this->$model->read(null, $id);
          }
          $roles= $this->$model->Role->find("list", array("order"=>array("Role.name ASC")));
          $this->set(compact("roles"));
          
          $this->set("edit", true);
          $this->set("save_label", __("Edit"));
          $this->render("form_account");
        }
	
	function change_password()
	{
          $model= "User";
          $controller= "Users";
          $item= __("User");
          
          if($this->request->is('post'))
          {
            $id = $this->Auth->user("id");
            $this->$model->id = $id;
            if (!$this->$model->exists()){
                    throw new NotFoundException(__('Invalid '.$item));
            }
            
            $datos = $this->request->data[$model];
            $usuario = $this->$model->findById($id);
            
            if(AuthComponent::password($datos['password_old']) == $usuario[$model]['password'])
            {
              if($datos['password_old'] == $datos['password_new'])
              {
                unset($this->request->data[$model]);
                $this->Utils->flash_simple(__("New Password and Current Password CANNOT be the same."), "error");
              }
              else
              {
                if($datos['password_new'] == $datos['password_repeat'])
                {
                  preg_match('/^[A-z0-9]{6,14}$/i', $datos['password_new'], $result);
                  if(count($result) > 0)
                  {
                    unset($this->request->data[$model]['password_new'], $this->request->data[$model]['password_old'], $this->request->data[$model]['password_repeat']);
                    $this->request->data[$model]['password'] = $datos['password_new'];
                    $this->request->data[$model]['password_changed'] = 0;
                    
                    if ($this->$model->save($this->request->data))
                    {
                      $this->Session->destroy();
                      $this->Utils->flash_simple(__("Your Password has been updated."), "success");
                      $this->Auth->authError = __('Your Password has been updated.');
                      $this->redirect($this->Auth->logout());
                      //$this->redirect(array("plugin"=>null, "controller"=>"Pages", "action"=>"display", "home"));
                    }
                  }
                  else
                  {
                    unset($this->request->data[$model]);
                    $this->Utils->flash_simple(__("Your New Password MUST be between 6 and 14 alphanumeric characters."), "error");
                  }
                }
                else
                {
                  unset($this->request->data[$model]);
                  $this->Utils->flash_simple(__("New Password and Re-entered Password DO NOT match."), "error");
                }
              }
            }
            else
            {
              unset($this->request->data[$model]);
              $this->Utils->flash_simple(__("Current Password DOES NOT match our records."), "error");
            }
          }
        }

	function unlogged_change_password(){
		$model= "User";
		$controller= "Users";
		$item= __("User");
		
		$data_key= $this->data["AuxElm"]["key"];
		
		if($this->Session->check("ChangePasswordKeyBase") && AuthComponent::password($this->Session->read("ChangePasswordKeyBase").$this->data[$model]["id"])==$data_key)
		{
			if($this->request->is('post') || $this->request->is('put'))
			{
				if($this->data[$model]["password"] == $this->data["AuxElm"]["password"])
				{
					if($this->$model->save($this->data))
					{
						$this->Utils->flash_simple(__("Your Password has been updated."), "success");
						$this->redirect(array("plugin"=>null, "controller"=>"Users", "action"=>"login"));
					}
					else
					{
						$current_user= $this->$model->findById($this->data[$model]["id"]);
						$this->data= $current_user;
						
						$this->Utils->flash_simple(__("Your Password could not be changed."), "error");
						$this->set("secret_questions", true);
						$this->set("right_answers", true);
						$this->set("key", $data_key);
						
						$this->render("remember");
					}
				}
				else 
				{
					$current_user= $this->$model->findById($this->data[$model]["id"]);
					$this->data= $current_user;
					
					$this->Utils->flash_simple(__("The Passwords DO NOT match."), "error");	
					$this->set("secret_questions", true);
					$this->set("right_answers", true);
					$this->set("key", $data_key);
					
					$this->render("remember");
				}
			}	
			else 
			{
				$this->redirect(array("plugin"=>null, "controller"=>"Pages", "action"=>"display", "home"));
			}	
		}
		else 
		{
			$this->redirect(array("plugin"=>null, "controller"=>"Pages", "action"=>"display", "home"));
		}
		
	}
	
	function roles_can_see($id = null, $action='index', $tab=false) 
        {
                $model= "User";
                $controller= "Users";
                $item= __("User");
                
                if($tab)
                {
                        list($aux, $tab)= explode("_", $tab);
                        $this->Session->write("TabPermissions", $tab);
                }
                
                $this->set("title_for_layout", __("Edit")." ".$item." ".__("Visible Roles"));   
                
                $this->$model->id = $id;
                if (!$this->$model->exists()) 
                {
                        throw new NotFoundException(__('Invalid '.$item));
                }
                
                if($this->request->is('post') || $this->request->is('put'))
                {
                	
					if($this->request->data[$model]['all_roles'] == 0)
					{
					
                        $this->request->data["RoleCanSee"]= array();
            
                        if($this->data["AuxElm"]["RoleCanSee"])
                        {
                                foreach($this->data["AuxElm"]["RoleCanSee"] as $role_id=>$include)
                                {
                                        if($include)
                                        $this->request->data["RoleCanSee"][]= $role_id;
                                }
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
                else
                {
                        $this->$model->contain(array("RoleCanSee"));
                        $this->request->data = $this->$model->read(null, $id);
                        
                        $my_roles= $this->data["RoleCanSee"];
                        if($my_roles)
                        {
                                foreach($my_roles as $role)
                                {
                                        $this->request->data["AuxElm"]["RoleCanSee"][$role["id"]]=1;
                                }
                        }
                }
                
                //$roles= $this->$model->Location->find("all");
                
                //Example of HABTM
                $this->$model->contain('Role');
                $roles = $this->$model->Role->find("list");
                $this->set(compact("roles"));
        }
        
        
    function register()
    {
        $model= "User";
        $controller= "Users";
        $item= __("User");
        
        if($this->request->is('post'))
        {
            $data = $this->request->data;
            $data[$model]['pending'] = 1;
            if($this->$model->saveAll($data))
            {
                /********EMAIL*********/
                App::uses("View", "View");
                App::uses("HtmlHelper", "View/Helper");
                
                $v= new View($this);
                $h= new HtmlHelper($v);
                
                $bcc = "";
                $this->loadModel("Setting");
                $conditions = array();
                $conditions['and']['name']=REGISTER_ADMIN;
                $smtt = $this->Setting->find('first', array('conditions'=> $conditions));
                if($value = $smtt['Setting']['val'])
                {
                    $bcc = $value;
                }
                
                $tag_values= array();
                $tag_values["RECIPIENT_FIRST"]= $this->data[$model]["first_name"];
				$tag_values["RECIPIENT_LAST"]= $this->data[$model]["last_name"];
                $tag_values["USERNAME"]= $this->data[$model]["username"];
                $tag_values["COMMENT"]= $this->data[$model]["pending_comment"];
				$tag_values["ROOT_URL"]= $h->url('/', true);
                $conditions= array("EmailTemplate.name"=>USER_REGISTER_TEMPLATE);
                $email= $this->data[$model]["email"];
                $this->Correo->send($email, $conditions, $tag_values, 'default', null, $bcc);
                /*******END EMAIL*******/
                
                $this->Utils->flash_simple(__('Your registration request is being processed.'), 'success');
                $this->redirect(array("plugin"=>null, "controller"=>$controller, "action"=>"login"));
            }
        }
    }

	function visible_folders($id, $action='index', $tab=false)
	{
		$model= "User";
		$controller= "Users";
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
		$conditions['and']['Folders.user_id'] = $id;
		
        $folders = $this->$model->Folders->find("all", array('conditions' => $conditions, 'order' => array('Folders.folder ASC')));
		
		if($this->request->is('post') || $this->request->is('put'))
		{
			
			foreach($folders as $folder)
			{
				$this->$model->Folders->delete($folder['Folders']['id']);
			}

			$folders = array();
			
			if(isset($this->data[$model]))
			{
				foreach($this->data[$model] as $data_folder)
				{
					$data_to_save_folder = array();
					$data_to_save_folder['Folders'] = array();
					
					
					$folder = $data_folder['Folders']['folder'];
					$data_to_save_folder['user_id'] = $id;
					$data_to_save_folder['folder'] = $folder;
					
					$this->$model->Folders->saveAll($data_to_save_folder);
				}
				
				$folders = $this->data[$model];
			}
			
			$this->Utils->flash($item, "success_update");
		}
		else
        	$this->request->data['User'] = $folders;
        
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

}
