<?php
/* Part Test cases generated on: 2012-02-04 11:09:35 : 1328371775*/
App::uses('Part', 'Model');

/**
 * Part Test Case
 *
 */
class PartTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.part', 'app.user', 'app.equipment_types_part', 'app.equipment_type', 'app.equipment', 'app.game', 'app.location', 'app.route', 'app.mile');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Part = ClassRegistry::init('Part');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Part);

		parent::tearDown();
	}

}
