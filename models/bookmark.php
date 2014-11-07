<?php

class Bookmark extends AppModel {

    var $name = 'Bookmark';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'content' => array('rule' => 'notempty', 'message' => __('Required', true))
        );
    }

//The Associations below have been created with all possible keys, those that are not needed can be removed

    var $belongsTo = array(
        'Post' => array(
            'className' => 'Post',
            'foreignKey' => 'post_id',
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

    function afterFind($results, $primary = false) {
        parent::afterFind($results, $primary);
        $User = ClassRegistry::init('User');
        foreach ($results as &$result) {
            if (!empty($result[$this->name]['user_id'])) {
                $user = $User->read(null, $result[$this->name]['user_id']);
                $result['User'] = $user['User'];
            }
        }
        return $results;
    }

}
