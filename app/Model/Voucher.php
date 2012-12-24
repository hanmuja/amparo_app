<?php
App::uses('AppModel', 'Model');
/**
 * Voucher Model
 *
 * @property Voucher $Voucher
 * @property Voucher $Creator
 */
class Voucher extends AppModel 
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
			'fecha' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese la Fecha.'),
				)
			),
			'clave' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese la Clave.'),
				)
			),
			'pasajero' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese Pasajero.'),
				)
			),
			'servicios' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese los Servicios.'),
				)
			),
			'ruta_llegada' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese la Ruta.'),
				)
			),
			'ruta_salida' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese la Ruta.'),
				)
			),
			'vuelo_llegada' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese el Vuelo.'),
				)
			),
			'vuelo_salida' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => __('Ingrese el Vuelo.'),
				)
			),
		);
	}

	public $belongsTo = array(
		'Seller' => array(
			'className' => 'Seller',
			'foreignKey' => 'seller_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Provider' => array(
			'className' => 'Provider',
			'foreignKey' => 'provider_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
	
	public function getLastId()
	{
		$db = $this->getDataSource();
		$result = $db->fetchAll(
		    "SELECT Auto_increment FROM information_schema.tables WHERE table_name='vouchers'"
		);
		
		$return = $result['0']['tables']['Auto_increment'];
		
		return $return;
	}

}
