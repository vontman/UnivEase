<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


class Schedule extends AppModel
{
     var $name  = 'Schedule';
    
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
                        'name' => array('rule' => 'notempty', 'message' => __('Required', true)),
                        'schedule_category_id' => array('rule' => 'notEmpty'),);
   }
   
   public $hasMany = array(
        'ScheduleDetail' => array(
            'className' => 'ScheduleDetail',
            'foreignKey' => 'schedule_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true
        )
    );
}

?>