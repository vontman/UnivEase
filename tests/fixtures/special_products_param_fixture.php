<?php 
/* SVN FILE: $Id$ */
/* SpecialProductsParam Fixture generated on: 2013-03-16 12:00:18 : 1363428018*/

class SpecialProductsParamFixture extends CakeTestFixture {
	var $name = 'SpecialProductsParam';
	var $table = 'special_products_params';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'value' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'special_product_id' => array('type'=>'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id' => 1,
		'name' => 'Lorem ipsum dolor sit amet',
		'value' => 'Lorem ipsum dolor sit amet',
		'special_product_id' => 1
	));
}
?>