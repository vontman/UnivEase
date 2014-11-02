<font face="Arial" style="font-size:18px;" ><?php __('Your account has been approved'); ?> </font><br /><br />

<br />
<br />
<?php __('You can login now'); ?>
<a href="<?php echo Router::url( array('controller' => 'users', 'action' => 'login'),true)?>">
    <?php echo Router::url(array('controller' => 'users', 'action' => 'login'),true)?>
</a>
