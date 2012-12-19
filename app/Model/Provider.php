<?php
App::uses('AppModel', 'Model');
/**
 * Provider Model
 *
 * @property Provider $Provider
 * @property Provider $Creator
 */
class Provider extends AppModel 
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
			'clave' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese la Clave.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
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
			'telefono_principal' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese el Telefono Principal.'),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				)
			),
		);
	}

}
