<div class="students view">
    <h2><?php  __('Student');?></h2>
    <dl><?php $i = 0; $class = ' class="altrow"';?>
        		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $student['Student']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $student['Student']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $student['Student']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $student['Student']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Group'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($student['Group']['name'], array('controller' => 'groups', 'action' => 'view', $student['Group']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $student['Student']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Updated'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $student['Student']['updated']; ?>
			&nbsp;
		</dd>
    </dl>
</div>
<div class="actions">
    <h3><?php __('Actions'); ?></h3>
    <ul>
        		<li><?php echo $this->Html->link(__('Edit Student', true), array('action' => 'edit', $student['Student']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Student', true), array('action' => 'delete', $student['Student']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $student['Student']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Students', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groups', true), array('controller' => 'groups', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group', true), array('controller' => 'groups', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Student Exams', true), array('controller' => 'student_exams', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Student Exam', true), array('controller' => 'student_exams', 'action' => 'add')); ?> </li>
    </ul>
</div>
    <div class="related">
        <h3><?php __('Related Student Exams');?></h3>
    <?php if (!empty($student['StudentExam'])):?>
        <table cellpadding = "0" cellspacing = "0">
            <tr>
                		<th><?php __('Id'); ?></th>
		<th><?php __('Exam Id'); ?></th>
		<th><?php __('Student Id'); ?></th>
		<th><?php __('Student Answer'); ?></th>
		<th><?php __('Techer Answer'); ?></th>
		<th><?php __('Answered'); ?></th>
                <th class="actions"><?php __('Actions');?></th>
            </tr>
            	<?php
		$i = 0;
		foreach ($student['StudentExam'] as $studentExam):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $studentExam['id'];?></td>
			<td><?php echo $studentExam['exam_id'];?></td>
			<td><?php echo $studentExam['student_id'];?></td>
			<td><?php echo $studentExam['student_answer'];?></td>
			<td><?php echo $studentExam['techer_answer'];?></td>
			<td><?php echo $studentExam['answered'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'student_exams', 'action' => 'view', $studentExam['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'student_exams', 'action' => 'edit', $studentExam['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'student_exams', 'action' => 'delete', $studentExam['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $studentExam['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
        </table>
    <?php endif; ?>

        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('New Student Exam', true), array('controller' => 'student_exams', 'action' => 'add'));?> </li>
            </ul>
        </div>
    </div>
