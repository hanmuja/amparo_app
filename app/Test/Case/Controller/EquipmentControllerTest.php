<?php
/* Equipment Test cases generated on: 2012-02-04 17:37:51 : 1328395071*/
App::uses('EquipmentController', 'Controller');

/**
 * TestEquipmentController *
 */
class TestEquipmentController extends EquipmentController {
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
 * EquipmentController Test Case
 *
 */
class EquipmentControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.equipment', 'app.game', 'app.equipment_type', 'app.equipment_types_part', 'app.part', 'app.user', 'app.location', 'app.route', 'app.mile');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Equipment = new TestEquipmentController();
		$this->Equipment->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Equipment);

		parent::tearDown();
	}

}
