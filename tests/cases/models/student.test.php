<?php
/* Student Test cases generated on: 2013-05-06 04:56:07 : 1367805367*/
App::import('Model', 'Student');

class StudentTestCase extends CakeTestCase {
	var $fixtures = array('app.student', 'app.group', 'app.student_exam');

	function startTest() {
		$this->Student =& ClassRegistry::init('Student');
	}

	function endTest() {
		unset($this->Student);
		ClassRegistry::flush();
	}

}
