<?php
/* StudentSection Test cases generated on: 2013-05-23 12:15:37 : 1369300537*/
App::import('Model', 'StudentSection');

class StudentSectionTestCase extends CakeTestCase {
	var $fixtures = array('app.student_section', 'app.user', 'app.group', 'app.stage', 'app.section', 'app.level');

	function startTest() {
		$this->StudentSection =& ClassRegistry::init('StudentSection');
	}

	function endTest() {
		unset($this->StudentSection);
		ClassRegistry::flush();
	}

}
