<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 */
class AppController extends Controller{
	public $helpers= array("Html", "Js"=>array("Jquery"), "Number", "Form", "Session", "Dialog", "CustomTable", "Utils", "Paginator");
	public $components= array("Session", "RequestHandler", "CustomTable", "Auth", "Acl", "PermissionsLoader", "Paginator", "Utils", "Correo");
	
	function beforeFilter(){
    	$this->disableCache();
		
    	$this->Auth->authenticate = array(
    		'Form'=>array(
    			'userModel' => 'User',
    			'scope'=>array("User.retired"=>0, "User.active_account"=>1)
			)
    	);
		
    	$this->Auth->authorize = array('Actions'=>array("actionPath"=>"controllers"));

		if($this->Auth->User('id')) {
			$this->Auth->authError = __('You are not allowed to access that area.');
		} else {
			$this->Auth->authError = __('Your session has expired. Please log in.');
		}
    	$this->Auth->loginAction = array("plugin"=>NULL, 'controller' => 'Users', 'action' => 'login');
        $this->Auth->logoutRedirect = array("plugin"=>NULL, 'controller' => 'Users', 'action' => 'login');
        $this->Auth->loginRedirect = array("plugin"=>NULL, 'controller' => 'Events', 'action' => 'index');
		
    	$this->Auth->allowedActions= array("login", "display", "remember", "remember_email", "unlogged_change_password", "logout", "my_shortcuts", "register");
		
		//$this->Auth->allowedActions=array("*");
		
		if($this->Auth->user() && $this->Auth->user("is_developer")){
		    $this->Auth->allowedActions=array("*");
		}
		
		$this->set("is_ajax", $this->request->is('ajax'));
		
		if($this->Auth->user("password_changed") && !$this->request->is('ajax') && !in_array($this->request->params['action'], array('change_password', 'logout', 'list_roles')))
                {
                  $this->Utils->flash_simple(__('You must change your password.'), 'warning');
                  $this->redirect(array("plugin"=>null, "controller"=>"Users", 'action' => 'change_password'));
                }
	}
	
	
    function  beforeRender(){
		//To avoid load values on the password fields in the form
		
		if(isset($this->request->data['User']['password']))
        unset($this->request->data['User']['password']);
		if(isset($this->request->data['AuxElm']['password']))
        unset($this->request->data['AuxElm']['password']);
		
    }
}
