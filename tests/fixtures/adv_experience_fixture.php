<?php 
/* SVN FILE: $Id$ */
/* AdvExperience Fixture generated on: 2013-01-09 16:49:20 : 1357742960*/

class AdvExperienceFixture extends CakeTestFixture {
	var $name = 'AdvExperience';
	var $table = 'adv_experiences';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'company_name' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'job' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'start_date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'end_date' => array('type'=>'date', 'null' => false, 'default' => NULL),
		'till_now' => array('type'=>'boolean', 'null' => true, 'default' => NULL),
		'company_country' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'adv_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'job_description' => array('type'=>'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
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
}
?>