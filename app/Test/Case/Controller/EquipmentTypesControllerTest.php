<?php
/* EquipmentTypes Test cases generated on: 2012-02-01 23:39:37 : 1328157577*/
App::uses('EquipmentTypesController', 'Controller');

/**
 * TestEquipmentTypesController *
 */
class TestEquipmentTypesController extends EquipmentTypesController {
/**
 * Auto render
 *
 * @var boolean
 */
	public $autoRender = false;

/**
 * Redirect action
 *
 * @param mixed $url
 * @param mixed $status
 * @param boolean $exit
 * @return void
 */
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

/**
 * EquipmentTypesController Test Case
 *
 */
class EquipmentTypesControllerTestCase extends CakeTestCase {
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

		$this->EquipmentTypes = new TestEquipmentTypesController();
		$this->EquipmentTypes->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EquipmentTypes);

		parent::tearDown();
	}

}
