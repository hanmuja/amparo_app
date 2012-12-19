<?php
/* MailTemplate Test cases generated on: 2012-02-10 05:03:43 : 1328868223*/
App::uses('MailTemplate', 'Model');

/**
 * MailTemplate Test Case
 *
 */
class MailTemplateTestCase extends CakeTestCase {
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

		$this->MailTemplate = ClassRegistry::init('MailTemplate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->MailTemplate);

		parent::tearDown();
	}

}
