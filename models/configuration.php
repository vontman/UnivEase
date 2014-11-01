<?php

class Configuration extends AppModel {

    var $name = 'Configuration';

    function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->validate = array();
    }

    public $actsAs = array(
        'Image' => array(
            'fields' => array(
                'logo' => array(
                    'thumbnail' => array('create' => false),
//                    'resize' => array('height' => 41, 'allow_enlarge' => true),
                    'versions' => array(
                        array('prefix' => 'thumb1', 'height' => 100, 'allow_enlarge' => true),
                    )
                )
            )
        )
    );

}
?>