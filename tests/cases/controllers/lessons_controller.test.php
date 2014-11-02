<?php
/* Lessons Test cases generated on: 2013-06-20 17:52:07 : 1371739927*/
App::import('Controller', 'Lessons');

class TestLessonsController extends LessonsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class LessonsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.lesson', 'app.user', 'app.group', 'app.stage', 'app.level', 'app.section', 'app.student_section', 'app.course');

	function startTest() {
		$this->Lessons =& new TestLessonsController();
		$this->Lessons->constructClasses();
	}

	function endTest() {
		unset($this->Lessons);
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
