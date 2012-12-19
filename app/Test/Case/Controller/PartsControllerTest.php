<?php
/* Parts Test cases generated on: 2012-02-04 10:55:09 : 1328370909*/
App::uses('PartsController', 'Controller');

/**
 * TestPartsController *
 */
class TestPartsController extends PartsController {
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
 * PartsController Test Case
 *
 */
class PartsControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.part');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->Parts = new TestPartsController();
		$this->Parts->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Parts);

		parent::tearDown();
	}

}
