<?php

class Friend extends AppModel {

    var $name = 'Friend';
    var $assignTo;

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
       
    }

//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'u1_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
       
        
    );

  

}

