<?php
/* Paragraphs Test cases generated on: 2013-05-06 01:58:00 : 1367794680*/
App::import('Controller', 'Paragraphs');

class TestParagraphsController extends ParagraphsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ParagraphsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.paragraph');

	function startTest() {
		$this->Paragraphs =& new TestParagraphsController();
		$this->Paragraphs->constructClasses();
	}

	function endTest() {
		unset($this->Paragraphs);
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
