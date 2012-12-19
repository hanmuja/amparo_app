<?php
App::uses('AppModel', 'Model');
/**
 * FriendlyPermissionsTable Model
 *
 * @property FriendlyPermissionsItem $FriendlyPermissionsItem
 */
class FriendlyPermissionsTable extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
	public $actsAs = array('Containable');
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'active' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created_by' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'FriendlyPermissionsItem' => array(
			'className' => 'FriendlyPermissionsItem',
			'foreignKey' => 'friendly_permissions_table_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function activate($id) {
		$ds = $this->getDataSource();
		$ds->begin();
		
		//Deactivate all the tables
		if ($this->updateAll(array($this->alias.'.active'=>0))) {
			$this->id = $id;
			if ($this->saveField('active', 1)) {
				$ds->commit();
				return true;
			} else {
				$ds->rollback();
				return false;
			}
		} else {
			return false;
		}
	}
	
	function copyItem($item, $id, $parent_id=null) {
		$item_id = $item['FriendlyPermissionsItem']['id'];
		unset($item['FriendlyPermissionsItem']['id']);
		$item['FriendlyPermissionsItem']['friendly_permissions_table_id'] = $id;
		$item['FriendlyPermissionsItem']['parent_id'] = $parent_id;
		
		$this->FriendlyPermissionsItem->create();
		if (!$this->FriendlyPermissionsItem->save($item)) {
			return false;
		}
		
		$current_id = $this->FriendlyPermissionsItem->id;
		//Get the acos
		$conditions = array();
		$conditions['FriendlyPermissionsItemsAco.friendly_permissions_item_id'] = $item_id;
		$acos = $this->FriendlyPermissionsItem->FriendlyPermissionsItemsAco->find('all', array('conditions'=>$conditions));
		
		if ($acos) {
			$newAcos = array();
			foreach ($acos as $aco) {
				$new = array();
				$new['FriendlyPermissionsItemsAco']['aco_path'] = $aco['FriendlyPermissionsItemsAco']['aco_path'];
				$new['FriendlyPermissionsItemsAco']['friendly_permissions_item_id'] = $current_id;
				$newAcos[] = $new;
			}
			if (!$this->FriendlyPermissionsItem->FriendlyPermissionsItemsAco->saveAll($newAcos)) {
				return false;
			}
		}

		//Get the children
		$conditions = array();
		$conditions['FriendlyPermissionsItem.parent_id'] = $item_id;
		$fields = array();
		$fields[] = 'FriendlyPermissionsItem.friendly_permissions_table_id';
		$fields[] = 'FriendlyPermissionsItem.name';
		$fields[] = 'FriendlyPermissionsItem.id';
		$this->FriendlyPermissionsItem->contain();
		$items = $this->FriendlyPermissionsItem->find('all', array('conditions'=>$conditions, 'fields'=>$fields));
		
		if ($items) {
			foreach ($items as $item) {
				if (!$this->copyItem($item, $id, $current_id)) {
					return false;
				}
			}
		}
		return true;
	}

	function copy($id, $copyName, $created_by) {
		$ds = $this->getDataSource();
		$ds->begin();
		
		$this->contain(array('FriendlyPermissionsItem'=>array('FriendlyPermissionsItemsAco')));
		
		$new = array();
		$new[$this->alias]['name'] = $copyName;
		$new[$this->alias]['active'] = 0;
		$new[$this->alias]['created_by'] = $created_by;
		$this->create();
		if (!$this->save($new)) {
			return false;
		}
		
		$conditions = array();
		$conditions['FriendlyPermissionsItem.friendly_permissions_table_id'] = $id;
		$conditions['FriendlyPermissionsItem.parent_id'] = null;
		$fields = array();
		$fields[] = 'FriendlyPermissionsItem.friendly_permissions_table_id';
		$fields[] = 'FriendlyPermissionsItem.name';
		$fields[] = 'FriendlyPermissionsItem.id';
		$this->FriendlyPermissionsItem->contain();
		$items = $this->FriendlyPermissionsItem->find('all', array('conditions'=>$conditions, 'fields'=>$fields));
		if ($items) {
			foreach ($items as $item) {
				if (!$this->copyItem($item, $this->id)) {
					$ds->rollback();
					return false;
				}
			}
		}
		$ds->commit();
		return true;
	}
}
