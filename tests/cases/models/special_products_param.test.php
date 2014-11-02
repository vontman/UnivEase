<?php 
/* SVN FILE: $Id$ */
/* SpecialProductsParam Test cases generated on: 2013-03-16 12:00:18 : 1363428018*/
App::import('Model', 'SpecialProductsParam');

class SpecialProductsParamTestCase extends CakeTestCase {
	var $SpecialProductsParam = null;
	var $fixtures = array('app.special_products_param', 'app.special_product');

	function startTest() {
		$this->SpecialProductsParam =& ClassRegistry::init('SpecialProductsParam');
	}

	function testSpecialProductsParamInstance() {
		$this->assertTrue(is_a($this->SpecialProductsParam, 'SpecialProductsParam'));
	}

	function testSpecialProductsParamFind() {
		$this->SpecialProductsParam->recursive = -1;
		$results = $this->SpecialProductsParam->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('SpecialProductsParam' => array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'value' => 'Lorem ipsum dolor sit amet',
			'special_product_id' => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>