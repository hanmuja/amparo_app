<?php
/* Locations Test cases generated on: 2012-02-03 01:42:19 : 1328251339*/
App::uses('LocationsController', 'Controller');

/**
 * TestLocationsController *
 */
class TestLocationsController extends LocationsController {
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
 * LocationsController Test Case
 *
 */
class LocationsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.location', 'app.route', 'app.equipment', 'app.game', 'app.equipment_type', 'app.part', 'app.equipment_types_part', 'app.user');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Locations = new TestLocationsController();
		$this->Locations->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Locations);

		parent::tearDown();
	}

}
