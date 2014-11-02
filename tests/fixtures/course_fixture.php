<?php
/* Course Fixture generated on: 2013-05-23 18:45:00 : 1369323900 */
class CourseFixture extends CakeTestFixture {
var $name = 'Course';

    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ar_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'en_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'stage_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'level_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

    var $records = array(
		array(
			'id' => 1,
			'ar_name' => 'Lorem ipsum dolor sit amet',
			'en_name' => 'Lorem ipsum dolor sit amet',
			'stage_id' => 1,
			'level_id' => 1,
			'active' => 1,
			'created' => '2013-05-23 18:45:00',
			'updated' => '2013-05-23 18:45:00'
		),
	);
}
