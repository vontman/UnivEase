<?php

	if (strpos($_SERVER['PHP_SELF'],'appconf.php') !== false) {
		echo 'Access Denied!';
		exit;
	}	
	function getAppKey(){
		return "5AAA913C-89F7-4C73-9E02-B2C27E9D245D";
	}
	function getModelKey(){
		return "mqU1Ver4ttkfZ8ijCioqXN59YxlZI186gCGINoY5NZOgs6Ss";
	}
		
?>