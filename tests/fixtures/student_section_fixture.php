<?php
/* StudentSection Fixture generated on: 2013-05-23 12:15:37 : 1369300537 */
class StudentSectionFixture extends CakeTestFixture {
var $name = 'StudentSection';

    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'section_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

    var $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'section_id' => 1
		),
	);
}
