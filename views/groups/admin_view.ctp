<div class="groups view">
    <h2><?php  __('Group');?></h2>
    <dl><?php $i = 0; $class = ' class="altrow"';?>
        		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $group['Group']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Teacher'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($group['Teacher']['name'], array('controller' => 'teachers', 'action' => 'view', $group['Teacher']['id'])); ?>
			&nbsp;
		</dd>
    </dl>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        		<li><?php echo $this->Html->link(__('Edit Group', true), array('action' => 'edit', $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Group', true), array('action' => 'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $group['Group']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Teachers', true), array('controller' => 'teachers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Teacher', true), array('controller' => 'teachers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Exams', true), array('controller' => 'exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Exam', true), array('controller' => 'exams', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('controller' => 'students', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
    </ul>
</div>
    <div class="related">
        <h3><?php __('Related Exams');?></h3>
    <?php if (!empty($group['Exam'])):?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Teacher Id'); ?></th>
		<th><?php __('Group Id'); ?></th>
                <th class="actions"><?php __('Actions');?></th>
            </tr>
            	<?php
		$i = 0;
		foreach ($group['Exam'] as $exam):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $exam['id'];?></td>
			<td><?php echo $exam['name'];?></td>
			<td><?php echo $exam['teacher_id'];?></td>
			<td><?php echo $exam['group_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'exams', 'action' => 'view', $exam['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'exams', 'action' => 'edit', $exam['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'exams', 'action' => 'delete', $exam['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $exam['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
        </table>
    <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('New Exam', true), array('controller' => 'exams', 'action' => 'add'));?> </li>
            </ul>
        </div>
    </div>
    <div class="related">
        <h3><?php __('Related Students');?></h3>
    <?php if (!empty($group['Student'])):?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                		<th><?php __('Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Username'); ?></th>
		<th><?php __('Password'); ?></th>
		<th><?php __('Group Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Updated'); ?></th>
                <th class="actions"><?php __('Actions');?></th>
            </tr>
            	<?php
		$i = 0;
		foreach ($group['Student'] as $student):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $student['id'];?></td>
			<td><?php echo $student['name'];?></td>
			<td><?php echo $student['username'];?></td>
			<td><?php echo $student['password'];?></td>
			<td><?php echo $student['group_id'];?></td>
			<td><?php echo $student['created'];?></td>
			<td><?php echo $student['updated'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'students', 'action' => 'view', $student['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'students', 'action' => 'edit', $student['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'students', 'action' => 'delete', $student['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $student['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
        </table>
    <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add'));?> </li>
            </ul>
        </div>
    </div>
