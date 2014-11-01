<?php $title = __('Send message', true); ?>

<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1><?php echo $title; ?></h1>


<?php echo $form->create('Message', array('type' => 'file', "url" => array("action" => "sendall", $receiver_id))); ?>

<?php
echo $form->input('id', array('type' => 'hidden'));
echo $form->input('receiver_id', array('type' => 'hidden'));
echo $form->input('subject', array('class' => 'span6'));
echo $fck->load('Message', 'body', '', true, array("type" => "textarea"));
?>
<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>
<?php echo $form->end(); ?>

