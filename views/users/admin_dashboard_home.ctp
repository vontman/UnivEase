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
            <a href="<?php echo Router::url(array('controller' => 'faculties', 'action' => 'index')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/courses.png') ?>" width="64" />
                <?php echo $faculty . __('Faculties') ?>
            </a>
            
        </li>
        <li>
            <a href="<?php echo Router::url(array('controller' => 'categories')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/1372305699_Courses.png') ?>" />
                <?php echo $category . __('Categories') ?>
            </a>
            
        </li>
        <li>
            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'index')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/1372305616_Supervisor.png') ?>" />
                <?php echo $admin .  __('Admins') ?>
            </a>
            
        </li>
       
        
    </ul>
</div>









