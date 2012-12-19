<?php
/* EquipmentType Test cases generated on: 2012-02-01 23:28:16 : 1328156896*/
App::uses('EquipmentType', 'Model');

/**
 * EquipmentType Test Case
 *
 */
class EquipmentTypeTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.equipment_type', 'app.equipment', 'app.part', 'app.equipment_types_part');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->EquipmentType = ClassRegistry::init('EquipmentType');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EquipmentType);

		parent::tearDown();
	}

}
