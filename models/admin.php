<?php

class Admin extends AppModel {

    var $name = 'Admin';
    var $actsAs = array(
        'Image' => array(
            'fields' => array(
                'image' => array(
                    'resize' => array('width' => 40, 'height' => 40),
                    'versions' => array(
                        array('prefix' => 'thumb1', 'width' => 120, 'height' => 120)
                    )
                )
            )
        )
    );

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'password' => array(
                array('rule' => 'confirmpass', 'message' => __('Password not match', true)),
                array('rule' => 'notempty', 'message' => __('Required', true))
            ),
            'name' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'username' => array(
                array('rule' => 'notempty', 'message' => __('Required', true)),
                array('rule' => 'isUnique', 'message' => __('This username is already used', true), 'on' => 'create'),
            ),
            'email' => array(
                array('rule' => 'notempty', 'message' => __('Required', true)),
                array('rule' => 'email', 'message' => __('Enter a valid email', true)),
                array('rule' => 'isUnique', 'message' => __('This email is already used', true), 'on' => 'create'),
            )
        );
    }

    function confirmpass($data) {
        if ($this->data[$this->name]['password'] == $this->data[$this->name]['cpassword']) {
            return true;
        }
        $this->validationErrors["cpassword"] = "";
        return false;
    }

    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (empty($this->data[$this->name]['password']) && !empty($this->data[$this->name]['id'])) {
            unset($this->data[$this->name]['password']);
        } elseif (!empty($this->data[$this->name]['password'])) {
            $this->data[$this->name]['password'] = hashPassword($this->data[$this->name]['password']);
        }
        return true;
    }

}

?>