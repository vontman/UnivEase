<?php

class Post extends AppModel {

    var $name = 'Post';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'title' => array('rule' => 'notempty', 'message' => __('Required', true)),
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

//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'course_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
   
    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (empty($this->data[$this->name]['permalink'])) {
            $this->data[$this->name]['permalink'] = Inflector::slug($this->data[$this->name]['title'], '-');
        }
        return true;
    }
    function checkTwoDates() {
        if (!empty($this->data[$this->name]['cut_off']) && !empty($this->data[$this->name]['publish_date'])) {
            return strtotime($this->data[$this->name]['publish_date']) < strtotime($this->data[$this->name]['cut_off']);
        }
    }

}
