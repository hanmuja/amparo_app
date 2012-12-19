<?php
/* ArosAcos Test cases generated on: 2012-02-09 23:14:18 : 1328847258*/
App::uses('ArosAcosController', 'Controller');

/**
 * TestArosAcosController *
 */
class TestArosAcosController extends ArosAcosController {
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
 * ArosAcosController Test Case
 *
 */
class ArosAcosControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.aros_aco');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->ArosAcos = new TestArosAcosController();
		$this->ArosAcos->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->ArosAcos);

		parent::tearDown();
	}

}
