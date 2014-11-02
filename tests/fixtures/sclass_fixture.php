<?php
/* Sclass Fixture generated on: 2013-05-18 04:18:55 : 1368839935 */
class SclassFixture extends CakeTestFixture {
var $name = 'Sclass';

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
			'created' => '2013-05-18 04:18:55',
			'updated' => '2013-05-18 04:18:55'
		),
	);
}
