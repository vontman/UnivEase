<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Configurations', true) ?></li>
    </ul>
</div>

<h1><?php __('Edit Configurations'); ?></h1>
<hr />
<?php echo $form->create('Configuration', array('type' => 'file')); ?>

<?php
echo $form->input('id', array('value' => '1'));
echo $form->input('site_name');
echo $form->input('admin_email');
echo $form->input('admin_send_mail_from');
echo $form->input('sms_username');
echo $form->input('sms_password');
echo $form->input('sms_sender');
echo $form->input('user_activation', array('empty' => __('Choose one', true), 'options' => array(1 => __('By email', true), 2 => __('Manual', true))));
echo $timezone->select('timezone', array('label' => __('Choose default time zone for the system',true)));
?>
<hr />
<h1><?php  __('Appearance')?></h1>
<hr />
<?php
echo $form->input('logo', array('type' => 'file',
    'between' => $this->element('image_element', array('info' => !empty($this->data['Configuration']['logo']) ? $this->data['Configuration']['logo'] : '', 'field' => 'logo'))));
echo $form->input('footer');
//    echo $form->input('facebook_url');
//    echo $form->input('twitter_url');
//echo $form->input('home_keywords');
//echo $form->input('home_description');
?>

<hr />
<h1><?php  __('Certification Setting'); ?></h1>
<hr />
<div>
    <?php
        echo $form->input('nickname');
        echo $form->input('admin_name');
        echo $form->input('certification_text');
    ?>
</div>

<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>
<?php echo $form->end(); ?>


