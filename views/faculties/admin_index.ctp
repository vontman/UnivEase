<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $ccourse['Course']['id'])) ?>"> <?php echo $ccourse['Course']['name'] ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Enrolled users', true) ?></li>
    </ul>
</div>
<h1><span><?php __('Enrolled users'); ?></span></h1>
<div class="msghead">
    <ul class="msghead-menu">
        <li>
            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'course_users', 'action' => 'add', $course_id)) ?>"> 
                <?php __('Enroll user') ?>
                <i class="icon-plus"></i>
            </a>
        </li>
         <li>
                <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
                <a class="btn" href="<?php echo Router::url(array('controller' => 'course_users', 'action' => 'add_all', $course_id)) ?>"> 
                    <?php __('Enroll all user') ?>
                    <i class="icon-plus"></i>
                </a>
            </li>
        <li>
            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'users', 'action' => 'export', $course_id)) ?>"> 
                <?php __('Export users') ?>
                <i class="icon-list-alt"></i>
            </a>
        </li>
    </ul>
    <span class="clearall"></span> 
</div>
<hr />
<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">

<?php 
echo"hena";
print_r($error);
if(isset($error) && !empty($error)){
    foreach ($error as $er) {
   echo $er."<br>";
}}?>
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort(__('name', true), 'User.name'); ?></th>
                <th><?php echo $paginator->sort(__('type', true)); ?></th>
                <th class="actions"><?php __('Actions'); ?></th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($courseUsers as $courseUser):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $courseUser['CourseUser']['id']; ?>" />
                </td>
                <td>
                    <?php echo $courseUser['CourseUser']['id']; ?>
                </td>
                <td>
                    <?php echo $courseUser['User']['name']; ?>
                </td>
                <td>
                    <?php echo $types[$courseUser['CourseUser']['user_type']]; ?>
                </td>
                <td class="actions">
                    <?php echo $html->link('<i class="icon-pencil"></i>', array('action' => 'edit', $courseUser['CourseUser']['id']), array('class' => 'btn btn-small', 'escape' => false)); ?>
                    <?php echo $html->link('<i class="icon-envelope"></i>', array('controller' => 'messages', 'action' => 'send', $courseUser['CourseUser']['user_id']), array('class' => 'btn btn-small', "title" => __("Send Message", true), 'escape' => false)); ?>
                    <?php echo $html->link('<i class="icon-comment"></i>', array('controller' => 'messages', 'action' => 'sendsms', $courseUser['CourseUser']['user_id']), array('class' => 'btn btn-small', "title" => __("Send SMS", true), 'escape' => false)); ?>
                    <?php echo $html->link('<i class="icon-trash"></i>', array('action' => 'delete', $courseUser['CourseUser']['id']), array('class' => 'btn btn-small', 'escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $courseUser['CourseUser']['id'])); ?>
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


