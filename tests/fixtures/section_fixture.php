<?php
/* Section Fixture generated on: 2013-05-19 01:10:29 : 1368915029 */
class SectionFixture extends CakeTestFixture {
var $name = 'Section';

    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ar_name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'en_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'grade_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
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
			'grade_id' => 1,
			'active' => 1,
			'created' => '2013-05-19 01:10:29',
			'updated' => '2013-05-19 01:10:29'
		),
	);
}
