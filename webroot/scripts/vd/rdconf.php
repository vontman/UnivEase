<?php

	if (strpos($_SERVER['PHP_SELF'],'rdconf.php') !== false) {
		echo 'Access Denied!';
		exit;
	}	
	function getAppKey(){
		return "B19E1362-F8C9-4646-AD8F-76E6DFBB2274";
	}
		
?>