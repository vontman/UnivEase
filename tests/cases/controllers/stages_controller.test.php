<?php
/* Stages Test cases generated on: 2013-05-19 21:19:49 : 1368987589*/
App::import('Controller', 'Stages');

class TestStagesController extends StagesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StagesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.stage');

	function startTest() {
		$this->Stages =& new TestStagesController();
		$this->Stages->constructClasses();
	}

	function endTest() {
		unset($this->Stages);
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
