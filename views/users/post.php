<?php
session_start();
include_once("global.php");
include("config1.php");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="description" content="<?php  echo $getsite->meta_des;?>">
<meta http-equiv="keywords" content="<?php  echo $getsite->m_ky;?>">
<title><?php echo $getsite->site_name ; ?> :: تسجيل عضوية جديدة</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE" />
<META NAME="COPYRIGHT" CONTENT="ModernIT" />
<META NAME="COPYRIGHT" CONTENT="http://www.modern-it.net" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" />

<!-- FancyBox -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
	<script type="text/javascript" src="fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="fancybox/jquery.fancybox-1.3.2.js"></script>
	<link rel="stylesheet" type="text/css" href="fancybox/jquery.fancybox-1.3.2.css" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {
			$("#Form1").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$("#Form2").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});	
			
			$("#Form3").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$("#Form4").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$("#Form5").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});									

		});
	</script>
<!-- FancyBox -->
</head>


<body>
<div class="wrap" align="right">
<div class="header">
<? include("header.php"); ?>
</div>

<div style="width:100%; float:right; clear:both">
<div style="width:100%; height:10px; clear:both"></div>
<? include("banner.php"); ?>

<div style="width:944px;float:right">

<div id="title" class="HeaderTitle title_lvl_1">
<ul class="breadcrumb">
<li><a href="index.html">الرئيسية</a></li>
<li><a href="#">تسجيل عضوية جديدة</a></li>
</ul>
</div>


    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr><td colspan="3" style="padding-top:5px"></td></tr>
    <tr>
    <td>
    <img src="images/clb.gif" width="6" border="0" height="6"></td>
    <td class="Table-up" width="100%" background="images/chb.gif" style="padding-bottom:5px">
    <div align="center" class="style5"></div></td>
    <td>
    <img src="images/crb.gif" width="6" border="0" height="6"></td>
    </tr>
    </tbody>
    </table>
    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
    <td background="images/componentBody.png">
    <img src="images/componentBody.png" width="2" border="0" height="1"></td>
    <td width="100%" bgcolor="#ffffff">
    <table width="98%" align="center" border="0" cellpadding="0">
    <tbody>
    <tr>
    <td width="100%" style="height:200px">

	<?
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
 		  
    
	clientDalc::insertRecord($name,$email,$user,$pass,$sex,$telephone,$mada,$school,$hash,$reg_date,0,$salit);
	
	    
	$subject="مرحبا بك في"." ".$getsite->site_name ; 
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'To:  "'.$name.'" < "'.$email.'">' . "\r\n";
	$headers .= 'From: "'.$name.'"  <"'.$getsite->site_name.'">' . "\r\n";	
	
$message = '
<html>
<body>
<table width="100%" align="center">
<tr>
<td align="center">

<table width="600" cellspacing="0" cellpadding="0" border="0" style="background-color:#ffffff; font-weight:bold" dir="rtl">
<tr>
<td align="right">
<img src="http://www.ubel-s.com/email/logo.png">
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
<a href="http://eteacher.learn-ubel.com//" target="_blank">هنا</a><br />
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
	
	
$users=mysql_query("INSERT INTO `users` (`name` , `username` , `password`, `email` , `created` , `approved` ) VALUES ('$name', '$user', '$pass1', '$email', '$reg_date',1)" ,$db1);
$users_id=mysql_insert_id($db1);
$courses=mysql_query("INSERT INTO `courses` (`name` , `active` , `created` ) VALUES ('$mada', 1, '$reg_date')" ,$db1);	
$courses_id=mysql_insert_id($db1);	
mysql_query("INSERT INTO `course_users` (`user_id` , `course_id` , `user_type` ) VALUES ('$users_id','$courses_id', 1 )" ,$db1);
print ("<META HTTP-EQUIV='Refresh' CONTENT='3; url=index.html'>");			
	?>
	<div align="center" style="font-weight:bold; font-family:ae_AlMothnna">
	تمت عملية التسجيل بنجاح<br />
	<img src="images/ajax-loader22.gif" /><br />
	لحظات ويتم تحويلك الى رئيسية الموقع
	</div>
  
    </td>
    </tr>
    <tr>
    <td colspan="2" align="center"></td>
    </tr>  
    </tbody></table>
    </td>
    <td background="images/componentBodyContainer.png">
    <img src="images/componentBodyContainer.png" width="2" border="0" height="1"></td>
    </tr>
    </tbody>
    </table>
    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">    
    <tbody>
    <tr>
    <td>
    <img src="images/cflF5.gif" width="6" border="0" height="6"></td>
    <td width="100%" background="images/cfF5.gif" nowrap="nowrap"></td>
    <td>
    <img src="images/cfrF5.gif" width="6" border="0" height="6"></td>
    </tr>
    </tbody>
    </table>

</div>

<div style="width:100%; height:10px; clear:both"></div>
</div>
</div>
<div style="background:#014460; float:right; width:100%; height: auto; ">
<? include("footer.php"); ?>
</div>


</body>
</html>
