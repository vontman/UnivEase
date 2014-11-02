
<div class="module">
    <h2><span><?php  __('Chat');?></span></h2>
    <div class="module-body">
        <dl><?php $i = 0; $class = ' class="altrow"';?>
            		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $chat['Chat']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $chat['Chat']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $chat['Chat']['description']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Course'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($chat['Course']['name'], array('controller' => 'courses', 'action' => 'view', $chat['Course']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Level'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $chat['Chat']['level']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $chat['Chat']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $chat['Chat']['updated']; ?>
			&nbsp;
		</dd>
        </dl>


        <div class="actions">
            <h3><?php __('Actions'); ?></h3>
            <ul>
                		<li><?php echo $this->Html->link(__('Edit Chat', true), array('action' => 'edit', $chat['Chat']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Chat', true), array('action' => 'delete', $chat['Chat']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $chat['Chat']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Chats', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Chat', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Courses', true), array('controller' => 'courses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Course', true), array('controller' => 'courses', 'action' => 'add')); ?> </li>
            </ul>
        </div>
            </div>
</div>