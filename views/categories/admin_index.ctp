<h2><span><?php __('Categories'); ?></span></h2>
<div class="module-table-body">
    <form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th><input type="checkbox" id="check_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort('title'); ?></th>
                <th class="actions"><?php __('Actions'); ?></th>
            </tr>
            <?php
            $i = 0;
            foreach ($categories as $category):
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td >
                        <input  type="checkbox" name="chk[]" value="<?php echo $category['Category']['id']; ?>" /></td>
                    <td>
                        <?php echo $category['Category']['id']; ?>
                    </td>
                    <td>
                        <?php echo $category['Category']['name']; ?>
                    </td>

                    <td class="actions">
                        <?php echo $html->link(__('Edit', true), array('action' => 'edit', $category['Category']['id']), array('class' => 'Edit')); ?>
                        <?php echo $html->link(__('Delete', true), array('action' => 'delete', $category['Category']['id']), array('class' => 'Delete'), sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id'])); ?>
                        <?php // echo $html->link(__('Products', true), array('controller' => 'products', 'action' => 'index', $category['Category']['id']), array('class' => 'Products')); ?>
                    </td>
                </tr>
                <?php
            endforeach;
            ?>
        </table>


        <div class="pagination">
            <?php
            if ($paginator->numbers()) {

                if ($paginator->hasNext()) {
                    ?> 

                    <div class="button"><span> 

                            <?php echo $paginator->next(__('Next', true), array(), null, array('class' => 'disabled')); ?>
                            <img height="9" width="12" alt="Previous" src="<?php echo Router::url("/img/admin/arrow-180-small.gif") ?>">


                        </span>
                    </div>
                <?php } ?>            <div class="numbers"> 
                <?php echo $paginator->numbers(array('separator' => ' | ')); ?>
                </div>

                <?php if ($paginator->hasPrev()) { ?> 
                    <div class="button" >
                        <span>
                            <img height="9" width="12" alt="Next"  src="<?php echo Router::url("/img/admin/arrow-000-small.gif") ?>" />
                            <?php echo $paginator->prev(__('Previous', true), array(), null, array('class' => 'disabled')); ?>


                        </span>
                    </div>
                <?php } ?>
            <?php } ?>        
        </div>

        <div class="table-apply">
            <div>
                <span><?php echo __("choose_operation_label") ?></span> 
                <select class="input-medium" id="acts" name="operation" style="width:auto;">
                    <option value="">
                        <?php echo __("choose_operation") ?></option>
                    <option value="delete"><?php echo __("Delete") ?></option>
                </select>
            </div>

        </div>
    </form>
    <script type="text/javascript">
        $("#check_all").live('click',function(){
            if($(this).prop('checked')==true)
            {
                $('input[name="chk[]"]').attr('checked',true);
            }else{
                $('input[name="chk[]"]').attr('checked',false);
            }
	
        });
        $(document).ready(function(){
            $("#acts").change(function(){
                action=$(this).val();
                if(action!="")
                {
                    if($('input[name="chk[]"]:checked').length==0)
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