<?php
App::uses('AppController', 'Controller');
/**
 * FriendlyPermissionsTables Controller
 *
 * @property FriendlyPermissionsTable $FriendlyPermissionsTable
 */
class FriendlyPermissionsTablesController extends AppController {
	public $helpers = array('Text');
	
	function beforeFilter() {
        parent::beforeFilter(); 
        $model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
        
        $this->set(compact('model', 'controller', 'item'));
    }
	
	function index() {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
		
		$this->set('title_for_layout', __('Friendly Permissions Tables'));   
                
        $conditions = $this->CustomTable->get_conditions($controller);
        $all = $this->paginate($conditions);
		
        $paginated = $this->CustomTable->isPaginated();
        
        $this->set(compact('all', 'paginated'));
	}
	
	function add() {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
		$this->set('title_for_layout', __('Add %s', $item));   
		
		if ($this->request->is('post')) {
			//Default values
			$this->request->data[$model]['created_by'] = $this->Auth->user('id');
			$this->request->data[$model]['active'] = 0;
			
			$this->$model->create();
			if ($this->$model->save($this->request->data)) {
				$this->Utils->flash($item, 'success_add');
				
				if ($this->request->is('ajax')) {
					$this->layout= 'empty';
					$this->set('url_redirect', array('plugin'=>null, 'controller'=>$controller, 'action'=>"index"));
					$this->set('close', true);
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
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
        $this->set('title_for_layout', __('Edit %s', $item));
		   
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid %s', $item));
		}
		
		if($this->request->is('post') || $this->request->is('put')) {
			$this->$model->create();
			if ($this->$model->save($this->request->data)) {
				$this->Utils->flash($item, "success_add");
				if($this->request->is('ajax')) {
					$this->layout= "empty";
					$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
					$this->set("close", true);
					$this->render("form");
					return;
				} else {
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
				}
			} else {
				$this->Utils->flash($item, "error_add");
			}
		} else {
			$this->request->data = $this->$model->read(null, $id);
		}
		
		$this->set('edit', true);
		
		$this->render('form');
	}

	function copy($id) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid %s', $item));
		}
		
		if($this->request->is('post') || $this->request->is('put')) {
			$this->$model->create();
			if ($this->$model->copy($id, $this->data[$model]['name'], $this->Auth->user('id'))) {
				$this->Utils->flash_simple(__('The %s was copied.', $item), 'success');
				if($this->request->is('ajax')) {
					$this->layout= "empty";
					$this->set("url_redirect", array("plugin"=>null, "controller"=>$controller, "action"=>"index"));
					$this->set("close", true);
					$this->render("form");
					return;
				} else {
					$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
				}
			} else {
				$this->Utils->flash_simple(__('The %s could not be copied.', $item), 'error');
			}
		}
	}
	
	function paths($id) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
		
		$acosInfo = $this->__getAcos($id);
		
		$conditions = array();
		$conditions['FriendlyPermissionsItem.friendly_permissions_table_id'] = $id;
		
		$contain = array();
		$contain['FriendlyPermissionsItemsAco']['fields'] = array('FriendlyPermissionsItemsAco.aco_path', 'FriendlyPermissionsItemsAco.id');
		$contain['FriendlyPermissionsItemsAco']['order'] = 'FriendlyPermissionsItemsAco.aco_path ASC';
		$this->$model->FriendlyPermissionsItem->contain($contain);
		$sections = $this->$model->FriendlyPermissionsItem->find('threaded', array('conditions'=>$conditions, 'order'=>'FriendlyPermissionsItem.name ASC'));
		$this->set(compact('acosInfo', 'sections', 'id'));
	}
	
	private function __getAcos($id) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
		
		$return = array();
		
		$this->loadModel('FriendlyPermissionsItemsAco');
		//Get all the acos related to this table
		$conditions = array();
		$conditions['FriendlyPermissionsItem.friendly_permissions_table_id'] = $id;
		
		$fields = array('DISTINCT FriendlyPermissionsItemsAco.aco_path', 'FriendlyPermissionsItem.friendly_permissions_table_id');
		$currentAcos = $this->FriendlyPermissionsItemsAco->find('all', array('fields'=>$fields, 'recursive'=>1, 'conditions'=>$conditions));
		$return['related'] = array();
		if ($currentAcos) {
			foreach ($currentAcos as $one) {
				$return['related'][] = $one['FriendlyPermissionsItemsAco']['aco_path'];
			}
		}
		$return['allAcos'] = $this->PermissionsLoader->get_acos_paths();
		return $return;
	}
	
	function activate($id = null) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
     	
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid %s', $item));
		}
		
		if ($this->$model->activate($id)) {
			$this->Utils->flash($item, 'success_activate');
			$this->redirect(array('plugin'=>null, 'controller'=>$controller, 'action'=>'index'));
		}
		$this->Utils->flash($item, 'error_activate');
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}
	
	function inactivate($id = null) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
     	
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid %s', $item));
		}
		
		if ($this->$model->saveField('active', 0)) {
			$this->Utils->flash($item, 'success_inactivate');
			$this->redirect(array('plugin'=>null, 'controller'=>$controller, 'action'=>'index'));
		}
		$this->Utils->flash($item, 'error_inactivate');
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}
	
	function delete($id = null) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
     	
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$this->$model->id = $id;
		if (!$this->$model->exists()) {
			throw new NotFoundException(__('Invalid '.$item));
		}
		
		if ($this->$model->delete($id)) {
			$this->Utils->flash($item, "success_delete");
			$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
		}
		$this->Utils->flash($item, "error_delete");
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action' => 'index'));
	}
	
	function filter($id) {
		$model = 'FriendlyPermissionsTable'; 
        $controller = 'FriendlyPermissionsTables'; 
        $item = __('Friendly Permissions Table');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		if ($this->request->is('post')) {
			$filterValue = $this->data['filter'];
			$filterValue = preg_replace('/\//', '\/', $filterValue);
			$allAcos = $this->PermissionsLoader->get_acos_paths();
			$matchAcos = array();
			foreach ($allAcos as $aPath) {
				if (preg_match('/.*'.$filterValue.'.*/i', $aPath)) {
					$matchAcos[] = $aPath;
				}
			}
			$this->loadModel('FriendlyPermissionsItemsAco');
			//Get all the acos related to this table
			$conditions = array();
			$conditions['FriendlyPermissionsItem.friendly_permissions_table_id'] = $id;
			
			$fields = array('DISTINCT FriendlyPermissionsItemsAco.aco_path', 'FriendlyPermissionsItem.friendly_permissions_table_id');
			$currentAcos = $this->FriendlyPermissionsItemsAco->find('all', array('fields'=>$fields, 'recursive'=>1, 'conditions'=>$conditions));
			$related = array();
			if ($currentAcos) {
				foreach ($currentAcos as $one) {
					$related[] = $one['FriendlyPermissionsItemsAco']['aco_path'];
				}
			}
			$this->set(compact('related', 'matchAcos'));
		}
	}
	
	private function __getAcoPath($acoId, $includeActionPath=false, $isFirst=true) {
		$this->loadModel('Aco');
		$this->Aco->id = $acoId;
		if (!$this->Aco->exists()) {
			throw new NotFoundException(__('Invalid %s', 'Aco'));
		}
		$aco = $this->Aco->read(array('Aco.parent_id', 'Aco.alias'));
		if ($aco['Aco']['parent_id']) {
			$acoPath = $this->__getAcoPath($aco['Aco']['parent_id'], $includeActionPath, false).$aco['Aco']['alias'].(($isFirst)?'':'/');
		} else {
			if ($includeActionPath) {
				$acoPath = 'controllers/';
			} else {
				$acoPath = '';
			}
		}
		
		return $acoPath;
	}

	function import()
	{
		$model = 'FriendlyPermissionsTable'; 
		$controller = 'FriendlyPermissionsTables'; 
		$item = __('Friendly Permissions Table');
		
		$passdbserver = "FanMafUk";
		
		$value = "/tmp/";
		$this->loadModel("Setting");
		$conditions = array();
		$conditions['and']['name']=SETTING_TMP_FRIENDLY;
		$smtt = $this->Setting->find('first', array('conditions'=> $conditions));
		if($v = $smtt['Setting']['val'])
		{
			$value = $v;
		}
		$route_to_save = $value;
		
		$port = "4444";
		
		//Dump of friendly permissions tables of server

		exec('mysqldump -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' arcade friendly_permissions_tables > '.$route_to_save.'friendly_permissions_tables.sql');
		exec('mysqldump -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' arcade friendly_permissions_items > '.$route_to_save.'friendly_permissions_items.sql');
		exec('mysqldump -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' arcade friendly_permissions_items_acos > '.$route_to_save.'friendly_permissions_items_acos.sql');
		
		//Drop tables local
		
		exec('mysql -uroot -e "drop table arcade.friendly_permissions_tables, arcade.friendly_permissions_items, arcade.friendly_permissions_items_acos"');
		
		//Add tables of server
		
		exec('mysql -uroot arcade < '.$route_to_save.'friendly_permissions_tables.sql');
		exec('mysql -uroot arcade < '.$route_to_save.'friendly_permissions_items.sql');
		exec('mysql -uroot arcade < '.$route_to_save.'friendly_permissions_items_acos.sql');
		
		$this->Utils->flash_simple(__('The Database was imported.'), 'success');
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
	}

	function export()
	{
		$model = 'FriendlyPermissionsTable'; 
		$controller = 'FriendlyPermissionsTables'; 
		$item = __('Friendly Permissions Table');
		
		$passdbserver = 'FanMafUk';
		
		$value = "/tmp/";
		$this->loadModel("Setting");
		$conditions = array();
		$conditions['and']['name']=SETTING_TMP_FRIENDLY;
		$smtt = $this->Setting->find('first', array('conditions'=> $conditions));
		if($v = $smtt['Setting']['val'])
		{
			$value = $v;
		}
		$route_to_save = $value;
		
		$port = "4444";
		
		//Dump of friendly permissions tables of server
		
		exec('mysqldump -uroot arcade friendly_permissions_tables > '.$route_to_save.'friendly_permissions_tables.sql');
		exec('mysqldump -uroot arcade friendly_permissions_items > '.$route_to_save.'friendly_permissions_items.sql');
		exec('mysqldump -uroot arcade friendly_permissions_items_acos > '.$route_to_save.'friendly_permissions_items_acos.sql');
		
		//Drop tables local
		
		exec('mysql -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' -e "drop table arcade.friendly_permissions_tables, arcade.friendly_permissions_items, arcade.friendly_permissions_items_acos"');
		
		//Add tables of server
		
		exec('mysql -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' arcade < '.$route_to_save.'friendly_permissions_tables.sql');
		exec('mysql -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' arcade < '.$route_to_save.'friendly_permissions_items.sql');
		exec('mysql -uroot -h127.0.0.1 -p'.$passdbserver.' -P'.$port.' arcade < '.$route_to_save.'friendly_permissions_items_acos.sql');
		
		$this->Utils->flash_simple(__('The Database was exported.'), 'success');
		$this->redirect(array("plugin"=>null, "controller"=>$controller, 'action'=>'index'));
	}
}
