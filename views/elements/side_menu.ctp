
<?php
$admin_menu = array(
    __('Control panel', true) => array('url' => '/admin/',
        'subs' => array(
//            'Pages' => array('class' => 'closed',
//                'subs' => array(
//                    __('List Pages', true) => array('url' => array('controller' => 'pages', 'action' => 'index')),
//                    __('Add Page', true) => array('url' => array('controller' => 'pages', 'action' => 'add')),
//                )
//            ),
//            'Categories' => array('class' => 'closed',
//                'subs' => array(
//                    __('List Categories', true) => array('url' => array('controller' => 'categories', 'action' => 'index')),
//                    __('Add Category', true) => array('url' => array('controller' => 'categories', 'action' => 'add')),
//                )
//            ),
//            'Products' => array('class' => 'closed',
//                'subs' => array(
//                    __('List Products', true) => array('url' => array('controller' => 'products', 'action' => 'index')),
//                    __('Add Products', true) => array('url' => array('controller' => 'products', 'action' => 'add')),
//                )
//            ),
//            'Special product' => array('class' => 'closed',
//                'subs' => array(
//                    __('Edit Special product', true) => array('url' => array('controller' => 'special_products', 'action' => 'edit')),
//                )
//            ),
//            'Banners' => array('class' => 'closed',
//                'subs' => array(
//                    __('List Banners', true) => array('url' => array('controller' => 'banners', 'action' => 'index')),
//                    __('Add Banner', true) => array('url' => array('controller' => 'banners', 'action' => 'add')),
//                )
//            ),
//            'Contact us messages' => array('class' => 'closed', 'id' => 'Contacts',
//                'subs' => array(
//                    __('List Messages', true) => array('url' => array('controller' => 'contacts', 'action' => 'index'))
//                )
//            ),
//            'Snippets' => array('class' => 'closed',
//                'subs' => array(
//                    __('List Snippets', true) => array('url' => array('controller' => 'snippets', 'action' => 'index')),
//                    __('Add Snippet', true) => array('url' => array('controller' => 'snippets', 'action' => 'add')),
//                )
//            ),



            'User Groups' => array('class' => 'closed',
                'subs' => array(
                    __('List Groups', true) => array('url' => array('controller' => 'groups', 'action' => 'index')),
                    __('Add Group', true) => array('url' => array('controller' => 'groups', 'action' => 'add')),
                )
            ),
            'Users' => array('class' => 'closed',
                'subs' => array(
                    __('List Users', true) => array('url' => array('controller' => 'users', 'action' => 'index')),
                    __('Add User', true) => array('url' => array('controller' => 'users', 'action' => 'add')),
                )
            ),
            'Stages' => array('class' => 'closed',
                'subs' => array(
                    __('List Stages', true) => array('url' => array('controller' => 'stages', 'action' => 'index')),
                    __('Add Stage', true) => array('url' => array('controller' => 'stages', 'action' => 'add')),
                )
            ),
            'Levels' => array('class' => 'closed',
                'subs' => array(
                    __('List Levels', true) => array('url' => array('controller' => 'levels', 'action' => 'index')),
                    __('Add Level', true) => array('url' => array('controller' => 'levels', 'action' => 'add')),
                )
            ),
            'Classrooms' => array('class' => 'closed',
                'subs' => array(
                    __('List Classrooms', true) => array('url' => array('controller' => 'sections', 'action' => 'index')),
                    __('Add Classroom', true) => array('url' => array('controller' => 'sections', 'action' => 'add')),
                )
            ),
            'Courses' => array('class' => 'closed',
                'subs' => array(
                    __('List Courses', true) => array('url' => array('controller' => 'courses', 'action' => 'index')),
                    __('Add Courses', true) => array('url' => array('controller' => 'courses', 'action' => 'add')),
                )
            ),
            'Exams' => array('class' => 'closed',
                'subs' => array(
                    __('List Exams', true) => array('url' => array('controller' => 'exams', 'action' => 'index')),
                    __('Add Exam', true) => array('url' => array('controller' => 'exams', 'action' => 'add')),
                )
            ),
            'Student Exams' => array('class' => 'closed',
                'subs' => array(
                    __('List Exams', true) => array('url' => array('controller' => 'student_exams', 'action' => 'index')),
                    __('Add Exam', true) => array('url' => array('controller' => 'student_exams', 'action' => 'add')),
                )
            ),
            'Configurations' => array('class' => 'closed',
                'subs' => array(
                    __('Edit Configurations', true) => array('url' => array('controller' => 'configurations', 'action' => 'edit')),
                )
            ),
            'Admins' => array('class' => 'closed',
                'subs' => array(
                    __('List Admins', true) => array('url' => array('controller' => 'admins', 'action' => 'index')),
                    __('Add Admin', true) => array('url' => array('controller' => 'admins', 'action' => 'add')),
                )
            )
        )
    )
);

$publisher_menu = array(
    __('Control panel', true) => array('url' => '/admin/',
        'subs' => array(
            'Items' => array('class' => 'closed',
                'subs' => array(
                    'List Items' => array('url' => array('controller' => 'items', 'action' => 'index')),
                    'Add Item' => array('url' => array('controller' => 'items', 'action' => 'add')),
                )
            ),
        )
    )
);
?>
<link href="<?php echo Router::url("/css/jquery.treeview_$lang.css") ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo Router::url("/js/jquery.treeview.js"); ?>"></script>
<div class="module">
    <h2><span><?php __("Main menu") ?></span></h2>

    <div class="module-body">

        <ul id="browser" class="filetree treeview-famfamfam">

            <?php
            if ($admin['Admin']['publisher'] == 1) {
                $menu = $publisher_menu;
            } else {
                $menu = $admin_menu;
            }
            side_menu($menu);
            ?>

        </ul>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#browser").treeview({});
        var $id='<?php echo Inflector::camelize($this->params['controller']) ?>';
        $('#'+$id).removeClass('closed').removeClass('expandable').addClass('opened').addClass('collapsable');
        $('#'+$id).find('> div').removeClass('closed-hitarea').removeClass('expandable-hitarea').addClass('opened-hitarea').addClass('collapsable-hitarea');
        $('#'+$id).find('> div').removeClass('lastExpandable-hitarea').addClass('lastCollapsable-hitarea');
        $('#'+$id).find(' > ul').show();
        
    });
</script>

<?php

function side_menu($menu = array()) {
    foreach ($menu as $key => $item) {
        $class = (!empty($item['subs'])) ? 'folder' : 'file';
        $class2 = (!empty($item['class'])) ? $item['class'] : 'opened';
        ?>
        <li class="<?php echo $class2; ?>" id="<?php echo (isset($item['id'])) ? Inflector::camelize($item['id']) : Inflector::camelize($key); ?>">
            <span class="<?php echo $class ?>">
                <?php if (!empty($item['url'])) { ?>
                    <a href="<?php echo Router::url($item['url']); ?>">
                        <?php
                    } echo __($key, true);
                    if (!empty($item['url'])) {
                        ?> </a> <?php } ?>
            </span>
            <?php
            if ($class == 'folder') {
                echo '<ul>';
                side_menu($item['subs']);
                echo '</ul>';
            }
            ?>
        </li>

        <?php
    }
}
?>