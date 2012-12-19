<?php
App::uses('AppModel', 'Model');
/**
 * FriendlyPermissionsItem Model
 *
 * @property FriendlyPermissionsTable $FriendlyPermissionsTable
 * @property FriendlyPermissionsItem $ParentFriendlyPermissionsItem
 * @property FriendlyPermissionsItem $ChildFriendlyPermissionsItem
 * @property Aco $Aco
 */
class FriendlyPermissionsItem extends AppModel {
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
	public $actsAs = array('Tree', 'Containable');
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
		'friendly_permissions_table_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'parent_id' => array(
			/*'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),*/
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FriendlyPermissionsTable' => array(
			'className' => 'FriendlyPermissionsTable',
			'foreignKey' => 'friendly_permissions_table_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentFriendlyPermissionsItem' => array(
			'className' => 'FriendlyPermissionsItem',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildFriendlyPermissionsItem' => array(
			'className' => 'FriendlyPermissionsItem',
			'foreignKey' => 'parent_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'FriendlyPermissionsItemsAco' => array(
			'className' => 'FriendlyPermissionsItemsAco',
			'foreignKey' => 'friendly_permissions_item_id',
			'dependent' => true,
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
	
	public function getActiveTablePaths() {
		$paths = array();
		
		$conditions = array();
		$conditions['FriendlyPermissionsTable.active'] = 1;
		$conditions[$this->alias.'.parent_id'] = null;
		$this->contain(array('FriendlyPermissionsTable.active'));
		$items = $this->find('all', array('conditions'=>$conditions));
		
		if ($items) {
			foreach ($items as $item) {
				$paths = array_merge($paths, $this->getItemPaths($item[$this->alias]['id']));
			}
		}

		return $paths;
	}
	
	public function getItemPaths($id) {
		$paths = array();
		
		//Get the item's paths
		$conditions = array();
		$conditions['FriendlyPermissionsItemsAco.friendly_permissions_item_id'] = $id;
		$fields = array('FriendlyPermissionsItemsAco.aco_path', 'FriendlyPermissionsItemsAco.friendly_permissions_item_id');
		$this->FriendlyPermissionsItemsAco->contain();
		$acoPaths = $this->FriendlyPermissionsItemsAco->find('all', array('conditions'=>$conditions, 'fields'=>$fields));
		if ($acoPaths) {
			foreach ($acoPaths as $acoPath) {
				$paths[] = $acoPath['FriendlyPermissionsItemsAco']['aco_path'];
			}
		}
		
		//Get the item's children
		$subitems = $this->children($id);
		
		if ($subitems) {
			foreach ($subitems as $subitem) {
				//Get the item's paths
				$conditions = array();
				$conditions['FriendlyPermissionsItemsAco.friendly_permissions_item_id'] = $subitem[$this->alias]['id'];
				$fields = array('FriendlyPermissionsItemsAco.aco_path', 'FriendlyPermissionsItemsAco.friendly_permissions_item_id');
				$this->FriendlyPermissionsItemsAco->contain();
				$acoPaths = $this->FriendlyPermissionsItemsAco->find('all', array('conditions'=>$conditions, 'fields'=>$fields));
				if ($acoPaths) {
					foreach ($acoPaths as $acoPath) {
						$paths[] = $acoPath['FriendlyPermissionsItemsAco']['aco_path'];
					}
				}
			}	
		}
		
		return $paths;
	}

	public function getItemPermission2($item, $grantedPermissions) {
		$someDenied = false;
		$someGranted = false;
		if ($item['FriendlyPermissionsItemsAco']) {
			foreach ($item['FriendlyPermissionsItemsAco'] as $aco) {
				if (in_array($aco['aco_path'], $grantedPermissions)) {
					$someGranted = true;
					if ($someDenied) {
						return 'mixed';
					}
				} else {
					$someDenied = true;
					if ($someGranted) {
						return 'mixed';
					}
				}
			}
		}
		
		if ($item['children']) {
			foreach ($item['children'] as $child) {
				$childPermission = $this->getItemPermission2($child, $grantedPermissions); 
				if ($childPermission == 'mixed') {
					return 'mixed';
				} else {
					if ($childPermission == 'granted') {
						$someGranted = true;
						if ($someDenied) {
							return 'mixed';
						}
					} else {
						$someDenied = true;
						if ($someGranted) {
							return 'mixed';
						}
					}
				}
			}
		}

		if ($someGranted) {
			return 'granted';
		} else {
			return 'denied';
		}
	}
	
	public function getItemPermission($item, $grantedPermissions) {
		if ($item['FriendlyPermissionsItemsAco']) {
			foreach ($item['FriendlyPermissionsItemsAco'] as $aco) {
				if (!in_array($aco['aco_path'], $grantedPermissions)) {
					return false;
				}
			}
		}
		
		if ($item['children']) {
			foreach ($item['children'] as $child) {
				if (!$this->getItemPermission($child, $grantedPermissions)) {
					return false;
				}
			}
		}
		return true;
	}
	
	private function __getPermissionSection($item, $grantedPermissions) {
		$section = array();
		$section['id'] = $item[$this->alias]['id'];
		$section['label'] = $item[$this->alias]['name'];
		$section['permission'] = $this->getItemPermission2($item, $grantedPermissions);
		$section['children'] = array();
		$section['paths'] = array();
		
		if ($item['children']) {
			foreach ($item['children'] as $child) {
				$section['children'][] = $this->__getPermissionSection($child, $grantedPermissions);
			}
		}
		if ($item['FriendlyPermissionsItemsAco']) {
			foreach ($item['FriendlyPermissionsItemsAco'] as $path) {
				$aPath = array();
				$aPath['id'] = $path['id'];
				$aPath['permission'] = in_array($path['aco_path'], $grantedPermissions);
				$aPath['path'] = $path['aco_path'];
				$section['paths'][] = $aPath;
			}
		}
		
		return $section;
	}
	
	public function getPermissionsMenu($grantedPermissions) {
		$conditions = array();
		$conditions['FriendlyPermissionsTable.active'] = 1;
		$this->contain(array('FriendlyPermissionsTable.active', 'FriendlyPermissionsItemsAco.aco_path', 'FriendlyPermissionsItemsAco.id'));
		$items = $this->find('threaded', array('conditions'=>$conditions, 'order'=>$this->alias.'.name ASC'));
		
		$menu = array();
		if ($items) {
			foreach ($items as $item) {
				$menu[] = $this->__getPermissionSection($item, $grantedPermissions);
			}	
		}
		return $menu;
	}
}
