<?php
/* Levels Test cases generated on: 2013-05-19 20:44:15 : 1368985455*/
App::import('Controller', 'Levels');

class TestLevelsController extends LevelsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class LevelsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.level', 'app.stage');

	function startTest() {
		$this->Levels =& new TestLevelsController();
		$this->Levels->constructClasses();
	}

	function endTest() {
		unset($this->Levels);
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
