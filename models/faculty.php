<?php

class Faculty extends AppModel {

    var $name = 'Faculty';

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

   

    function beforeSave($options = array()) {
        parent::beforeSave($options);

        return true;
    }



 

    

}
