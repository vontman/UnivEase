<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

class ScheduleCategory extends AppModel
{
     var $name  = 'ScheduleCategory';
    
    function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
                        'name' => array('rule' => 'notempty', 'message' => __('Required', true)),);
   }
   
   public $hasMany = array(
        'Schedule' => array(
            'className' => 'Schedule',
            'foreignKey' => 'schedule_category_id',
            'conditions' => '',
            'order' => '',
            'limit' => '',
            'dependent' => true
        )
    );
}
?>
