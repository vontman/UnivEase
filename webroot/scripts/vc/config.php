<?php

	if (strpos($_SERVER['PHP_SELF'],'config.php') !== false) {
		echo 'Access Denied!';
		exit;
	}	
	function getAppKey(){
		return "DW02NA85MN01BU18RN21BK07WY43RS41";
	}
	
	function getRoomId(){
		return "19580";
	}	
	function getClassId(){
		return "13955";
	}	
	function getEventId(){
		return "906471395595764";
	}	
?>