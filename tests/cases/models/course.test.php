<?php
/* Course Test cases generated on: 2013-05-23 18:45:00 : 1369323900*/
App::import('Model', 'Course');

class CourseTestCase extends CakeTestCase {
	var $fixtures = array('app.course', 'app.stage', 'app.level', 'app.section', 'app.student_section', 'app.user', 'app.group');

	function startTest() {
		$this->Course =& ClassRegistry::init('Course');
	}

	function endTest() {
		unset($this->Course);
		ClassRegistry::flush();
	}

}
