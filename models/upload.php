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

class Upload extends AppModel{
    var $name='Upload';
    var $displayField = 'name';

    var $belongsTo = array(
      
        'Group' => array(
            'className' => 'Group',
            'foreignKey' => 'group_id',
            'conditions' => '',
            'fields' => '',
            'order' => 'Group.name'
        ),
        'UploadFolder' => array(
            'className' => 'UploadFolder',
            'foreignKey' => 'folder_id',
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
}
