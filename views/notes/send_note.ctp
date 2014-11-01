<?php $title = __('Send note', true); ?>

<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $course_id)) ?>"><?php echo $course_name ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php __('Notes') ?></li>
    </ul>
</div>
  <div class="msghead">
        <ul class="msghead-menu">
            <li>
                <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
                <a class="btn" href="<?php echo Router::url(array('action' => 'index', $student_id,'?'=>array('crs_id'=>$course_id))) ?>"> 
                    <?php __('Student Notes') ?>
                    <i class="icon-plus"></i>
                </a>
            </li>
        </ul>
  </div>
<h1><?php echo $title; ?></h1>


<?php echo $form->create('Note', array('type' => 'file', "url" => array("action" => "send_note", $student_id))); ?>

<?php
echo $form->input('id', array('type' => 'hidden'));
echo $form->input('student_id', array('type' => 'hidden'));
echo $form->input('course_id', array('type' => 'hidden','value'=>$course_id));
echo $form->input('subject', array('class' => 'span6'));
echo $fck->load('Note', 'body', '', true, array("type" => "textarea"));
?>
<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>
<?php echo $form->end(); ?>

