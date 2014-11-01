<?php
/* Exams Test cases generated on: 2013-06-28 23:24:12 : 1372451052*/
App::import('Controller', 'Exams');

class TestExamsController extends ExamsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExamsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.exam', 'app.course', 'app.stage', 'app.level', 'app.section', 'app.student_section', 'app.user', 'app.group', 'app.exam_question');

	function startTest() {
		$this->Exams =& new TestExamsController();
		$this->Exams->constructClasses();
	}

	function endTest() {
		unset($this->Exams);
		ClassRegistry::flush();
	}

	function testTeacherIndex() {

	}

	function testTeacherView() {

	}

	function testTeacherAdd() {

	}

	function testTeacherEdit() {

	}

	function testTeacherDelete() {

	}

	function testTeacherDoOperation() {

	}

}
