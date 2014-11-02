
<?php 
debug();

echo $form->create('User', array('type' => 'post','action' =>'categ_add_ajax')); 
    if(!empty($category)){
         echo $this->Form->input('category_id', array('id'=>'UsercourseId','options'=> $category));
    }
?>
  
        
