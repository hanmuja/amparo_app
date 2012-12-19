<?php
/* EmailTemplates Test cases generated on: 2012-02-10 05:19:11 : 1328869151*/
App::uses('EmailTemplatesController', 'Controller');

/**
 * TestEmailTemplatesController *
 */
class TestEmailTemplatesController extends EmailTemplatesController {
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
 * EmailTemplatesController Test Case
 *
 */
class EmailTemplatesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.email_template', 'app.user', 'app.group');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->EmailTemplates = new TestEmailTemplatesController();
		$this->EmailTemplates->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EmailTemplates);

		parent::tearDown();
	}

}
