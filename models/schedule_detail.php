<?php

class ScheduleDetail extends AppModel
{
     var $name  = 'ScheduleDetail';
    
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'course_id' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'Teacher' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'day' => array(
                array('rule' => 'notempty', 'message' => __('Required', true)),
                array('rule' => array('inList', array('Sat','Sun','Mon','Tues','Wed','Thu')), 'message' => __('Not in range.',true),)
            ),
            'user_id' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'start_time' => array('rule' => 'notEmpty', 'message' => __('Required', true)),
            'end_time' => array(
                array('rule' => 'notEmpty', 'message' => __('Required', true)),
                array('rule' => 'checkTwoTimes', 'message' => __('Please choose date after start time', true))
            ),  
            'schedule_id' => array('rule' => 'notEmpty'),
            'class' =>array(
                array('rule' => 'notempty' , 'message' => __('Required', true)),
                array('rule' => array('inList', array(1,2,3,4,5,6,7)), 'message' => __('Not in range.',true),)
            ),
        );
    }
        
    
    function checkTwoTimes() {
        if (!empty($this->data[$this->name]['end_time']) && !empty($this->data[$this->name]['start_time'])) {
            return strtotime($this->data[$this->name]['start_time']) < strtotime($this->data[$this->name]['end_time']);
        }
    }
    
    
//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Teacher' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'course_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );   
}
?>