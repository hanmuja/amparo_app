<?php
App::uses('AppModel', 'Model');
/**
 * Seller Model
 *
 * @property Seller $Seller
 * @property Seller $Creator
 */
class Seller extends AppModel 
{
	public $displayField= "nombre";
	
	//public $actsAs = array('Acl' => array('type' => 'requester'), "Containable");
/**
 * Validation rules
 *
 * @var array
 */
	public $validate= array();
 
	function __construct($id = false, $table = null, $ds = null) 
	{
		parent::__construct($id, $table, $ds);

		$this->validate = array
		(
			'nombre' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese el Nombre.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
			'primer_apellido' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese el Primer Apellido.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
		);
	}

}
