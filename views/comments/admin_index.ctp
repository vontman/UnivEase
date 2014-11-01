<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $ccourse['Course']['id'])) ?>"> <?php echo $ccourse['Course']['name'] ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'posts', 'action' => 'index', $post['Post']['course_id'], '?' => array('level' => $post['Post']['level']))) ?>"><?php echo __('Posts', true) ?></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], $post['Post']['permalink'])) ?>"> <?php echo $post['Post']['title'] ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php __('Comments') ?></li>
    </ul>
</div>
<h1><?php __('Comments'); ?></h1>
<hr />
<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort(__('Username', true), 'User.name'); ?></th>
                <th class="actions"><?php __('Actions'); ?></th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($comments as $comment):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $comment['Comment']['id']; ?>" />
                </td>
                <td>
                    <?php echo $comment['Comment']['id']; ?>
                </td>
                <td>
                    <?php echo $comment['User']['name']; ?>
                </td>
                <td class="actions">
                    <?php echo $html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $comment['Comment']['id']), array('class' => 'btn btn-small', 'escape' => false)); ?>
                    <?php
                    echo $html->link('<i class="icon-trash"></i>', array('action' => 'delete', $comment['Comment']['id']), array('class' => 'btn btn-small', 'escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $comment['Comment']['id']));
                    if (!$comment['Comment']['approved']) {
                        echo ' '.$html->link('<i class="icon-cog"></i> ' . __('Approve', true), array('action' => 'approve', $comment['Comment']['id']), array('class' => 'btn btn-small', 'escape' => false));
                    }
                    ?>
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
            </select>
        </div>

    </div>

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
</div>


