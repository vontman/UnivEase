<h1><?php __('My Profile') ?></h1>
<hr />
<?php
$session->flash();
echo $form->create('Admin', array('type' => 'file', 'url' => array('action' => 'profile')));
?>

<?php
echo $form->input('id');
echo $form->input('name');
echo $form->input('username');
echo $form->input('password');
echo $form->input('cpassword', array("type" => "password", "label" => __("Confirm Password", true)));
echo $form->input('email');
echo $form->input('telephone');
echo $form->input('mobile');
echo $form->input('address');
echo $form->input('birth_date', array('type' => 'text', 'class' => 'hasDate'));
?>

<div class = "input text">
    <label><?php __('Image'); ?></label>
    <?php
    echo $form->input('image', array('type' => 'file', 'label' => false,
        'between' => $this->element('image_element', array('info' => !empty($this->data['Admin']['image']) ? $this->data['Admin']['image'] : '', 'field' => 'image'))));
    ?> 
</div>

<div class="form-actions">
    <div class="input submit">
        <input type="submit" alt="Submit" value="<?php __('Edit') ?>" class="btn btn-primary" />
    </div>
</div>
<?php echo $form->end(); ?>

<?php
echo $html->css('jquery-ui-1.8.24.custom');
echo $javascript->link('jquery-ui-1.8.24.custom.min');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
            changeYear: true});
    });
    $('.hasDate').live('focus', function() {
        $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
            changeYear: true});
    })
</script>