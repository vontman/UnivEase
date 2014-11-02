<?php
    if (!empty($this->data['Group']['id'])) {

      $title = 'Edit Group';
    } else {

        $title = 'Add Group';
    }
?>

<div class="breadcrumbwidget">
  <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'groups','action' => 'index')) ?>"> <?php echo __('Groups') ?></a></li>
         <span class="divider"> / </span>
        <li class="active"><?php echo (__($title,true)) ?></li>
    </ul>
</div>

<h2>
    <span>
        <?php echo (__($title,true)); ?>
	</span>
</h2>

<?php echo $form->create('Group', array('type' => 'file')); ?>
<div class="module-body">
    <?php
    echo $form->input('id');
    echo $form->input('name');
    echo '<h3>' . __('Permissions', true) . '</h3>';
    echo $form->input('permissions', array('options' => $permissions, 'multiple' => 'checkbox', 'div' => array('class' => 'input checkgroup'), 'label' => false));
    ?>
    <div class="form-actions">
        <?php
        echo $form->submit('Submit', array('class' => 'btn btn-primary'));
        ?>
    </div>
    <?php echo $form->end(); ?>

</div>