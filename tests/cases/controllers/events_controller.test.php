<?php
/* Events Test cases generated on: 2013-06-06 13:46:40 : 1370515600*/
App::import('Controller', 'Events');

class TestEventsController extends EventsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class EventsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.event', 'app.user', 'app.group', 'app.stage', 'app.level', 'app.section', 'app.student_section');

	function startTest() {
		$this->Events =& new TestEventsController();
		$this->Events->constructClasses();
	}

	function endTest() {
		unset($this->Events);
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
