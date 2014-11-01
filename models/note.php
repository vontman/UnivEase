<?php

class Note extends AppModel {

    var $name = 'Note';
    var $assignTo;

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'subject' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'body' => array('rule' => 'notempty', 'message' => __('Required', true))
        );
    }

//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
       
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    

}

