

<h1><?php echo $title ?></h1>
<?php echo $form->create('Course', array('type' => 'file')); ?>

<?php
echo $form->input('id');
echo $form->input('name');
  echo $this->Form->input('faculty_id', array('name'=>'faculty_id','id'=>'FacultyId','style'=>"",'label'=>'','options'=>array($faculty),'defaults'=>array(0=>'مواد فرعية'))); 
      
        echo '<div id="categ_rep">';
      
    echo '</div>';
echo $fck->load('Course', 'description');


?>

<?php
echo $form->input('image', array('type' => 'file',
    'between' => $this->element('image_element', array('info' => !empty($this->data['Course']['image']) ? $this->data['Course']['image'] : '', 'field' => 'image'))));
echo $form->input('active', array('label' => false, 'after' => '</div>', 'before' => '<label>' . __('Active', true) . '</label><div class="switch" data-on-label="<i class=\'icon-ok icon-white\'></i>" data-off-label="<i class=\'icon-remove\'></i>">'));
?>
<div class="form-actions">
<?php
echo $form->submit('Submit', array('class' => 'btn btn-primary'));
?>
</div>

    <?php echo $form->end(); ?>
<?php
echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'jquery-ui-timepicker-addon', 'chosen.jquery'));
echo $html->css(array('jquery-ui-1.8.24.custom', 'datetimepicker', 'chosen'));
?>
<?php
$this->Js->get('#FacultyId')->event('change', 
	$this->Js->request(array(
		'controller'=>'Courses',
		'action'=>'categ_add_ajax'
		), array(
		'update'=>'#categ_rep',
		'async' => true,
		//'method' => 'post',
		'dataExpression'=>true,
		'data'=> '$("#FacultyId").serialize()'
		))
	);
?>







