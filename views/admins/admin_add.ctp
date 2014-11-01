<?php
if (!empty($this->data['Exam']['id'])) {
    $title = __('Edit Adminstrator', true);
} else {
    $title = __('Add Adminstrator', true);
}
?> 
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'admins', 'action' => 'index')) ?>"> <?php __("Administrators") ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1><?php echo $title; ?></h1>
<hr />
<?php
$session->flash();
echo $form->create('Admin', array('type' => 'file'));
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
//echo $form->input('birth_date', array('type' => 'text', 'class' => 'hasDate'));
?>

<div class = "input text">
    <label><?php __('Image'); ?></label>
    <?php
    echo $form->input('image', array('type' => 'file', 'label' => false,
        'between' => $this->element('image_element', array('info' => !empty($this->data['User']['image']) ? $this->data['User']['image'] : '', 'field' => 'image'))));
    ?> 
</div>

<div class="form-actions">
    <div class="input submit">
        <input type="submit" alt="Submit" value="<?php
    if (!empty($this->data['Exam']['id'])) {
        __('Edit');
    } else {
        __('Add');
    }
    ?>" class="btn btn-primary" />
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