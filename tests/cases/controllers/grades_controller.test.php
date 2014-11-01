<?php
/* Grades Test cases generated on: 2013-05-18 03:50:56 : 1368838256*/
App::import('Controller', 'Grades');

class TestGradesController extends GradesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class GradesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.grade');

	function startTest() {
		$this->Grades =& new TestGradesController();
		$this->Grades->constructClasses();
	}

	function endTest() {
		unset($this->Grades);
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
