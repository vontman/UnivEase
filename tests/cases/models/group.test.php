<?php
/* Group Test cases generated on: 2013-05-08 19:42:31 : 1368031351*/
App::import('Model', 'Group');

class GroupTestCase extends CakeTestCase {
	var $fixtures = array('app.group', 'app.teacher', 'app.exam', 'app.student', 'app.student_exam');

	function startTest() {
		$this->Group =& ClassRegistry::init('Group');
	}

	function endTest() {
		unset($this->Group);
		ClassRegistry::flush();
	}

}
