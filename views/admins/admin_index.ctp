<?php
$title = __('Administrators', true);
?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h2><span><?php echo $title; ?></span></h2>
<div class="msghead">
    <ul class="msghead-menu">
        <li>
            <a class="btn" href="<?php echo Router::url(array('action' => 'add')) ?>"> 
                <?php __('Add Manager') ?>
                <i class="icon-plus"></i>
            </a>
        </li>
    </ul>
    <span class="clearall"></span> 
</div>


<hr />
<div class="module-table-body">
    <form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
        <table cellpadding="0" cellspacing="0" class="table table-bordered messages-list  mailinbox">
            <thead>
                <tr>
                    <th><?php echo $paginator->sort('id'); ?></th>
                    <th><?php echo $paginator->sort('username'); ?></th>
                    <th class="actions"><?php __('Actions'); ?></th>
                </tr>
            </thead>
            <?php
            $i = 0;
            foreach ($admins as $admin):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td>
                        <?php echo $admin['Admin']['id']; ?>
                    </td>
                    <td>
                        <?php echo $admin['Admin']['username']; ?>
                    </td>
                    <td class="actions">
                        <?php
                        echo $html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $admin['Admin']['id']), array('escape' => false, 'class' => 'btn btn-small'));
                        echo $html->link('<i class="icon-trash"></i>', array('action' => 'delete', $admin['Admin']['id']), array('escape' => false, 'class' => 'btn btn-small'), sprintf(__('Are you sure you want to delete # %s?', true), $admin['Admin']['id']));
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>


        <div class="pagination">
            <?php
            if ($paginator->numbers()) {

                if ($paginator->hasNext()) {
                    ?> 

                    <div class="button"><span> 

                            <?php echo $paginator->next(__('next', true), array(), null, array('class' => 'disabled')); ?>
                            <img height="9" width="12" alt="Previous" src="<?php echo Router::url("/img/admin/arrow-180-small.gif") ?>">


                        </span>
                    </div>
                <?php } ?>            <div class="numbers"> 
                <?php echo $paginator->numbers(array('separator' => ' | ')); ?>
                </div>

                <?php if ($paginator->hasPrev()) { ?>            <div class="button" >
                        <span>
                            <img height="9" width="12" alt="Next"  src="<?php echo Router::url("/img/admin/arrow-000-small.gif") ?>" />
                            <?php echo $paginator->prev(__('previous', true), array(), null, array('class' => 'disabled')); ?>


                        </span>
                    </div>
                <?php } ?>            		<?php } ?>        </div>


    </form>
    <script type="text/javascript">
        $("#check_all").live('click',function(){
            if($(this).attr('checked')==true)
            {
                $("input[name=chk[]]").attr('checked',true);
            }else{
                $("input[name=chk[]]").attr('checked',false);
            }
	
        });
        $(document).ready(function(){
            $("#acts").change(function(){
                action=$(this).val();
                if(action!="")
                {
                    if($("input['name=chk[]']:checked").length==0)
                    {
                        alert("<?php echo __('js_one_element_alert'); ?>");
                        $(this).val('');
                    }else{
			
                        del=confirm("<?php echo __('js_operation_confirm'); ?>");
                        if(del)
                        {
                            $('#forn').submit();
                            $(this).val('');
                        }else{
                            $(this).val('');
                        }
                    }
	
                }
            });
        });
    </script>
</div>