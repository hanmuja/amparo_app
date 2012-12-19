<?php
App::uses('AppModel', 'Model');
/**
 * FriendlyPermissionsItemsAco Model
 *
 * @property FriendlyPermissionsItem $FriendlyPermissionsItem
 * @property Aco $Aco
 */
class FriendlyPermissionsItemsAco extends AppModel {
	public $order = 'aco_path ASC';
	public $actsAs = array('Containable');
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'friendly_permissions_item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'aco_id' => array(
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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'FriendlyPermissionsItem' => array(
			'className' => 'FriendlyPermissionsItem',
			'foreignKey' => 'friendly_permissions_item_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);	
}
