
 <div class="data" style="display: none;">
     <font color="red">  Sorry u have permission for creating 3 Slide maker only..</font>
</div>
        
<?php

echo $javascript->link(array('jquery-ui-1.8.24.custom.min','jquery.popupoverlay'));

echo $html->css(array('jquery-ui-1.8.24.custom'));
?>
<?php
echo $javascript->link('jquery.colorbox-min');
echo $html->css('colorbox');
?>
<script type="text/javascript">
    
 function openColorBox() {
        $.colorbox({inline:true, width:"50%", open:true, href:".data",overlayClose: false,
            onClosed: function() {
                 $('.data').hide();
                   window.history.back()
            },
            onOpen: function() {
                 $('.data').show();
               //  $('#cboxClose').remove();
            }
           }); 
      }
      setTimeout(openColorBox, 250);    
               

</script>
