<style>
    .dashboard{
        margin: 0 auto;
    }
    .dashboard ul li a{
        width: auto;
        height: auto;
    }
</style>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
    </ul>
</div>
<h1><?php __('Dashborad') ?></h1>
<div class="items dashboard">
    <ul>
        <li>
            <a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'index')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/courses.png') ?>" width="64" />
            </a>
            <?php __('Courses') ?>
        </li>
        <li>
            <a href="<?php echo Router::url(array('controller' => 'groups')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/1372305699_Courses.png') ?>" />
            </a>
            <?php __('Groups') ?>
        </li>
        <li>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'index')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/1372305616_Supervisor.png') ?>" />
            </a>
            <?php __('Users') ?>
        </li>
        <li>
              <a href="<?php echo Router::url(array('controller' => 'payments', 'action' => 'index')) ?>" class="dashboard-module">
                    <img src="<?php echo Router::url('/css/images/ico/payment_icon.png') ?>" />
              </a>
              <?php __('Payments') ?>
         </li>
        <li>
            <a href="<?php echo Router::url(array('controller' => 'admins', 'action' => 'index')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/user-admin-1.png') ?>"  width="64" />
            </a>
            <?php __('Administrators') ?>
        </li>
    </ul>
</div>

<h1><?php __('Categories'); ?></h1>
<div class="msghead">
    <ul class="msghead-menu">
        <li>
            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'categories', 'action' => 'add')) ?>"> 
                <?php __('Add Category') ?>
                <i class="icon-plus"></i>
            </a>
        </li>
    </ul>
    <span class="clearall"></span> 
</div>
<hr />

<?php

function category_menu($categories) {
    if (!empty($categories)) {
        ?>
        <div id="timeline" class="timeline">
            <?php foreach ($categories as $category) { ?>
                <div id="timeline" class="timeline-item">
                    <h3><a href="#level<?php echo $category['Category']['id']; ?>" data-toggle="collapse" data-target="#level<?php echo $category['Category']['id']; ?>"><span class="timeline-icon"><i></i></a></span> <a href="<?php echo Router::url(array('controller' => 'categories', 'action' => 'view', $category['Category']['id'])) ?>"><?php ($category['Category']['courses']) ? print( $category['Category']['name'] . '(' . $category['Category']['courses'] . ') ')  : print($category['Category']['name']); ?></a></h3>
                    <?php
                    if ($category['Category'])
                        if ($category['children']) {
                            ?>
                            <div class="items accordion-body collapse in" id="level<?php echo $category['Category']['id']; ?>">
                                <?php
                                category_menu($category['children']);
                                ?>
                            </div>
                        <?php } ?>
                </div>
            <?php } ?>

        <?php }
        ?>
    </div>
    <?php
}

category_menu($categories);
?>






