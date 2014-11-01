<?php

class Group extends AppModel {

    var $name = 'Group';
    var $displayField = 'name';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
          'name' => array('rule' => 'notEmpty', 'message' => __('Required', true))
          
            
        );
    }
    var $belongsTo = array(
      
        'Course' => array(
            'className' => 'Course',
            'foreignKey' => 'course_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
     
    );
    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (!empty($this->data[$this->name]['permissions'])) {
            $this->data[$this->name]['permissions'] = implode(',', $this->data[$this->name]['permissions']);
        }
        return true;
    }

    function afterFind($results, $primary = false) {
        parent::afterFind($results, $primary);
        $Permission = ClassRegistry::init('Permission');
        foreach ($results as &$result) {
            if (!empty($result[$this->name]['permissions'])) {
                $result[$this->name]['permissions'] = explode(',', $result[$this->name]['permissions']);
                $text_permissions = array();
                foreach ($result[$this->name]['permissions'] as $permission) {
                    $Permission->id = $permission;
                    $text_permissions[$permission] = $Permission->field('name');
                }
                $result[$this->name]['allowed_permissions'] = $text_permissions;
            }
        }
        return $results;
    }

}
