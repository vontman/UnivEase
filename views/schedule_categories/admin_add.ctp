<?php
if (!empty($this->data['ScheduleCategory']['id'])) {

    $title = __('Edit Schedule Category', true);
} else {

    $title = __('Add Schedule Category', true);
}
?> 

<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'schedule_categories', 'action' => 'index')) ?>"><?php __('Class Category') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1>
<?php echo $title?>
</h1>


<?php echo $form->create('ScheduleCategory', array('type' => 'file')); ?>

<?php   $user = $this->is_user();
        $user_id = $user['id'];
        
        echo $this->Form->input('name', array('type' => 'text'));
?>

<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>

<?php echo $form->end(); ?>