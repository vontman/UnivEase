<?php echo $form->create('CourseUser', array('type' => 'post','action' =>'student_add')); 
    if(!empty($courses)){
         echo $this->Form->input('course_id', array('id'=>'CourseUsercourseId','style'=>"margin-top: -5px;width: 23%;Height: 34px;",'label'=>'','options'=> $courses));
    }
?>
  
        
