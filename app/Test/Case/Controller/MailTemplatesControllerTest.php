<?php
/* MailTemplates Test cases generated on: 2012-02-10 05:03:54 : 1328868234*/
App::uses('MailTemplatesController', 'Controller');

/**
 * TestMailTemplatesController *
 */
class TestMailTemplatesController extends MailTemplatesController {
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
 * MailTemplatesController Test Case
 *
 */
class MailTemplatesControllerTestCase extends CakeTestCase {
/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array('app.mail_template', 'app.user', 'app.group');

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->MailTemplates = new TestMailTemplatesController();
		$this->MailTemplates->constructClasses();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MailTemplates);

		parent::tearDown();
	}

}
