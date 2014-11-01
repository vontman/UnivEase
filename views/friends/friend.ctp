<style>
    .search-input{
        width:20px;
        height: 20px;
    }
    .select{
        width:80%;
        float: right;
    }
</style>
 <?php 
  echo $form->create('Friend', array('type' => 'file','action'=>'request')); 
 
echo $form->input('id', array('label' =>'','type' => 'select', 'data-placeholder' => __("Choose a course", true), 'style' => "width:415px;", 'class' => "chzn-select chzn-rtl"));
 ?>
 
<div class="form-actions">
    <span class="glyphicon glyphicon-search"></span>
    <?php
    echo $form->submit('Submit', array('class' => 'search-input search btn btn-primary'));
    ?>
</div>
<?php echo $form->end(); ?>
<ul class="list-group">
    <?php foreach($friends as $friend){?>
  <li style='margin-top:32px;' class="list-group-item">
      <a href="<?php echo Router::url(array('controller' => 'users','action'=>'profile',$friend['User']['id'])) ?>"><?php echo $friend['User']['name']?></a>
      <br class="clear">
      <div class="action-group" style="float: right;margin-top: -25px;">
      <a  class="btn btn-danger" href="<?php echo Router::url(array('controller' => 'friends','action'=>'unfriend',$friend['Friend']['id'])) ?>">Un friend</a>
      
      </div>
      <br class="clear">
      </li>
    <?php } ?>

</ul>
<?php
echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'chosen.jquery'));
echo $html->css(array('jquery-ui-1.8.24.custom', 'chosen'));
?>
<script type="text/javascript">
   $(document).ready(function(){
       get_users();
   })
    function get_users()
    {
        
      
        $.ajax({
            async: true,
            type: "GET",
            url: "<?php echo Router::url(array('controller' => 'friends', 'action' => 'getFriends', 'admin' => false)) ?>",
            dataType: "json",
            
            success: function(data) {
                
                $('#FriendId').html('');
                if (data.submenus.length != 0) {
                    for (var i = 0; i < data.submenus.length; i++)
                    {
                        var submenu = data.submenus[i];
                        var is_Selected = "";
                        selected_submenu = [<?php !empty($this->data['User']['id']) ? print(implode(',', $this->data['User']['id']))  : ''; ?>];
                        if (selected_submenu.indexOf(parseInt(submenu.User.id)) != -1)
                        {
                            is_Selected = "selected=selected";
                        }
                        $('#FriendId').append('<option value="' + submenu.User.id + '"' + is_Selected + '>' + submenu.User.name + '</option>');
                    }
                    document.getElementById('FriendId').disabled = false;

                    //                    $('#FriendId').chosen({no_results_text: "<?php __("No results matched") ?>",width:'415px;'});
                    $("#FriendId").trigger("liszt:updated");

                } else {
                    document.getElementById('FriendId').disabled = false;
                    //                    $('#FriendId').chosen({no_results_text: "<?php __("No results matched") ?>"});
                    $("#FriendId").trigger("liszt:updated");

                }

                return false;
            }

        });
    }  
     
    $('#FriendId').chosen({no_results_text: "<?php __("No results matched") ?>", width: '415px'});
    
    </script>
    
    