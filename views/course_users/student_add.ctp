

<?php
$this->Html->script('prototype', array('inline' => false));
if (!empty($this->data['CourseUser']['id'])) {
    $title = __('Edit enrolled user', true);
} else {
    $title = __('Enroll user', true);
}
?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
    </ul>
</div>
<h1><?php echo $title ?></h1>
<hr />


<?php $url = array('action' => 'add_id');?>
<?php echo $form->create('CourseUser', array('type' => 'post','action' =>'student_add')); ?>
<div class="module-body">
    <?php

    
    
        echo $this->Form->input('user_id',array('value'=>$user_id,'type'=>'hidden'));
        if(!empty($categ)){
        echo $this->Form->input('category_id', array('name'=>'category_id','id'=>'CategoryId','style'=>"margin-top: -5px;width: 23%;Height: 34px;",'label'=>'','options'=>array(0=>'mwad' ,$categ),'defaults'=>array(0=>'مواد فرعية'))); 
        }
        echo '<div id="crs_rep">';
      
    echo '</div>';
        
    
    
    
    ?>
    
</div>
<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>



<?php
/*
$this->Js->get('#CourseUserCategoryId')->event('change', 
	$this->Js->request(array(
		'controller'=>'CourseUsers',
		'action'=>'student_add'
		), array(
		'update'=>'#CourseUsercourseId',
		'async' => true,
		'method' => 'post',
		'dataExpression'=>true,
		
		))
	);*/

?>


<?php
$this->Js->get('#CategoryId')->event('change', 
	$this->Js->request(array(
		'controller'=>'CourseUsers',
		'action'=>'student_add_ajax'
		), array(
		'update'=>'#crs_rep',
		'async' => true,
		//'method' => 'post',
		'dataExpression'=>true,
		'data'=> '$("#CategoryId").serialize()'
		))
	);
?>