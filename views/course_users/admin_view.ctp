
<div class="module">
    <h2><span><?php  __('Course User');?></span></h2>
    <div class="module-body">
        <dl><?php $i = 0; $class = ' class="altrow"';?>
            		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseUser['CourseUser']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseUser['User']['name'], array('controller' => 'users', 'action' => 'view', $courseUser['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($courseUser['Course']['name'], array('controller' => 'courses', 'action' => 'view', $courseUser['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $courseUser['CourseUser']['user_type']; ?>
			&nbsp;
		</dd>
        </dl>


        <div class="actions">
            <h3><?php __('Actions'); ?></h3>
            <ul>
                		<li><?php echo $this->Html->link(__('Edit Course User', true), array('action' => 'edit', $courseUser['CourseUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Course User', true), array('action' => 'delete', $courseUser['CourseUser']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $courseUser['CourseUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Course Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
            </ul>
        </div>
            </div>
</div>