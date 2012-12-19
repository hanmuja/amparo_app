<?php
App::uses('AppController', 'Controller');
/**
 * FriendlyPermissionsItems Controller
 *
 * @property FriendlyPermissionsItem $FriendlyPermissionsItem
 */
class FriendlyPermissionsItemsController extends AppController {
	function beforeFilter() {
        parent::beforeFilter();
		$this->Auth->allowedActions = array('saveOpenState'); 
        $model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
        
        $this->set(compact('model', 'controller', 'item'));
    }
	
	function add($friendly_permissions_table_id, $parent_id=null) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		if ($this->request->is('post')) {
			$this->request->data[$model]['parent_id'] = $parent_id;
			$this->request->data[$model]['friendly_permissions_table_id'] = $friendly_permissions_table_id;
			$this->$model->create();
			if ($this->$model->save($this->request->data)) {
				$this->Utils->flash($item, 'success_add');
				
				if ($this->request->is('ajax')) {
					$this->layout= 'empty';
					$this->set('url_redirect', array('plugin'=>null, 'controller'=>'FriendlyPermissionsTables', 'action'=>'paths', $friendly_permissions_table_id));
					$this->set('close', true);
					$this->set('divUpdate', 'fp_sections');
					$this->render('form');
					return;
				} else {
					$this->redirect(array('plugin'=>null, 'controller'=>$controller, 'action' => 'index'));
				}
			} 
			else{
				$this->Utils->flash($item, 'error_add');
			}
		}
		$this->set('edit', false);
		$this->render('form');
	}
	
	function edit($id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid %s', $item));
		}
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->$model->create();
			if ($this->$model->save($this->request->data)) {
				$this->Utils->flash($item, "success_edit");
				$friendly_permissions_table_id = $this->$model->field('friendly_permissions_table_id');
				if ($this->request->is('ajax')) {
					$this->layout= 'empty';
					$this->set('url_redirect', array('plugin'=>null, 'controller'=>'FriendlyPermissionsTables', 'action'=>'paths', $friendly_permissions_table_id));
					$this->set('close', true);
					$this->set('divUpdate', 'fp_sections');
					$this->render('form');
					return;
				} else {
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
				}
			} 
			else 
			{
				$this->Utils->flash($item, "error_edit");
			}
		}
		else
		{
			$this->request->data = $this->$model->read(null, $id);
		}
		
		$this->set('edit', true);
		$this->render('form');
	}
	
	function delete($id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		$friendly_permissions_table_id = $this->$model->field('friendly_permissions_table_id');
		if ($this->$model->delete($id)) {
			$this->Utils->flash($item, "success_delete");
			$this->redirect(array("plugin"=>null, "controller"=>'FriendlyPermissionsTables', 'action'=>'paths', $friendly_permissions_table_id));
		}
		$this->Utils->flash($item, "error_delete");
		$this->redirect(array("plugin"=>null, "controller"=>'FriendlyPermissionsTables', 'action'=>'paths', $friendly_permissions_table_id));
	}
	
	function toggleUserPermissions($id, $user_id, $currentPermission=false) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$paths = $this->$model->getItemPaths($id);
		
		if ($paths) {
			if ($currentPermission == 'granted') {
				foreach ($paths as $path) {
					$this->Acl->deny(array('model' => 'User', 'foreign_key' => $user_id), $path);
				}
			} else {
				foreach ($paths as $path) {
					$this->Acl->allow(array('model' => 'User', 'foreign_key' => $user_id), $path);
				}
			}
		}
		$this->redirect(array('plugin'=>null, 'controller'=>'Users', 'action'=>'permissions', $user_id));
	}
	
	function toggleRolePermissions($id, $role_id, $currentPermission=false) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$paths = $this->$model->getItemPaths($id);
		
		if ($paths) {
			if ($currentPermission == 'granted') {
				foreach ($paths as $path) {
					$this->Acl->deny(array('model' => 'Role', 'foreign_key' => $role_id), $path);
				}
			} else {
				foreach ($paths as $path) {
					$this->Acl->allow(array('model' => 'Role', 'foreign_key' => $role_id), $path);
				}
			}
		}
		$this->redirect(array('plugin'=>null, 'controller'=>'Roles', 'action'=>'permissions', $role_id));
	}

	function toggleUserPathPermission($user_id, $currentPermission=false) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$path = $this->data['path'];
		if ($currentPermission) {
			$this->Acl->deny(array('model' => 'User', 'foreign_key' => $user_id), $path);
		} else {
			$this->Acl->allow(array('model' => 'User', 'foreign_key' => $user_id), $path);
		}
		$this->redirect(array('plugin'=>null, 'controller'=>'Users', 'action'=>'permissions', $user_id));
	}
	
	function toggleRolePathPermission($role_id, $currentPermission=false) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$path = $this->data['path'];
		if ($currentPermission) {
			$this->Acl->deny(array('model' => 'Role', 'foreign_key' => $role_id), $path);
		} else {
			$this->Acl->allow(array('model' => 'Role', 'foreign_key' => $role_id), $path);
		}
		$this->redirect(array('plugin'=>null, 'controller'=>'Roles', 'action'=>'permissions', $role_id));
	}

	function saveOpenState($id, $state) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$this->Session->write('OpenState.'.$id, $state);
		echo $this->Session->read('OpenState.'.$id);
		exit;
	}

	function savePathsOpenState($id, $state) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$this->Session->write('PathsOpenState.'.$id, $state);
		echo $this->Session->read('PathsOpenState.'.$id);
		exit;
	}
	
	function authorizeAllUserPermissions($user_id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$paths = $this->$model->getActiveTablePaths();
		if ($paths) {
			foreach ($paths as $path) {
				$this->Acl->allow(array('model' => 'User', 'foreign_key' => $user_id), $path);
			}
		}
		$this->redirect(array("plugin"=>null, "controller"=>'Users', 'action'=>'full_permissions', $user_id));
	}
	
	function blockAllUserPermissions($user_id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$paths = $this->$model->getActiveTablePaths();
		if ($paths) {
			foreach ($paths as $path) {
				$this->Acl->deny(array('model' => 'User', 'foreign_key' => $user_id), $path);
			}
		}
		$this->redirect(array("plugin"=>null, "controller"=>'Users', "action"=>"full_permissions", $user_id));
	}

	function authorizeAllRolePermissions($role_id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$paths = $this->$model->getActiveTablePaths();
		if ($paths) {
			foreach ($paths as $path) {
				$this->Acl->allow(array('model' => 'Role', 'foreign_key' => $role_id), $path);
			}
		}
		$this->redirect(array("plugin"=>null, "controller"=>'Roles', 'action'=>'full_permissions', $role_id));
	}
	
	function blockAllRolePermissions($role_id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$paths = $this->$model->getActiveTablePaths();
		if ($paths) {
			foreach ($paths as $path) {
				$this->Acl->deny(array('model' => 'Role', 'foreign_key' => $role_id), $path);
			}
		}
		$this->redirect(array("plugin"=>null, "controller"=>'Roles', "action"=>"full_permissions", $role_id));
	}
	
	function resetUserPermissions($user_id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$this->loadModel('Aro');
		$this->loadModel('ArosAco');
		
		//get the aro
		$this->Aro->recursive = -1;
		$aro = $this->Aro->findByModelAndForeignKey('User', $user_id);
		
		$this->ArosAco->deleteAll(array('ArosAco.aro_id'=>$aro['Aro']['id']));
		$this->redirect(array("plugin"=>null, "controller"=>'Users', "action"=>"full_permissions", $user_id));
	}
	
	function resetRoleUsersPermissions($role_id) {
		$model = 'FriendlyPermissionsItem'; 
        $controller = 'FriendlyPermissionsItems'; 
        $item = __('Friendly Permissions Item');
		
		$this->loadModel('Aro');
		$this->loadModel('ArosAco');
		$this->loadModel('User');
		
		$this->User->contain();
		$users = $this->User->find('all', array('conditions'=>array('User.role_id'=>$role_id), 'fields'=>array('User.role_id', 'User.id')));
		$ids = array();
		if ($users) {
			foreach ($users as $user) {
				$ids[] = $user['User']['id'];
			}
		}
		$this->Aro->recursive = -1;
		$aros = $this->Aro->find('all', array('conditions'=>array('Aro.model'=>'User', 'Aro.foreign_key'=>$ids)));
		
		$arosIds = array();
		if ($aros) {
			foreach ($aros as $aro) {
				$arosIds[] = $aro['Aro']['id'];
			}
		}		
		
		if ($this->ArosAco->deleteAll(array('ArosAco.aro_id'=>$arosIds))) {
			$this->Utils->flash_simple(__('The user\'s permissions were reseted'), 'success');
		} else {
			$this->Utils->flash_simple(__('The user\'s permissions could not be reseted'), 'error');
		}
		$this->redirect(array("plugin"=>null, "controller"=>'Roles', "action"=>"full_permissions", $role_id));
	}
	
}
