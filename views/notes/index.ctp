<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Notes', true) ?></li>
    </ul>
</div>
<h1><?php __('Notes'); ?></h1>
<h2><?php echo  $username;?></h2>
<?php if (isset($cuser['Group']['allowed_permissions'][8])) { ?>
<!--    <div class="msghead">
        <ul class="msghead-menu">
            <li>
                <a class="btn" href="<?php echo Router::url(array('controller' => 'messages', 'action' => 'send')) ?>"><?php __('Compose message') ?></a>
            </li>
        </ul>
        <span class="clearall"></span> 
    </div>-->
<?php } ?>
<hr />
<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forns" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><input type="checkbox" id="inboxcheck_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort('subject'); ?></th>
                <th class="actions"><?php __('Actions'); ?></th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($notes as $note):
//            debug($note);
            $class = null;
           
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $note['Note']['id']; ?>" />
                </td>
                <td>
                    <?php echo $note['Note']['id']; ?>
                </td>
                <td>
                    <?php echo $note['Note']['subject']; ?>
                </td>
              
                <td class="actions">
                    <?php echo $html->link('<i class="icon-search"></i>', array('action' => 'view', $note['Note']['id']), array('class' => 'btn btn-small', 'escape' => false)); ?>
                     
    <?php echo $html->link('<i class="icon-trash"></i>', array('action' => 'delete', $note['Note']['id']), array('class' => 'btn btn-small', 'escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $note['Note']['id'])); ?>
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
            <select class="input-medium" id="actss" name="operation" style="width:auto;">
                <option value="">
<?php echo __("Choose Operation") ?></option>
                <option value="delete"><?php echo __("Delete") ?></option>
            </select>
        </div>

    </div>
</form>
<script type="text/javascript">
    $("#inboxcheck_all").live('click', function() {
        if ($(this).prop('checked') == true)
        {
            $(this).parents('form').find('input[name="chk[]"]').prop('checked', true);
        } else {
            $(this).parents('form').find('input[name="chk[]"]').prop('checked', false);
        }

    });
    $(document).ready(function() {
        $("#actss").change(function() {
            action = $(this).val();
            if (action != "")
            {
                if ($(this).parents('form').find('input[name="chk[]"]:checked').length == 0)
                {
                    alert("<?php echo __('You must choose on element at least'); ?>");
                    $(this).val('');
                } else {

                    del = confirm("<?php echo __('Are you sure you want to perform this process?'); ?>");
                    if (del)
                    {
                        $('#forns').submit();
                        $(this).val('');
                    } else {
                        $(this).val('');
                    }
                }

            }
        });
    });
</script>
</div>








