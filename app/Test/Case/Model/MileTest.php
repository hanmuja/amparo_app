<?php
/* Mile Test cases generated on: 2012-02-03 02:56:22 : 1328255782*/
App::uses('Mile', 'Model');

/**
 * Mile Test Case
 *
 */
class MileTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.mile', 'app.location', 'app.route', 'app.equipment', 'app.game', 'app.equipment_type', 'app.part', 'app.equipment_types_part', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Mile = ClassRegistry::init('Mile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mile);

		parent::tearDown();
	}

}
