<font face="Arial" style="font-size:18px;" ><?php echo __('welcome',true).' '.$user_data['name'] ?> </font><br /><br />
<?php __('You must activate your account to login')?>

<br />


<br />
<?php __('To activate your account go to the following link')?>
<br />
<a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'confirm', base64_encode($user_data['id'] . '-' . $user_data['email'])), true) ?>"><?php echo Router::url(array('controller' => 'users', 'action' => 'confirm', base64_encode($user_data['id'] . '-' . $user_data['email'])), true) ?></a>