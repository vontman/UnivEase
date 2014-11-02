<?php
/* StudentExams Test cases generated on: 2013-05-14 21:28:43 : 1368556123*/
App::import('Controller', 'StudentExams');

class TestStudentExamsController extends StudentExamsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StudentExamsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.student_exam', 'app.exam', 'app.teacher', 'app.group', 'app.student');

	function startTest() {
		$this->StudentExams =& new TestStudentExamsController();
		$this->StudentExams->constructClasses();
	}

	function endTest() {
		unset($this->StudentExams);
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
