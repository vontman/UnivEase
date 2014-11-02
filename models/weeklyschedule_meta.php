<?php
class WeeklyscheduleMeta extends AppModel {
	var $name = 'WeeklyscheduleMeta';
	var $validate = array(
		'weeklyschedule_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Weeklyschedule' => array(
			'className'  => 'Weeklyschedule',
			'foreignKey' => 'weeklyschedule_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'WeeklyscheduleMetaLocation' => array(
			'className' => 'WeeklyscheduleMetaLocation',
			'foreignKey' => 'weeklyschedule_meta_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
