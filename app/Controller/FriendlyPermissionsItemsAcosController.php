<?php
App::uses('AppController', 'Controller');
/**
 * FriendlyPermissionsItemsAcos Controller
 *
 * @property FriendlyPermissionsItemsAco $FriendlyPermissionsItemsAco
 */
class FriendlyPermissionsItemsAcosController extends AppController {
	public $helpers = array('Text');
	
	function beforeFilter() {
        parent::beforeFilter(); 
        $model = 'FriendlyPermissionsItemsAco'; 
        $controller = 'FriendlyPermissionsItemsAcos'; 
        $item = __('Friendly Permissions Item Aco');
        
        $this->set(compact('model', 'controller', 'item'));
    }

/**
 * 
 */
	function add() {
		$model = 'FriendlyPermissionsItemsAco'; 
        $controller = 'FriendlyPermissionsItemsAcos'; 
        $item = __('Friendly Permissions Item Aco');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		$status = 0;
		$data = array();
		if ($this->request->is('post')) {
			//Check if the item and the path are already related
			
			//debug($this->data);
			$conditions = array();
			$conditions[$model.'.aco_path'] = $this->data[$model]['aco_path'];
			$conditions[$model.'.friendly_permissions_item_id'] = $this->data[$model]['friendly_permissions_item_id'];
			
			$message = array();
			if ($this->$model->find('count', array('conditions'=>$conditions)) == 0) {
				$this->$model->create();
				if ($this->$model->save($this->request->data)) {
					$message['text']= __('The path has been related to selected item');
					$message['box_id']= 'success_box';
					$data = $this->data[$model];
					$data['id'] = $this->$model->id;
					$status = 1;
				} else {
					$message['text']= __('The path could not be related to selected item');
					$message['box_id']= 'error_box';
				}	
			} else {
				$message['text']= __('The path is already related to selected item');
				$message['box_id']= 'error_box';
			}
		}
		//echo json_encode(compact('status', 'message', 'data'));
		//exit;
		$itemAco = $data;
		$this->$model->FriendlyPermissionsItem->id = $this->data[$model]['friendly_permissions_item_id'];
		$friendly_permissions_table_id = $this->$model->FriendlyPermissionsItem->field('friendly_permissions_table_id'); 
		$this->set(compact('status', 'itemAco', 'friendly_permissions_table_id'));
	}

/**
 * 
 */
	function delete($id, $friendly_permissions_table_id) {
		$model = 'FriendlyPermissionsItemsAco'; 
        $controller = 'FriendlyPermissionsItemsAcos'; 
        $item = __('Friendly Permissions Item Aco');
		
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		
		//Need the path
		$this->$model->id = $id;
		$path = $this->$model->field('aco_path');
		$status = $this->$model->delete($id);
		
		$conditions = array();
		$conditions['FriendlyPermissionsItem.friendly_permissions_table_id'] = $friendly_permissions_table_id;
		$conditions['FriendlyPermissionsItemsAco.aco_path'] = $path;
		$isRelated = false;
		$this->$model->contain(array('FriendlyPermissionsItem.friendly_permissions_table_id'));
		if ($this->$model->find('first', array('conditions'=>$conditions))) {
			$isRelated = true;
		}
		
		$divPathId = 'path_'.str_replace('/', '-', $path);
		echo json_encode(compact('status', 'id', 'isRelated', 'divPathId'));
		exit;
	}
}
