<?php
/* StudentExam Test cases generated on: 2013-05-14 21:08:49 : 1368554929*/
App::import('Model', 'StudentExam');

class StudentExamTestCase extends CakeTestCase {
	var $fixtures = array('app.student_exam', 'app.exam', 'app.teacher', 'app.group', 'app.student');

	function startTest() {
		$this->StudentExam =& ClassRegistry::init('StudentExam');
	}

	function endTest() {
		unset($this->StudentExam);
		ClassRegistry::flush();
	}

}
