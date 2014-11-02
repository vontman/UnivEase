<?php
/* Messages Test cases generated on: 2013-06-11 01:48:43 : 1370904523*/
App::import('Controller', 'Messages');

class TestMessagesController extends MessagesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MessagesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.message', 'app.user', 'app.group', 'app.stage', 'app.level', 'app.section', 'app.student_section');

	function startTest() {
		$this->Messages =& new TestMessagesController();
		$this->Messages->constructClasses();
	}

	function endTest() {
		unset($this->Messages);
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
