<?php
App::uses('AppModel', 'Model');
/**
 * Language Model
 *
 * @property User $Author
 */
class Language extends AppModel {
	
	public $actsAs= array("Containable");
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate= array();
 
	function __construct($id = false, $table = null, $ds = null) 
	{
		parent::__construct($id, $table, $ds);

		$this->validate = array(
                        'name' => array(
                          'notempty' => array(
                            'rule' => array('notempty'),
                          ),
                        ),
		);
	}
}
