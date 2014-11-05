<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of uploads
 *
 * @author omar
 */

class uploads extends AppModel{
    var $name='Upload';
    var $displayField = 'name';
    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
          'name' => array('rule' => 'notEmpty', 'message' => __('Required', true))
          
            
        );
    }
    var $belongsTo = array(
      
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => 'Group.name'
        )
     
    );
}
