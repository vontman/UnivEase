<?php

class Chat extends AppModel {

    var $name = 'Chat';
    var $displayField = 'name';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'content' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'publish_date' => array(
                array('rule' => 'notEmpty', 'message' => __('Required', true)),
            ),
            'cut_off' => array(
                array('rule' => 'notEmpty', 'message' => __('Required', true)),
                array('rule' => 'checkTwoDates', 'message' => __('Please choose date after the publish date', true))
            ),
        );
    }
    
    function checkTwoDates() {
        if (!empty($this->data[$this->name]['cut_off']) && !empty($this->data[$this->name]['publish_date'])) {
            return strtotime($this->data[$this->name]['publish_date']) < strtotime($this->data[$this->name]['cut_off']);
        }
    }

//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'course_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

}
