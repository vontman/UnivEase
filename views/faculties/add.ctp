

<h1><?php //echo $title ?></h1>
<hr />


<?php echo $form->create('Faculty', array('type' => 'file')); ?>
<div class="module-body">
    <?php
//    debug($this->data);
   
    
 echo $form->input('name');
//echo $form->input('category_id', array('empty' => __('Select one', true)));
echo $fck->load('Faculty', 'description');
?>
<div class="form-actions">
        <?php
        echo $form->submit('Submit', array('class' => 'btn btn-primary'));
        ?>
 </div>
</div>
<?php echo $form->end();

