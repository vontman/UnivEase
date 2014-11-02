<div class="group_info">
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