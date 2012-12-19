<?php
/* Location Test cases generated on: 2012-02-03 03:32:16 : 1328257936*/
App::uses('Location', 'Model');

/**
 * Location Test Case
 *
 */
class LocationTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.location', 'app.route', 'app.equipment', 'app.game', 'app.equipment_type', 'app.part', 'app.equipment_types_part', 'app.user', 'app.mile');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Location = ClassRegistry::init('Location');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Location);

		parent::tearDown();
	}

}
