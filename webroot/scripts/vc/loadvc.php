<?php
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
	include_once('config.php');
	$cid = getClassId();
	$appkey = getAppKey();
	$roomid = getRoomId();
	$Url = 'http://vc.learn-ubel.com/';
	$params = 'apps/token.asp?cid='.$cid.'&appkey='.$appkey;
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
	
	//Hack to get the session token
	//TODO:Use XML parser to get session token
	$token = substr($output, 92, 36);
	
	// Close the cURL resource, and free system resources 
	curl_close($ch);
	$vcUrl = $Url."/apps/launch.asp?"; 
	$token = "token=".$token;
	$cid = "&cid=".$cid;
	$rid = "&roomid=".$roomid;
	$fname = $extname = $userType = '';
	if(isset($_GET['fname']))
		$fname = $_GET['fname'];
	if(isset($_GET['ename']))		
		$extname = $_GET['ename'];
	if(isset($_GET['utype']))		
		$userType = $_GET['utype'];
	if($userType == 0 || $userType == 1 )
		$usrtid = 0;
	else if($userType == 2 )
		$usrtid = 1000;
	$utid = "&usertypeid=".$usrtid;
	$fname = "&firstname=".$fname;
	$ename = "&externalname=".$extname;
	$vcLink = $vcUrl.$token.$cid.$rid.$utid.$fname.$ename;
	if($userType == 0 ){
		$eventId = getEventId();
		$vcLink = "http://vc.learn-ubel.com/tools/dojoinevent.asp?eventid=".$eventId;
	}
	//access the classroom
	echo "<body onLoad='loadVc()'>";
	echo "<center>";
	echo '<img src="loading.gif">';
	echo "</center>";
	echo "</body>";
	echo '<script type="text/javascript">
	function loadVc () { window.location = "'.$vcLink.'";	}
	</script>';
	//<!-- END ELECTA LIVE LOGIN FORM -->
?>