<?php
class Permission extends AppModel {
var $name = 'Permission';
    var $displayField = 'name';
    	function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);		$this->validate = array(
	);
	}}
