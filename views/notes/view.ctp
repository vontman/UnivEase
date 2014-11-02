<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'notes','action'=>'index',$note['User']['id'],'?' => array('crs_id' => $note['Note']['course_id']))) ?>"><?php __('Notes') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('View note', true) ?></li>
    </ul>
</div>
<h1><?php __('Notes'); ?></h1>

<div id="mail">
    
    <hr />

    <h3><?php echo $note['Note']['subject']; ?></h3>
    
    <blockquote>
        <p><?php echo $note['Note']['body']; ?></p>
    </blockquote>
    <hr />
    <div id="rep_body" style="display: none">
        <h3><?php __('Add reply') ?></h3>
    <?php echo $form->create('Note', array('type' => 'file', 'url' => array('action' => 'reply', $note['Note']['id']))); ?>
    <?php
    echo $form->input('id');
    $subject = strstr($note['Note']['subject'], __('Re:', true)) ? $note['Note']['subject'] : __('Re:', true) . ' ' . $note['Note']['subject'];
    echo $form->input('subject', array('value' => $subject, 'class' => 'span6'));
    echo $form->input('body', array('class' => 'span6'));
    ?>
    <div class="form-actions">
        <?php echo $form->submit('Reply', array('class' => 'btn btn-primary')) ?>
    </div>
</form>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
          $(location).attr('href');
        var x = $(location).attr('hash');
        if(x == '#reply')
            { 
                $('#rep_body').show("fast");
            }
        var oEditor = CKEDITOR.instances.NoteBody;
        var data='<p></p><br/><hr />'+'<?php echo $javascript->escapeString($note['Note']['body']); ?>';
        //var valuesss = "<?php echo $javascript->escapeString($note['Note']['body']); ?>";
        oEditor.setData(data);
        return false;
         
    });
	
    $("#reply_btn").live('click', function() 
         {
                  $('#rep_body').slideDown("slow");
         });
		 
</script>