<?php
/* Routes Test cases generated on: 2012-02-03 00:45:10 : 1328247910*/
App::uses('RoutesController', 'Controller');

/**
 * TestRoutesController *
 */
class TestRoutesController extends RoutesController {
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
 * RoutesController Test Case
 *
 */
class RoutesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.route');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Routes = new TestRoutesController();
		$this->Routes->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Routes);

		parent::tearDown();
	}

}
