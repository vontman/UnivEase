<!-- For print -->
<style>
    @media print {
    .print {
        background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
    }
}
    
</style>
<script>
function printdiv(el)
{
var restorepage=document.body.innerHTML;
var printcontent=document.getElementById(el).innerHTML;
document.body.innerHTML=printcontent;
window.print();
document.body.innerHTML=restorepage;

}
</script>


<!-- End print -->
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Users', true) ?></li>
    </ul>
</div>
<h1><?php echo __('Users', true) ?></h1>
<div class="msghead">
    <ul class="msghead-menu">
        <li>
            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
             <a class="btn" style="height: 21px;" href="<?php echo Router::url(array('controller' => 'users', 'action' => 'add')) ?>"> 
                <?php __('Add user') ?>
                <i class="icon-plus"></i>
            </a>
            
			<a style="height: 21px;" class="btn" href="<?php echo Router::url(array('controller' => 'users', 'action' => 'import')) ?>"> 
                <?php __('Import users') ?>
                <i class="symp-link"></i>
            </a>
        </li>
        <li>
            <form NAME ="form1" style="height: 11px; margin-right: 4px;" method="gett" action="<?php echo Router::url(array("action" => "find")) ?>">
                <input type = "number" value="1" min="1" name="txtuserid" style="width: 50px">
                <a class="btn">
                    <input type = "Submit" value = "<?php __('Search') ?>" style="border: 0px;font-size: 12px;font-weight: bold;font-family: Tahoma, Geneva, sans-serif;"> 
                    <li class="icon-search"></li>
                </a>
            </form>     
		</li>
                 <li>
            <form >
                
                <a class="btn">
                    <input onclick="printdiv('print');" type = "Submit" value = "<?php __('Print Users Detail') ?>" style="border: 0px;font-size: 12px;font-weight: bold;font-family: Tahoma, Geneva, sans-serif;"> 
                    <li class="icon-book"></li>
                </a>
            </form>     
		</li>
               
    </ul>
    <span class="clearall"></span> 
</div>
<hr />

<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort('name'); ?></th>
                <th class="actions"><?php __('Actions'); ?></th>

            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($users as $users):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $users['User']['id']; ?>" />
                </td>
                <td>
                    <?php echo $users['User']['id']; ?>
                </td>
                <td>
                    <?php echo $users['User']['name']; ?>
                </td>

                <td class="actions">
                    <?php echo $html->link('<i class="icon-pencil"></i>', 
                            array('action' => 'edit', $users['User']['id']),
                            array('class' => 'btn btn-small','escape'=>false)); ?>
                    <?php echo $html->link('<i class="icon-envelope"></i>',
                            array('controller'=>'messages','action' => 'send', $users['User']['id']), array('class' => 'btn btn-small','escape'=>false)); ?>
                    <?php echo $html->link('<i class="icon-trash"></i>',
                            array('action' => 'delete', $users['User']['id']), array('class' => 'btn btn-small','escape'=>false), sprintf(__('Are you sure you want to delete # %s?', true), $users['User']['id'])); ?>
                    <?php if(!$users['User']['approved']){
                        echo $html->link('<i class="icon-check"></i>',
                                array('action' => 'confirm', $users['User']['id']), 
                                array('class' => 'btn btn-small','escape'=>false));
                        ?>
                    
                    <?php }?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>


    <div class="pagination">
        <ul>
            <?php
            if ($paginator->numbers()) {

                if ($paginator->hasNext()) {
                    ?> 
                    <?php echo $paginator->next(__('Next', true), array('tag' => 'li'), null, array('class' => 'disabled')); ?>
                <?php } ?> 


                <?php echo $paginator->numbers(array('tag' => 'li', 'separator' => '')); ?>


                <?php if ($paginator->hasPrev()) { ?>

                    <?php echo $paginator->prev(__('Previous', true), array('tag' => 'li'), null, array('class' => 'disabled')); ?>

                <?php } ?>            		
            <?php } ?> 
        </ul>
    </div>

    <div class="table-apply">
        <div>
            <span><?php echo __("Choose Operation") ?></span> 
            <select class="input-medium" id="acts" name="operation" style="width:auto;">
                <option value="">
                    <?php echo __("Choose Operation") ?></option>
                <option value="delete"><?php echo __("Delete") ?></option>
                <option value="message"><?php echo __("Send Message") ?></option>
                <option value="sms"><?php echo __("Send SMS") ?></option>
            </select>
        </div>

    </div>
</form>



<!-- start print-->
<div id="print" style="display: none;">
    
<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><?php  __('id'); ?></th>
                <th><?php __('name'); ?></th>
                <th><?php __('Email'); ?></th>
                <th><?php __('Mobile'); ?></th>

            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($userss as $users):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
               
                <td>
                    <?php echo $users['User']['id']; ?>
                </td>
                <td>
                    <?php echo $users['User']['name']; ?>
                </td>
                <td>
                    <?php echo $users['User']['email']; ?>
                </td>
                <td>
                    <?php echo $users['User']['mobile']; ?>
                </td>

                
            </tr>
        <?php endforeach; ?>
    </table>




</form>
</div>


<!-- End print-->
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



