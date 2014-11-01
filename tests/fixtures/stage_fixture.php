<?php
/* Stage Fixture generated on: 2013-05-19 20:47:33 : 1368985653 */
class StageFixture extends CakeTestFixture {
var $name = 'Stage';

    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'ar_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'en_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'active' => 1,
			'created' => '2013-05-19 20:47:33',
			'updated' => '2013-05-19 20:47:33'
		),
	);
}
