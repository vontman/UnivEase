

<h1>
    <?php //echo __($title,true); ?>
</h1>
<?php echo $form->create('Category', array('type' => 'file')); ?>
<div class="module-body">
    <?php
    echo $form->input('id');
    echo $form->input('name');
   echo $this->Form->input('faculty_id', array('options'=> $faculties)); 
//    echo $form->input('display_order');
    
echo $form->input('image', array('type' => 'file',
    'between' => $this->element('image_element', array('info' => !empty($this->data['Faculty']['image']) ? $this->data['Faculty']['image'] : '', 'field' => 'image'))));

?>
    
    <div class = "form-actions">
        <?php
        echo $form->submit('Submit', array('class' => 'btn btn-primary'));
        ?>
    </div>

</div>
<?php echo $form->end(); ?>



