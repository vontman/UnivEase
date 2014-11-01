<?php

class Message extends AppModel {

    var $name = 'Message';
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
        'Receiver' => array(
            'className' => 'User',
            'foreignKey' => 'receiver_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Sender' => array(
            'className' => 'User',
            'foreignKey' => 'sender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    function afterFind($results, $primary = false) {
        parent::afterFind($results, $primary);
        foreach ($results as $key => $result) {
//            debug($result['Message']);
            if (!empty($result['Message']['sender_type']) && $result['Message']['sender_type'] == 'admin') {
                $Admin = ClassRegistry::init('Admin');
                $admin = $Admin->read(null, $result['Message']['sender_id']);
                $results[$key]['Sender'] = $admin['Admin'];
            }
            if (!empty($result['Message']['receiver_type']) && $result['Message']['receiver_type'] == 'admin') {
                $Admin = ClassRegistry::init('Admin');
                $admin = $Admin->read(null, $result['Message']['receiver_id']);
                $results[$key]['Receiver'] = $admin['Admin'];
            }
        }
        
        return $results;
    }

}

