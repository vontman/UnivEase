<?php
/* Stage Test cases generated on: 2013-05-19 20:47:33 : 1368985653*/
App::import('Model', 'Stage');

class StageTestCase extends CakeTestCase {
	var $fixtures = array('app.stage', 'app.level');

	function startTest() {
		$this->Stage =& ClassRegistry::init('Stage');
	}

	function endTest() {
		unset($this->Stage);
		ClassRegistry::flush();
	}

}
