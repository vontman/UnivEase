<?php
/* Sclasses Test cases generated on: 2013-05-18 04:19:41 : 1368839981*/
App::import('Controller', 'Sclasses');

class TestSclassesController extends SclassesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class SclassesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.sclass', 'app.student');

	function startTest() {
		$this->Sclasses =& new TestSclassesController();
		$this->Sclasses->constructClasses();
	}

	function endTest() {
		unset($this->Sclasses);
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
