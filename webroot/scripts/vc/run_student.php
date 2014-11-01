<?php
//Script for launching virtual classroom for students without account
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//echo phpinfo();
$Url = 'http://vc.learn-ubel.com/apps/token.asp?cid=13955&appkey=DW02NA85MN01BU18RN21BK07WY43RS41';
 if (!function_exists('curl_init')){
 die('cURL is not installed!');
 }
$ch = curl_init();

// Set URL to download and other parameters 
curl_setopt($ch, CURLOPT_URL, $Url);
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

//access the classroom
//General link that will launch page with student name input
$link = "http://vc.learn-ubel.com/tools/dojoinevent.asp?eventid=906471395595764";
echo "<center>";
echo "<a href=". "'$link'" . "> Login to VC" . "</a>";
echo "</center>";
?>