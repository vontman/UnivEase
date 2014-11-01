<?php
session_start();
include_once("global.php");
include("config1.php");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- FancyBox -->

	<script type="text/javascript" src="jquery-ui-1.8.24.custom.min.js"></script>
        <script type="text/javascript" src="jquery.colorbox-min.js"></script>
	        <link rel="stylesheet" href=jquery-ui-1.8.24.custom.css" type="text/css"></link>
        <link rel="stylesheet" href=colorbox.css" type="text/css"></link>
        
	
<!-- FancyBox -->
</head>






    
   
  

	<?php
	$user=strip_tags($_POST["email"]);	
	$name=strip_tags($_POST["name"]);
	$email=strip_tags($_POST["email"]);
	$pass=md5(md5($_POST['pass']));
	$salit=$_POST['pass'];
	$sex=strip_tags($_POST["sex"]);
	$mada=strip_tags($_POST['mada']);	
	$school=strip_tags($_POST["school"]);  
	$telephone=strip_tags($_POST["telephone"]);  
	$hash=rand();	
	$reg_date=date("Y-m-j"); 
	$pass1=md5($_POST['pass']);	
	$pass2=$_POST['pass'];	
 		  
     $salt = substr(md5(uniqid(mt_rand(), true)), 0, 3);
$usr_pass = md5(md5($_POST['pass']) . md5($salt));
	clientDalc::insertRecord($name,$email,$user,$pass,$sex,$telephone,$mada,$school,$hash,$reg_date,0,$salit);
	
	    
	$subject="مرحبا بك في"." ".$getsite->site_name ; 
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'To:  "'.$name.'" < "'.$email.'">' . "\r\n";
	$headers .= 'From: learn-ubel  <"'.$getsite->site_name.'">' . "\r\n";	
	
$message = '
<html>
<body>
<table width="100%" align="center">
<tr>
<td align="center">

<table width="600" cellspacing="0" cellpadding="0" border="0" style="background-color:#ffffff; font-weight:bold" dir="rtl">
<tr>
<td align="right">
<img src="http://www.ubel-s.com/email/logo1.png">
</td>
</tr>
<tr>
<td align="right">

اهلا ومرحبا بك :: "'.$name.'"<br />
شكرا على تسجيلك فى موقع  :: "'.$getsite->site_name.'"<br />
اسم المستخدم  :: "'.$user.'"<br />
كلمة المرور :: "'.$pass2.'"<br />
يمكنك الان الاشتراك فى الخطط التعليمية  من خلال الرابط التالى 
<a href="http://ubel-s.com/plans.html" target="_blank">هنا</a><br />
لقد حصلت على مدة 30 يوم تجريبي لنظام يوبل  للتعليم التفاعلي<br />
و يمكنك الان متابعة مادتك الدراسية على الرابط التالي
<a href="http://learn-ubel.com//" target="_blank">هنا</a><br />
يرجى سرعة تجديد الاشتراك

</td>
</tr>
</table>
</table>
</body>
</html>
';
	
	mail($email,$subject,$message,$headers);			
	$client=clientDalc::getByHash($hash);
	clientDalc::updateHash($client->id,NULL);	
		
	$_SESSION["Ubel_ID"]=$client->id; 			
	
	


mysql_query("INSERT INTO `phpfox_user` (`profile_page_id`, `server_id`, `user_group_id`, `status_id`, `view_id`, `user_name`, `full_name`, `password`, `password_salt`, `email`, `gender`, `birthday`, `birthday_search`, `country_iso`, `language_id`, `style_id`, `time_zone`, `dst_check`, `joined`, `last_login`, `last_activity`, `user_image`, `hide_tip`, `status`, `footer_bar`, `invite_user_id`, `im_beep`, `im_hide`, `is_invisible`, `total_spam`, `last_ip_address`)
                    VALUES ('0', '0', '2', '0', '0', '$name', '$name', '$usr_pass', '$salt', '$email', '1', NULL, '0', 'EG', 'en', '0', NULL, '0', '0', '0', '0', NULL, '0', NULL, '0', '0', '0', '0', '0', '0', NULL)",$db1);

$id=mysql_insert_id($db1);


mysql_query("INSERT INTO phpfox_user_count (user_id) VALUES ( '$id')",$db1);

mysql_query("INSERT INTO phpfox_user_field (user_id) VALUES ( '$id')",$db1);

mysql_query("INSERT INTO phpfox_user_space (user_id) VALUES ( '$id')",$db1);

mysql_query("INSERT INTO phpfox_user_activity (user_id) VALUES ( '$id')",$db1);



//status=11 to differentiate between users that sign up from ubel-s
$users=mysql_query("INSERT INTO `users` (`name` , `username` ,`mobile`, `password`, `email` ,`status`, `created` , `approved` ) VALUES ('$name', '$user','$telephone', '$pass1', '$email','11', '$reg_date',1)" ,$db1);
$users_id=mysql_insert_id($db1);
$courses=mysql_query("INSERT INTO `courses` (`name` , `active` , `created` ) VALUES ('$mada', 1, '$reg_date')" ,$db1);	
$courses_id=mysql_insert_id($db1);	
mysql_query("INSERT INTO `course_users` (`user_id` , `course_id` , `user_type` ) VALUES ('$users_id','$courses_id', 1 )" ,$db1);




echo '<div id="data">
اهلا ومرحبا بك :: "'.$name.'"<br />
شكرا على تسجيلك فى موقع  :: "'.$getsite->site_name.'"<br />
اسم المستخدم  :: "'.$user.'"<br />
كلمة المرور :: "'.$pass2.'"<br />
يمكنك الان الاشتراك فى الخطط التعليمية  من خلال الرابط التالى 
<a href="http://ubel-s.com/plans.html" target="_blank">هنا</a><br />
لقد حصلت على مدة 30 يوم تجريبي لنظام يوبل  للتعليم التفاعلي<br />
و يمكنك الان متابعة مادتك الدراسية على الرابط التالي
ا
<a href="http://learn-ubel.com//" target="_blank">هنا</a><br />
</div>
';
?>


</html>
<script type="text/javascript">
    
 function openColorBox() {
        $.colorbox({inline:true, width:"50%", open:true, href:"#data",overlayClose: false,
            onClosed: function() {
                 $('#data').hide();
               window.location = "http://www.learn-ubel.com/";
            },
            onOpen: function() {
                 $('#data').show();
                 $('#cboxClose').remove();
            }
           }); 
      }
      setTimeout(openColorBox, 100);    
               

</script>
