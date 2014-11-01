
<hr />
<div class="data">
    
<?php

    echo $session->flash();

$url = array("controller" => "users", "action" => "check_password");
echo $form->create('User', array('type' => 'file', 'url' => $url)); ?>

<?php

echo $form->input('username', array('type'=>'hidden','value'=>$username));
echo $form->input('password', array('div' => array('label'=>'Enter Student password','class' => 'control-group')));
?>
<div class="form-actions">
    <?php echo $form->submit('Submit', array('class' => 'btn btn-primary')); ?>
</div>
<?php echo $form->end(); ?>
</div>
<?php

echo $javascript->link(array('jquery-ui-1.8.24.custom.min','jquery.popupoverlay'));

echo $html->css(array('jquery-ui-1.8.24.custom'));
?>
<?php
echo $javascript->link('jquery.colorbox-min');
echo $html->css('colorbox');
?><script type="text/javascript">
    
 function openColorBox() {
        $.colorbox({inline:true, width:"50%", open:false, href:".data",overlayClose: false,
            onClosed: function() {
                 $('.data').hide();
                   window.history.back()
            },
            onOpen: function() {
             $('.data').show();
              
       
            }
           }); 
      }
      setTimeout(openColorBox, 10);    
               

</script>
