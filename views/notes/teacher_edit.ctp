<h2>
    <span>
        <?php

            	if(!empty($this->data['Message']['id'])){

            		__('Edit Message');

                	}else{

                		__('Add Message');

                	}
            ?>    </span>
</h2>


<?php echo $form->create('Message',array('type'=>'file'));?>
<div class="module-body">
    	<?php
		echo $form->input('id');
		echo $form->input('from');
		echo $form->input('teacher_id');
		echo $form->input('students');
		echo $form->input('student_id');
		echo $form->input('read');
		echo $form->input('subject');
		echo $form->input('body');
		echo $form->input('message_id');
echo 	$form->submit('Submit', array('class' => 'submit-green'));
	?>

    <?php echo $form->end();?>

    <div class="actions">
        <h3><?php __('Actions'); ?></h3>
        <ul>

                            <li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Message.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Message.id'))); ?></li>
                        <li><?php echo $this->Html->link(__('List Messages', true), array('action' => 'index'));?></li>
            		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Teacher', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Messages', true), array('controller' => 'messages', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Message', true), array('controller' => 'messages', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>