<?php
if (!empty($this->data['Schedule']['id'])) {

    $title = __('Edit Class Level', true);
} else {

    $title = __('Add Class Level', true);
}
?> 

<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'schedule_categories', 'action' => 'index')) ?>"><?php __('Class Category') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'schedules', 'action' => 'index',$cat_id)) ?>"><?php __('Class Level') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1>
<?php echo $title?>
</h1>


<?php echo $form->create('Schedule', array('type' => 'file')); ?>

<?php
        echo $this->Form->input('name', array('type' => 'text'));
        echo $this->Form->input('schedule_category_id', array('type' => 'hidden','value' => $cat_id));
?>

<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>

<?php echo $form->end(); ?>