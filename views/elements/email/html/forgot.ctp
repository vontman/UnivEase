<font face='Arial'>
     Hi <?=$data['given_name']." ".$data['surname']?>,<br /><br />
    You recently requested a new password.<br /> <br />
    Your email: <?=$data['email']?><br /> <br />
    Here is your reset code, which you can enter on the password reset page:<br />
    <?=$new_password?> <br /><br />You can also reset your password by following the link below:<br />
    <a href="<?=Router::url(array('action'=>'confirm_password'),true)?>?email=<?=$data['email']?>&code=<?=$new_password?>" >Go to reset page</a><br /><br />
    If you did not reset your password, please disregard this message.<br /><br />
    Thanks,<br />
    <?php echo $config['txt.site_name'] ?>
</font>