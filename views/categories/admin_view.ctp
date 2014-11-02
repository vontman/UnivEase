<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Categories', true) ?></li>
    </ul>
</div>

<?php $this->set('h1', __('Categories', true)); ?>
<div class="msghead">
    <ul class="msghead-menu">
        <li>

            <a class="btn" href="<?php echo Router::url(array('controller' => 'categories', 'action' => 'add', $category['Category']['id'])) ?>"> 
                <?php __('Add SubCategory') ?>
                <i class="icon-plus"></i>
            </a>
        </li>

        <li>
            <a class="btn" href="<?php echo Router::url(array('controller' => 'categories', 'action' => 'edit', $category['Category']['id'])) ?>"> 
                <?php __('Edit Category') ?> 
                <i class="icon-pencil"></i>
            </a>
        </li>
        <?php
//        debug($category['Category']);
        if (!$category['Category']['has_childs'] && !$category['Category']['courses']) {
            ?>
			<li>
                <!--<button class="btn"><span class="iconsweets-alert2"></span> Ø§Ù„Ø§Ø¨Ù„Ø§Øº Ø¹Ù† Ø§Ù„Ø§Ø³Ø§Ø¡Ø©</button>-->
                 <?php echo $html->link( __("Delete Category",true). '  <i class="icon-trash"></i> ', 
                                        array('action' => 'delete', $category['Category']['id']), array('class' => 'btn','escape'=>false), 
                                        sprintf(__('Are you sure you want to delete # %s?', true),  $category['Category']['id'])) ?>
            </li>
        <?php } ?>


    </ul>
    <span class="clearall"></span> 
</div>
<hr />
<form action="<?php echo Router::url(array('controller' => 'categories', "action" => "do_operation")) ?>" id="forn" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><input type="checkbox" id="check_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort(__('Category name', true), 'name'); ?></th>

                <th class="actions"><?php __('Actions'); ?></th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($categories as $category):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $category['Category']['id']; ?>" />
                </td>
                <td>
                    <?php echo $category['Category']['id']; ?>
                </td>
                <td>
                    <?php echo $category['Category']['name']; ?>
                </td>

                <td class="actions">
                    <?php echo $html->link('<i class="icon-search"></i>', array('controller' => 'categories', 'action' => 'view', $category['Category']['id']), array('class' => 'btn btn-small', 'escape' => false,)); ?>
                    <?php echo $html->link('<i class="icon-pencil"></i>', array('controller' => 'categories', 'action' => 'edit', $category['Category']['id']), array('class' => 'btn btn-small', 'escape' => false,)); ?>
                    <?php
                    if (!$category['Category']['has_childs'] && !$category['Category']['courses']) {
                        echo $html->link('<i class="icon-trash"></i>', array('controller' => 'categories', 'action' => 'delete', $category['Category']['id']), array('class' => 'btn btn-small', 'escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $category['Category']['id']));
                    }
//                <?php
////                    if (!empty($category['ChildAssignment'])) {
////                        echo $html->link('<i class="icon-cog"></i> '. __('Delivers', true), array('action' => 'view_delivers', $category['Category']['id']), array('class' => 'btn btn-small','escape'=>false));
////                    }
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
</form>
<script type="text/javascript">
    $("#check_all").live('click',function(){
        if($(this).prop('checked')==true)
        {
            $(this).parents('form').find('input[name="chk[]"]').prop('checked',true);
        }else{
            $(this).parents('form').find('input[name="chk[]"]').prop('checked',false);
        }
	
    });
    $(document).ready(function(){
        $("#acts").change(function(){
            action=$(this).val();
            if(action!="")
            {
                if($('input[name="chk[]"]:checked').length==0)
                {
                    alert("<?php echo __('You must choose on element at least'); ?>");
                    $(this).val('');
                }else{
			
                    del=confirm("<?php echo __('Are you sure you want to perform this process?'); ?>");
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
<div class="clearall"></div>
<h1><?php __('Courses'); ?></h1>
<div class="msghead">
    <ul class="msghead-menu">
        <li>
            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'add', $category['Category']['id'])) ?>"> 
                <?php __('Add Course') ?>
                <i class="icon-plus"></i>
            </a>
        </li>
    </ul>
    <span class="clearall"></span> 
</div>
<hr />
<form action="<?php echo Router::url(array('controller' => 'courses', "action" => "do_operation")) ?>" id="forns" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><input type="checkbox" id="inboxcheck_all" /></th>
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort(__('Course name', true), 'name'); ?></th>
                <th class="actions"><?php __('Actions'); ?></th>
            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($courses as $course):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
                <td>
                    <input  type="checkbox" name="chk[]" value="<?php echo $course['Course']['id']; ?>" />
                </td>
                <td>
                    <?php echo $course['Course']['id']; ?>
                </td>
                <td>
                    <?php echo $course['Course']['name']; ?>
                </td>

                <td class="actions">
                    <?php echo $html->link('<i class="icon-search"></i>', array('controller' => 'courses', 'action' => 'view', $course['Course']['id']), array('class' => 'btn btn-small', 'escape' => false,)); ?>
                    <?php echo $html->link('<i class="icon-pencil"></i>', array('controller' => 'courses', 'action' => 'edit', $course['Course']['id']), array('class' => 'btn btn-small', 'escape' => false,)); ?>
                    <?php echo $html->link('<i class="icon-search"></i> ' . __('Enrolled users', true), array('controller' => 'course_users', 'action' => 'index', $course['Course']['id']), array('class' => 'btn btn-small', 'escape' => false)); ?>
                    <?php echo $html->link('<i class="icon-cog"></i> ' . __('Sections', true), array('controller' => 'sections', 'action' => 'index', $course['Course']['id']), array('class' => 'btn btn-small', 'escape' => false)); ?>
                    <?php echo $html->link('<i class="icon-trash"></i>', array('controller' => 'courses', 'action' => 'delete', $course['Course']['id']), array('class' => 'btn btn-small', 'escape' => false), sprintf(__('Are you sure you want to delete # %s?', true), $course['Course']['id'])); ?>
                    <?php
//                    if (!empty($category['ChildAssignment'])) {
//                        echo $html->link('<i class="icon-cog"></i> '. __('Delivers', true), array('action' => 'view_delivers', $category['Category']['id']), array('class' => 'btn btn-small','escape'=>false));
//                    }
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
            <select class="input-medium" id="actss" name="operation" style="width:auto;">
                <option value="">
                    <?php echo __("Choose Operation") ?></option>
                <option value="delete"><?php echo __("Delete") ?></option>
            </select>
        </div>

    </div>
</form>
<script type="text/javascript">
    $("#inboxcheck_all").live('click',function(){
        if($(this).prop('checked')==true)
        {
            $(this).parents('form').find('input[name="chk[]"]').prop('checked',true);
        }else{
            $(this).parents('form').find('input[name="chk[]"]').prop('checked',false);
        }
	
    });
    $(document).ready(function(){
        $("#actss").change(function(){
            action=$(this).val();
            if(action!="")
            {
                if($(this).parents('form').find('input[name="chk[]"]:checked').length==0)
                {
                    alert("<?php echo __('You must choose on element at least'); ?>");
                    $(this).val('');
                }else{
			
                    del=confirm("<?php echo __('Are you sure you want to perform this process?'); ?>");
                    if(del)
                    {
                        $('#forns').submit();
                        $(this).val('');
                    }else{
                        $(this).val('');
                    }
                }
	
            }
        });
    });
</script>