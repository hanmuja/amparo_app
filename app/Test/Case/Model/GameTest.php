<?php
/* Game Test cases generated on: 2012-02-02 00:44:10 : 1328161450*/
App::uses('Game', 'Model');

/**
 * Game Test Case
 *
 */
class GameTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.game', 'app.equipment', 'app.equipment_type', 'app.part', 'app.equipment_types_part', 'app.location', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Game = ClassRegistry::init('Game');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Game);

		parent::tearDown();
	}

}
