<?php
if (!empty($this->data['Chat']['id'])) {
    $url = array('action' => 'edit', $this->data['Chat']['id']);
    $title = __('Edit Chat session', true);
} else {
    $url = array('action' => 'add', $course_id, '?' => array('level' => $_GET['level']));
    $title = __('Add Chat session', true);
}
?>    
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $cuser['Course']['id'])) ?>"> <?php echo $cuser['Course']['name'] ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'chats', 'action' => 'index', $cuser['Course']['id'],'?'=>array('level'=>!empty($this->data['Chat']['level'])?$this->data['Chat']['level']:$_GET['level']))) ?>"> <?php echo __('Chat sessions',true) ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1>
    <?php echo $title; ?>
</h1>


<?php echo $form->create('Chat', array('type' => 'file', 'url' => $url)); ?>

<?php
echo $form->input('id');
echo $form->input('name');
echo $fck->load('Chat','description');
echo $form->input('publish_date', array('type' => 'text', 'class' => 'hasDate', 'div' => array('class' => 'control-group')));
echo $form->input('cut_off', array('type' => 'text', 'class' => 'hasDate', 'div' => array('class' => 'control-group')));
?>
<div class="form-actions">
<?php
echo $form->submit('Submit', array('class' => 'btn btn-primary'));
?>
</div>
<?php echo $form->end(); ?>
<?php
echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'jquery-ui-timepicker-addon'));
echo $html->css(array('jquery-ui-1.8.24.custom', 'datetimepicker'));
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.hasDate').datetimepicker({
            "dateFormat": 'yy-mm-dd',
            changeMonth: true,
            changeYear: true,
            isRTL: true
        });
    });
</script>
