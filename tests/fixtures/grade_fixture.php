<?php
/* Grade Fixture generated on: 2013-06-03 12:16:07 : 1370250967 */
class GradeFixture extends CakeTestFixture {
var $name = 'Grade';

    var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'student_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'teacher_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'grade' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'updated' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'assignment_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'exam_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'question_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);

    var $records = array(
		array(
			'id' => 1,
			'type' => 'Lorem ipsum dolor sit amet',
			'student_id' => 1,
			'teacher_id' => 1,
			'grade' => 1,
			'created' => '2013-06-03 12:16:07',
			'updated' => '2013-06-03 12:16:07',
			'assignment_id' => 1,
			'exam_id' => 1,
			'question_id' => 1
		),
	);
}
