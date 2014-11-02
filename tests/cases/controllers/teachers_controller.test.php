<?php
/* Teachers Test cases generated on: 2013-05-06 04:14:50 : 1367802890*/
App::import('Controller', 'Teachers');

class TestTeachersController extends TeachersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TeachersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.teacher');

	function startTest() {
		$this->Teachers =& new TestTeachersController();
		$this->Teachers->constructClasses();
	}

	function endTest() {
		unset($this->Teachers);
		ClassRegistry::flush();
	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

	function testAdminDoOperation() {

	}

}
