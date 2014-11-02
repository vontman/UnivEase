
<!--page header -->
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'schedule_categories', 'action' => 'index')) ?>"><?php __('Class Category') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Class Level', true) ?></li>
    </ul>
</div>
<h1><?php echo __('Class Level', true) ?></h1>

<div class="msghead">
    <ul class="msghead-menu">
        <li>
             <a class="btn" href="<?php echo Router::url(array('controller' => 'schedules', 'action' => 'add',$id)) ?>"> 
                <?php __('Add Class Level') ?>
                <i class="icon-plus"></i>
            </a>
        </li>
        
    </ul>
    <span class="clearall"></span> 
</div>
<hr />
    
<form action="<?php echo Router::url(array("action" => "do_operation",$id)) ?>" id="forn" method="post">
       <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                 <th><input type="checkbox" id="check_all" /></th>
                 <th><?php echo $paginator->sort(__('id')); ?></th>
                 <th><?php echo $paginator->sort(__('name')); ?></th>
                 <th class="actions"><?php __('Actions'); ?></th>

            </tr>
        </thead>
        
        <?php
        $i = 0;
              
        foreach ($schedules as $schedules):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
      
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $schedules['Schedule']['id']; ?>" />
                </td>
                
                <td>
                    <?php echo $schedules['Schedule']['id']; ?>
                </td>
                
                <td>
                    <?php echo $schedules['Schedule']['name']; ?>                   
                </td>
                    
               
            <td class="actions">
                    <?php  echo $html->link('<i class="icon-pencil"></i>', 
                            array('action' => 'edit', $id, $schedules['Schedule']['id']), array('class' => 'btn btn-small','escape'=>false)); ?>
                                       
                    <?php echo $html->link('<i class="icon-search"></i>', 
                            array('controller' => 'schedule_details', 'action' => 'index',$schedules['Schedule']['id']), array('class' => 'btn btn-small','escape'=>false)); ?>
                
                   <?php echo $html->link('<i class="icon-trash"></i>', 
                            array('action' => 'delete', $id, $schedules['Schedule']['id']), array('class' => 'btn btn-small','escape'=>false), 
                            sprintf(__('Are you sure you want to delete # %s?', true), $schedules['Schedule']['id'])); ?>
                  
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <div class="table-apply">
        <div>
            <span><?php echo __("Choose Operation") ?></span> 
            <select class="input-medium" id="acts" name="operation" style="width:auto;">
                <option value="">
                    <?php echo __("Choose Operation") ?></option>
                <option value="delete"><?php echo __("Delete") ?></option>
            </select>
        </div>

    </div>
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