<?php
/* Assignment Fixture generated on: 2013-05-31 10:30:21 : 1369985421 */
class AssignmentFixture extends CakeTestFixture {
var $name = 'Assignment';

    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'question' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'answer' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'course_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'teacher_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'student_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'assignment_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'allow_attachment' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
		'publish_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'delivery_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'lat_delivery_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

    var $records = array(
		array(
			'id' => 1,
			'question' => 'Lorem ipsum dolor sit amet',
			'answer' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'course_id' => 1,
			'teacher_id' => 1,
			'student_id' => 1,
			'assignment_id' => 1,
			'allow_attachment' => 1,
			'publish_date' => '2013-05-31 10:30:21',
			'delivery_date' => '2013-05-31 10:30:21',
			'lat_delivery_date' => '2013-05-31 10:30:21'
		),
	);
}
