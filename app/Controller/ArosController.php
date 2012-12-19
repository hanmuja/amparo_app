<?php
App::uses('AppController', 'Controller');
/**
 * Aros Controller
 *
 * @property Aro $Aro
 */
class ArosController extends AppController 
{
	function beforeFilter() 
	{
		parent::beforeFilter(); 
		
		/**
		 * Add this to every single controller, so in the view we always know which is the current controller, model, and item name.
		 * For example, in the index, the delete, edit and add links go to the current controller, so we can copy+paste the most of the views.
		 */
		$controller= "Aros";
		$model= "Aro";
		$item= __("Aro");
		
		$this->set(compact("model", "controller", "item"));
	}
	
	function build_missing_aros($run=false)
	{
		$controller= "Aros";
		$model= "Aro";
		$item= __("Aro");
		
		$this->loadModel("User");
		$this->loadModel("Role");
		
		$roles = $this->Role->find('list', array('recursive' => -1));
	 	
		$missing_aros = array('roles' => array(), 'users' => array());
	    
		foreach($roles as $role_id=>$role) 
		{
			/*
			 * Check if ARO for role exist
			 */
			$aro = $this->Aro->find('first', array('conditions' => array('model' => "Role", 'foreign_key' => $role_id)));
			
			if($aro === false) 
			{
				$missing_aros['roles'][$role_id] = $role;
			}
		}
		
		$users = $this->User->find('list', array('recursive' => -1));
		
		foreach($users as $user_id=>$user) 
		{
			/*
			 * Check if ARO for user exist
			 */
			$aro = $this->Aro->find('first', array('conditions' => array('model' => "User", 'foreign_key' => $user_id)));
			
			if(!$aro) 
			{
				$missing_aros['users'][$user_id] = $user;
			}
		}
		
		
		if($run)
		{	
			/*
			 * Complete roles AROs
			 */
			if(count($missing_aros['roles']) > 0)
			{
				foreach($missing_aros['roles'] as $k => $role)
				{
					$this->Aro->create(array('parent_id' 		=> null,
												'model' 		=> "Role",
												'foreign_key' 	=> $k,
												'alias'			=> $role));
					
					if($this->Aro->save())
					{
						unset($missing_aros['roles'][$k]);
					}
				}
			}
			
			/*
			 * Complete users AROs
			 */
			if(count($missing_aros['users']) > 0)
			{
				foreach($missing_aros['users'] as $k => $user)
				{
					/*
					 * Find ARO parent for user ARO
					 */
					
					$this->User->recursive= -1;
					$u= $this->User->findById($k);
					$parent_id = $this->Aro->field('id', array('model' => "Role", 'foreign_key' => $u["User"]["role_id"]));
					if(!$parent_id)
					$parent_id=null;
					
					if($parent_id !== false)
					{
						$this->Aro->create(array('parent_id' 		=> $parent_id,
													'model' 		=> "User",
													'foreign_key' 	=> $k,
													'alias'			=> $user));
						
						if($this->Aro->save())
						{
							unset($missing_aros['users'][$k]);
						}
					}
				}
			}
		}
		$this->set(compact('missing_aros', 'run'));
		
		$this->set("link_group", "acl");
		$this->set("current_link", "BuildAros");
	}
}
