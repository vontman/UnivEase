<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Corsat
 *
 * @author omar
 */
class Corsat extends AppModel{
    var $name = 'Corsat';
    var $displayField = 'name';
    var $belongsTo = array(
      
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
     
    );
}
