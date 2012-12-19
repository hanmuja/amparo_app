<?php
/* EmailTemplate Test cases generated on: 2012-02-10 05:19:01 : 1328869141*/
App::uses('EmailTemplate', 'Model');

/**
 * EmailTemplate Test Case
 *
 */
class EmailTemplateTestCase extends CakeTestCase {
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

		$this->EmailTemplate = ClassRegistry::init('EmailTemplate');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->EmailTemplate);

		parent::tearDown();
	}

}
