<?php
/* ExamQuestions Test cases generated on: 2013-07-01 16:47:49 : 1372686469*/
App::import('Controller', 'ExamQuestions');

class TestExamQuestionsController extends ExamQuestionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ExamQuestionsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.exam_question', 'app.exam', 'app.course', 'app.stage', 'app.level', 'app.section', 'app.user', 'app.group');

	function startTest() {
		$this->ExamQuestions =& new TestExamQuestionsController();
		$this->ExamQuestions->constructClasses();
	}

	function endTest() {
		unset($this->ExamQuestions);
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
