<?php
/* AssignmentFiles Test cases generated on: 2013-06-03 17:49:25 : 1370270965*/
App::import('Controller', 'AssignmentFiles');

class TestAssignmentFilesController extends AssignmentFilesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AssignmentFilesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.assignment_file', 'app.assignment', 'app.course', 'app.stage', 'app.level', 'app.section', 'app.student_section', 'app.user', 'app.group');

	function startTest() {
		$this->AssignmentFiles =& new TestAssignmentFilesController();
		$this->AssignmentFiles->constructClasses();
	}

	function endTest() {
		unset($this->AssignmentFiles);
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
