
<!--page header -->
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
          <li class="active"><?php echo __('Class Category', true) ?></li>
    </ul>
</div>
<h1><?php echo __('Class Category', true) ?></h1>
		<!------------->	
    
                <ul>

                    
                    <a class="btn" href="<?php echo Router::url(array('controller' => 'weeklyschedule_categories', 'action' => 'index')) ?>"> 
                <?php __('List Weeklyschedule Categories') ?>
                        <i class="icon-plus"></i>
                    </a>
                    
                    <a class="btn" href="<?php echo Router::url(array('controller' => 'weeklyschedule_categories', 'action' => 'add')) ?>"> 
                <?php __('Add weekly schedule') ?>
                        <i class="icon-plus"></i>
                    </a>
                </ul>
      
<hr />          
			
	<!------------->	

<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
    <!--   <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                 <th><input type="checkbox" id="check_all" /></th>
                 <th><?php echo $paginator->sort('id'); ?></th>
                 <th><?php echo $paginator->sort(__('name')); ?></th>
                 <th class="actions"><?php __('Actions'); ?></th>
            </tr>
        </thead>
        
        <?php
        $i = 0;
              
        foreach ($schedule_categories as $schedules):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
      
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $schedules['ScheduleCategory']['id']; ?>" />
                </td>
                
                <td>
                    <?php echo $schedules['ScheduleCategory']['id']; ?>
                </td>
                
                <td>
                    <?php echo $schedules['ScheduleCategory']['name']; ?>                   
                </td>
                <td class="actions">
                    <?php echo $html->link('<i class="icon-search"></i>', 
                            array('controller' => 'schedules', 'action' => 'index',$schedules['ScheduleCategory']['id']), array('class' => 'btn btn-small','escape'=>false)); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table> -->
</form>

<script type="text/javascript">
    $("#check_all").live('click', function() {
        if ($(this).prop('checked') == true)
        {
            $('input[name="chk[]"]').prop('checked', true);
        } else {
            $('input[name="chk[]"]').prop('checked', false);
        }

    });
    $(document).ready(function() {
        $("#acts").change(function() {
            action = $(this).val();
            if (action != "")
            {
                if ($('input[name="chk[]"]:checked').length == 0)
                {
                    alert("<?php echo __('You must choose on element at least'); ?>");
                    $(this).val('');
                } else {

                    del = confirm("<?php echo __('Are you sure you want to perform this process?'); ?>");
                    if (del)
                    {
                        $('#forn').submit();
                        $(this).val('');
                    } else {
                        $(this).val('');
                    }
                }

            }
        });
    });
</script>