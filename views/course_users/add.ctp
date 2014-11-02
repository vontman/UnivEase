<?php
if (!empty($this->data['CourseUser']['id'])) {
    $title = __('Edit enrolled user', true);
} else {
    $title = __('Enroll user', true);
}
?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $cuser['Course']['id'])) ?>"> <?php echo $cuser['Course']['name'] ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'course_users', 'action' => 'index', $cuser['Course']['id'])) ?>"> <?php echo __('Enrolled users', true) ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title; ?></li>
    </ul>
</div>
<h1><?php echo $title ?></h1>
<hr />


<?php echo $form->create('CourseUser', array('type' => 'file')); ?>
<div class="module-body">
    <?php
//    debug($this->data);
    echo $form->input('id');
    if (!empty($this->data['CourseUser']['id'])) {
        echo $form->input('username', array('readonly' => true, 'value' => $this->data['User']['name']));
    } else {
        echo $form->input('course', array('empty' => __("Please select", true)));
        echo $form->input('user_id',array('placeholder'=>__("Enter User ID",true),'type'=>"text"));
       /*echo $form->input('select_all', array('type' => "checkbox", "class" => "checkbox", "onclick" => "toggle(this)"));
        echo $form->input('user_id', array('multiple' => 'checkbox', 'div' => array('class' => 'input checkgroup'), 'label' => false));*/
        // echo $form->input('user_id', array('multiple' => true, 'class' => "chzn-select", 'style' => "width:220px;", 'data-placeholder' => __("Choose an user", true)));
    }
    echo $form->hidden('course_id');
    echo $form->input('user_type');
    ?>
    <div class="form-actions">
        <?php
        echo $form->submit('Submit', array('class' => 'btn btn-primary'));
        ?>
    </div>
</div>
<?php echo $form->end(); ?>
<?php
//echo $javascript->link(array('chosen.jquery'));
//echo $html->css(array('chosen'));
?>
<script>
    $(document).ready(function(){
        $("#CourseUserCourse").change(function(){
            window.location="<?php echo Router::url(array('controller' => 'course_users', 'action' => 'add', $cuser['Course']['id'])) ?>/"+this.value;
        });
        //   $('#CourseUserUserId').chosen({no_results_text: "<?php __("No results matched") ?>"});
     
    });
    
    function toggle(source) {
        var checkboxes = $('.checkgroup').find(':checkbox');
        if(source.checked) {
            checkboxes.attr('checked', 'checked');
        } else {
            checkboxes.removeAttr('checked');
        }
    }
</script>
