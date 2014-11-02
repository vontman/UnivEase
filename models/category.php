<?php

class Category extends AppModel {

    var $name = 'Category';
    var $displayField = 'name';
    var $parents = array();
//    var $actsAs = array('Tree');

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array();
    }
        
var $belongsTo = array(
         'Faculty' => array(
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
 function beforeSave($options = array()) {
        parent::beforeSave($options);

        return true;
    }


  

  

 
}

