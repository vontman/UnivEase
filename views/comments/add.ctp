<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $cuser['Course']['id'])) ?>"> <?php echo $cuser['Course']['name'] ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'posts', 'action' => 'index', $comment['Post']['course_id'], '?' => array('level' => $comment['Post']['level']))) ?>"><?php echo __('Posts', true) ?></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'posts', 'action' => 'view', $comment['Post']['id'], $comment['Post']['permalink'])) ?>"> <?php echo $comment['Post']['title'] ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'comments', 'action' => 'index', $comment['Post']['id'], $comment['Post']['permalink'])) ?>"> <?php echo __('Comments', true); ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php __('Edit Comment') ?></li>
    </ul>
</div>

<h1>
    <?php
    if (!empty($this->data['Comment']['id'])) {

        __('Edit Comment');
    } else {

        __('Add Comment');
    }
    ?>

</h1>
<hr />
<?php echo $form->create('Comment', array('type' => 'file')); ?>

<?php
echo $form->input('id');
echo $form->input('content', array('class' => 'span6'));
echo $form->input('approved', array('label' => false, 'after' => '</div>', 'before' => '<label>' . __('Approved', true) . '</label><div class="switch" data-on-label="<i class=\'icon-ok icon-white\'></i>" data-off-label="<i class=\'icon-remove\'></i>">'));
?>
<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>
<?php echo $form->end(); ?>

