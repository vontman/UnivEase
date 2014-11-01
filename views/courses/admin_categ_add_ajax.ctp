
<?php 


echo $form->create('Course', array('type' => 'post','action' =>'categ_add')); 
    if(!empty($category)){
         echo $this->Form->input('category_id', array('id'=>'CoursecourseId','options'=> $category));
    }
?>
  
        
