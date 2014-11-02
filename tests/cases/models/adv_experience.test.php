<?php 
/* SVN FILE: $Id$ */
/* AdvExperience Test cases generated on: 2013-01-09 16:49:20 : 1357742960*/
App::import('Model', 'AdvExperience');

class AdvExperienceTestCase extends CakeTestCase {
	var $AdvExperience = null;
	var $fixtures = array('app.adv_experience', 'app.adv');

	function startTest() {
		$this->AdvExperience =& ClassRegistry::init('AdvExperience');
	}

	function testAdvExperienceInstance() {
		$this->assertTrue(is_a($this->AdvExperience, 'AdvExperience'));
	}

	function testAdvExperienceFind() {
		$this->AdvExperience->recursive = -1;
		$results = $this->AdvExperience->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('AdvExperience' => array(
			'id' => 1,
			'company_name' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'job' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'start_date' => '2013-01-09',
			'end_date' => '2013-01-09',
			'till_now' => 1,
			'company_country' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'adv_id' => 1,
			'job_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		));
		$this->assertEqual($results, $expected);
	}
}
?>