<?php
/* Equipment Test cases generated on: 2012-02-02 00:43:52 : 1328161432*/
App::uses('Equipment', 'Model');

/**
 * Equipment Test Case
 *
 */
class EquipmentTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.equipment', 'app.game', 'app.equipment_type', 'app.part', 'app.equipment_types_part', 'app.location', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Equipment = ClassRegistry::init('Equipment');
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
