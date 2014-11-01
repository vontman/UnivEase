<?php
/* Grade Test cases generated on: 2013-05-18 03:48:39 : 1368838119*/
App::import('Model', 'Grade');

class GradeTestCase extends CakeTestCase {
	var $fixtures = array('app.grade');

	function startTest() {
		$this->Grade =& ClassRegistry::init('Grade');
	}

	function endTest() {
		unset($this->Grade);
		ClassRegistry::flush();
	}

}
