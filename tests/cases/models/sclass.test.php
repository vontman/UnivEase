<?php
/* Sclass Test cases generated on: 2013-05-18 04:18:55 : 1368839935*/
App::import('Model', 'Sclass');

class SclassTestCase extends CakeTestCase {
	var $fixtures = array('app.sclass', 'app.student');

	function startTest() {
		$this->Sclass =& ClassRegistry::init('Sclass');
	}

	function endTest() {
		unset($this->Sclass);
		ClassRegistry::flush();
	}

}
