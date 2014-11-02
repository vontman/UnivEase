<?php 
    debug($group);
?>
<div >
    <ul class="nav nav-tabs" style="margin-left:0;" id="myTab">
        <li class="active"><a data-toggle="tab" href="#group_info">Info</a></li>
        <li><a data-toggle="tab" href="#group_users">Users</a></li>
        <li><a data-toggle="tab" href="#group_uploads">Uploads</a></li>
        <li><a data-toggle="tab" href="#group_actions">Actions</a></li>
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">Dropdown <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a data-toggle="tab" href="#dropdown1">Dropdown1</a></li>
                <li><a data-toggle="tab" href="#dropdown2">Dropdown2</a></li>
            </ul>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div id="group_info" class="tab-pane fade in active">
            <h3><?php  __('Group');?></h3>
            <div class="groups_info">
                <h2><?php echo $group['Group']['name']; ?></h2>
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
                            <dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
                            <dd<?php if ($i++ % 2 == 0) echo $class;?>>
                                    <?php echo $group['Group']['description']; ?>
                                    &nbsp;
                            </dd>
                </dl>
            </div>
        </div>
        <div id="group_users" class="tab-pane fade">
            <div class="users">
            <h3>Teachers</h3>
                <?php if (!empty($group['GroupUser'])):?>
                <table class='table'>
                    <tr>
                                        <th><?php __('Id'); ?></th>
                        <th><?php __('Name'); ?></th>
                        <th><?php __('Username'); ?></th>
                        <th><?php __('Created'); ?></th>
                        <th><?php __('Updated'); ?></th>
                        <th class="actions"><?php __('Actions');?></th>
                    </tr>
                        <?php
                        $i = 0;
                        foreach ($group['User'] as $teacher):
                            debug($teacher);
//                            $teacher=$teacher['name'];
                                $class = null;
                                if ($i++ % 2 == 0) {
                                        $class = ' class="altrow"';
                                }
                        ?>
                        <tr<?php echo $class;?>>
                                <td><?php echo $teacher['id'];?></td>
                                <td><?php echo $teacher['name'];?></td>
                                <td><?php echo $teacher['username'];?></td>
                                <td><?php echo $teacher['created'];?></td>
                                <td><?php echo $teacher['updated'];?></td>
                                <td class="actions">
                                        <?php echo $this->Html->link(__('View', true), array('controller' => 'students', 'action' => 'view', $teacher['id'])); ?>
                                        <?php echo $this->Html->link(__('Edit', true), array('controller' => 'students', 'action' => 'edit', $teacher['id'])); ?>
                                        <?php echo $this->Html->link(__('Delete', true), array('controller' => 'students', 'action' => 'delete', $teacher['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $teacher['id'])); ?>
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
            <h3>Students</h3>
                <?php if (!empty($group['students'])):?>
                <table class='table'>
                    <tr>
                                        <th><?php __('Id'); ?></th>
                        <th><?php __('Name'); ?></th>
                        <th><?php __('Username'); ?></th>
                        <th><?php __('Created'); ?></th>
                        <th><?php __('Updated'); ?></th>
                        <th class="actions"><?php __('Actions');?></th>
                    </tr>
                        <?php
                        $i = 0;
                        foreach ($group['students'] as $student):
                            $student=$student['User'];
                                $class = null;
                                if ($i++ % 2 == 0) {
                                        $class = ' class="altrow"';
                                }
                        ?>
                        <tr<?php echo $class;?>>
                                <td><?php echo $student['id'];?></td>
                                <td><?php echo $student['name'];?></td>
                                <td><?php echo $student['username'];?></td>
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
        </div>
        <div id="group_uploads" class="tab-pane fade">
            <div class="uploads"> 
                <?php echo $this->Form->create('Upload', array('type' => 'file','url'=>array('controller'=>'groups','action'=>'group_upload'))); ?>
                    <legend><?php __('Add Upload'); ?></legend>                       
                    <?php echo $this->Form->input("name");
                    echo $this->Form->input("File",array('type'=>'file'));
                    echo $this->Form->input('group_id',array('type'=>'hidden','value'=>$group['Group']['id']));
                echo $this->Form->end("Upload");?>
            <h3>PDFs</h3>
                <ul>
                    <?php
                        foreach($group['uploads']['pdf'] as $upload){
                            $upload=$upload['Upload'];
                            echo "<li>".$this->Html->link($upload['name'].".".$upload['type'],WWW_ROOT . 'uploads/groups' . DS .$upload['name'].'.'.$upload['type'])."</li>";
                        }
                    ?>
                </ul>
            <h3>Images</h3>                    
                <ul>
                    <?php
                        foreach($group['uploads']['img'] as $upload){
                            $upload=$upload['Upload'];
                            echo "<li><img height=120 src='".WWW_ROOT . 'uploads/groups' . DS .$upload['name'].'.'.$upload['type']."'>".$this->Html->link($upload['name'].".".$upload['type'],WWW_ROOT . 'uploads/groups' . DS .$upload['name'].'.'.$upload['type'])."</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <div id="group_actions" class="tab-pane fade">
            <h3>Actions</h3>
            <div class="actions">
                    <ul>                
                        <li><?php echo $this->Html->link(__('Edit Group', true), array('action' => 'edit', $group['Group']['id'])); ?> </li>
                        <li><?php echo $this->Html->link(__('Delete Group', true), array('action' => 'delete', $group['Group']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $group['Group']['id'])); ?> </li>
                        <li><?php echo $this->Html->link(__('List Groups', true), array('action' => 'index')); ?> </li>
                        <li><?php echo $this->Html->link(__('New Group', true), array('action' => 'add')); ?> </li>
                        <li><?php echo $this->Html->link(__('New Teacher', true), array('controller' => 'teachers', 'action' => 'add')); ?> </li>
                        <li><?php echo $this->Html->link(__('New Student', true), array('controller' => 'students', 'action' => 'add')); ?> </li>
                    </ul>
            </div>
        </div>
        
        <div id="dropdown1" class="tab-pane fade">
            <h3>Dropdown 1</h3>
            <p>WInteger convallis, nulla in sollicitudin placerat, ligula enim auctor lectus, in mollis diam dolor at lorem. Sed bibendum nibh sit amet dictum feugiat. Vivamus arcu sem, cursus a feugiat ut, iaculis at erat. Donec vehicula at ligula vitae venenatis. Sed nunc nulla, vehicula non porttitor in, pharetra et dolor. Fusce nec velit velit. Pellentesque consectetur eros.</p>
        </div>
        <div id="dropdown2" class="tab-pane fade">
            <h3>Dropdown 2</h3>
            <p>Donec vel placerat quam, ut euismod risus. Sed a mi suscipit, elementum sem a, hendrerit velit. Donec at erat magna. Sed dignissim orci nec eleifend egestas. Donec eget mi consequat massa vestibulum laoreet. Mauris et ultrices nulla, malesuada volutpat ante. Fusce ut orci lorem. Donec molestie libero in tempus imperdiet. Cum sociis natoque penatibus et magnis dis parturient.</p>
        </div>
    </div>
    <hr>
</div>