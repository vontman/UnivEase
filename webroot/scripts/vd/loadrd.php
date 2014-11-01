<?php
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	include_once('rdconf.php');
	$appkey = getAppKey();
	$uname = 'teacher';
	$password = 'abc@123';
	$Url = 'http://vpc.ubel.org:5015/ws/oturl/get?';
	$params = 'apikey='.$appkey.'&plen=10&expires=30&username='.$uname.'&password='.$password.'&soundenabled=true&soundquality=1';
	$cUrl = $Url.$params;
	if (!function_exists('curl_init')){
	 die('cURL is not installed!');
	}
	

	$ch = curl_init();
	
	// Set URL to download and other parameters 
	curl_setopt($ch, CURLOPT_URL, $cUrl);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	
	// Download the given URL, and return output
	$output = curl_exec($ch);
	
	// Close the cURL resource, and free system resources 
	curl_close($ch);
	
	$rdLink = "http://vpc.ubel.org:5015".$output;
	//access the classroom
	echo "<body onLoad='loadRd()'>";
	echo "<center>";
	echo '<img src="loading.gif">';
	echo "</center>";
	echo "</body>";
	echo '<script type="text/javascript">
	function loadRd () { window.location = "'.$rdLink.'";	}
	</script>';
	//<!-- END ELECTA LIVE LOGIN FORM -->
?>