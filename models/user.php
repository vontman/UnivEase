<?php

class User extends AppModel {

    var $name = 'User';
    var $is_profile = false;
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
                
                array('rule' => 'notempty', 'message' => __('Required', true))
            ),
            'name' => array('rule' => 'notempty', 'message' => __('Required', true)),
            'username' => array(
                array('rule' => 'notempty', 'message' => __('Required', true)),
                array('rule' => array('minLength', '4'),'message' => __('Minimum 4 characters long',true)),
                array('rule' => 'isUnique', 'message' => __('This username is already used', true), 'on' => 'create'),
            ),
            'email' => array(
                array('rule' => 'notempty', 'message' => __('Required', true)),
                array('rule' => 'email', 'message' => __('Enter a valid email', true)),
                array('rule' => 'isUnique', 'message' => __('This email is already used', true), 'on' => 'create'),
            ),
 //           'security_code' => array('rule' => 'checkCaptcha', 'message' => __('Invalid security code', true))
//            'group_id' => array('rule' => 'notempty', 'message' => __('Required', true)),
        );
    }
       var $belongsTo = array(

         'Faculty' => array(
            'className' => 'Faculty',
            'foreignKey' => 'faculty_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
   
  

    var $schema = array(
        0 => "name", 1 => 'username', 2 => 'email', 3 => 'password', 4 => 'telephone', 5 => 'mobile',
        6 => 'address', 7 => 'birth date', 8=> 'nationality'
    );

//The Associations below have been created with all possible keys, those that are not needed can be removed


    function beforeValidate($options = array()) {
        parent::beforeValidate($options);
        $this->data[$this->name]['username']=  trim($this->data[$this->name]['username']);
        if (!empty($this->data[$this->name]['password'])) {
            $this->validate['passwd'] = array('rule' => 'checkPasswd', 'message' => 'Passwords not matched');
        } elseif (empty($this->data[$this->name]['password']) && !empty($this->data[$this->name]['id'])) {
            unset($this->data[$this->name]['password'], $this->data[$this->name]['passwd'], $this->validate['password'], $this->validate['passwd']);
        }

        return true;
    }

    function beforeSave($options = array()) {
        parent::beforeSave($options);
        if (!empty($this->data[$this->name]['password'])) {
            $this->data[$this->name]['password'] = hashPassword($this->data[$this->name]['password']);
        }


        return true;
    }

    function checkPasswd($data) {
        if (!empty($this->data[$this->name]['password'])) {
            return $this->data[$this->name]['password'] == $data['passwd'];
        }
        return true;
    }

    
}

