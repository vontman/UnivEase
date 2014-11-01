<h2><span><?php __('Add Admin'); ?></span></h2>
<?php echo $form->create('Admin', array('action' => 'add_publisher', 'type' => 'file')); ?>
<div class="module-body">
    <?php
    echo $form->input('id');
    echo $form->input('username');
    echo $form->input('password');
    echo $form->input('email');
    if ($this->action == 'admin_edit') {
        echo $form->input('publisher');
    }

    echo $form->submit('Submit', array('class' => 'submit-green'));
    ?>
</div>
<?php echo $form->end(); ?>


