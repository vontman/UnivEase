<?php
/* Assignments Test cases generated on: 2013-05-31 10:31:29 : 1369985489*/
App::import('Controller', 'Assignments');

class TestAssignmentsController extends AssignmentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AssignmentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.assignment', 'app.course', 'app.stage', 'app.level', 'app.section', 'app.student_section', 'app.user', 'app.group', 'app.assignment_file');

	function startTest() {
		$this->Assignments =& new TestAssignmentsController();
		$this->Assignments->constructClasses();
	}

	function endTest() {
		unset($this->Assignments);
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
