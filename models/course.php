<?php

class Course extends AppModel {

    var $name = 'Course';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array();
    }

    var $actsAs = array(
        'Image' => array(
            'fields' => array(
                'image' => array(
                    'resize' => array('width' => 150, 'height' => 210, 'allow_enlarge' => true),
                    'thumbnail' => array('create' => false),
                )
            )
        )
    );
//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Category' => array(
            'className' => 'Category',
            'foreignKey' => 'category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
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
