<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?php echo $lang ?>">
    <!--<![endif]-->
    <head>
        <?php echo $html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <meta name="viewport" content="width=device-width" />

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->

        <?php
            echo $html->css(array(
              '/formbuilder/bower_components/font-awesome/css/font-awesome', 
                                  '/formbuilder/formbuilder'
              ));
          
            echo $javascript->link(array(
              '/formbuilder/bower_components/jquery/jquery',
                                         '/formbuilder/bower_components/jquery-ui/ui/jquery.ui.core',
                                         '/formbuilder/bower_components/jquery-ui/ui/jquery.ui.widget',
                                         '/formbuilder/bower_components/jquery-ui/ui/jquery.ui.mouse', 
                                         '/formbuilder/bower_components/jquery-ui/ui/jquery.ui.draggable',
                                         '/formbuilder/bower_components/jquery-ui/ui/jquery.ui.droppable',
                                         '/formbuilder/bower_components/jquery-ui/ui/jquery.ui.sortable',
                                         '/formbuilder/bower_components/underscore/underscore-min',
                                         '/formbuilder/bower_components/underscore.mixin.deepExtend/index',
                                         '/formbuilder/bower_components/rivets/dist/rivets',
                '/formbuilder/bower_components/backbone/backbone',
                '/formbuilder/bower_components/backbone-deep-model/src/deep-model',
                '/formbuilder/formbuilder_ar'
              ));

        echo $html->css(array('app', 'ico', 'theme', 'fonts/ar-fonts', 'switch', 'mobile'));
        echo $javascript->link(array('app', 'switch', 'tabdrop', 'modernizr'));



        echo $scripts_for_layout;
        ?>

        <!-- Js writeBuffer -->
        <?php
        if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer'))
            echo $this->Js->writeBuffer();
        // Writes cached scripts
        ?>  

    </head>
    <body>
        <div class="layout <?php isset($scorm_layout) ? print('scorm')  : ''; ?>">
            <div class="header">
                <div class="logo">
                    <a href="<?php echo Router::url('/'); ?>">
                        <?php
//                        debug($config);
                        if (!empty($config['logo'])) {
                            ?>
                            <img src="<?php echo Router::url($config['logo']['thumb1']) ?>" alt="" /></a>
                    <?php } else { ?>
                        <img src="<?php echo Router::url('/css/images/logo.png') ?>" alt="" /></a>
                    <?php } ?>
                </div>
                <?php if (!empty($user)) { ?>
                    <div class="login-as">
                        <a data-toggle="dropdown" href="#">
                            <?php if (isset($user['image']['path'])) { ?>
                                <img alt="" src="<?php echo Router::url($user['image']['path']) ?>">

                            <?php } else { ?>
                                <img alt="" src="<?php echo Router::url('/css/images/default_user.png') ?>" width="40">
                            <?php } ?>

                            <span class="user-name font-a"><?php isset($user['name']) ? print($user['name'])  : print($user['name'])  ?></span>
                            <?php if (isset($user['type']) && $user['type'] == 'admin') { ?>
                                <span class="job"><?php __('Admin') ?> </span>
                            <?php } ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php
                                if (isset($user['type']) && $user['type'] == 'admin') {
                                    echo Router::url(array('controller' => 'admins', 'action' => 'profile'));
                                } else {
                                    echo Router::url(array('controller' => 'users', 'action' => 'profile'));
                                }
                                ?>">
                                       <?php __('My Profile'); ?>
                                    <i class="icon-user"></i></a></li>
                            <li><a href="<?php echo Router::url(array('controller' => 'messages')) ?>"> <?php __('Messages') ?> <i class="icon-envelope"></i></a></li>
                            <li class="divider"></li>
                            <li><a href="<?php echo Router::url(array('action' => 'set_language', 'ar')) ?>"> <?php __('Arabic') ?> <i class="icon-cog"></i></a></li>
                            <li><a href="<?php echo Router::url(array('action' => 'set_language', 'en')) ?>"> <?php __('English') ?> <i class="icon-cog"></i></a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout', 'prefix' => false, 'admin' => false)) ?>">
                                    <?php __('Signout') ?>
                                    <i class="icon-off"></i></a>
                            </li>
                        </ul>
                    </div>

                    <? // This is the beginning of code language bar ?>
                    <br><br>
                    <p style="margin-left:20px;">

                        &nbsp; &nbsp; <a href="<?php echo Router::url(array('action' => 'set_language', 'ar')) ?>"><b><font color="white"> <?php __('Arabic') ?></font></b> <i class="icon-cog"></i></a>
                        <a href="<?php echo Router::url(array('action' => 'set_language', 'en')) ?>"><b><font color="white"> <?php __('English') ?></font></b> <i class="icon-cog"></i></a>

                    </p>
                    <? // This is the end of code language bar ?>
                <?php } ?>
                <div class="clear"></div>
            </div>
            <?php if (!empty($user)) { ?>
                <div class="sidebar leftpanel" id="rmv">
                    <ul>
                        <li>
                            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>">
                                <span class="symp-home-2" aria-hidden="true"></span>
                                <?php __('Home') ?>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="active">
                                <span class="symp-tv" aria-hidden="true"></span>
                                <?php __('Courses') ?>
                            </a>
                        </li>
                        <!--<li><a href="#"><span class="symp-calendar" aria-hidden="true"></span><?php __('Home') ?></a></li>-->
                        <?php if (isset($user['type']) && $user['type'] == 'admin') { ?>
                            <li>
                                <a href="<?php echo Router::url(array('controller' => 'configurations', 'action' => 'edit')) ?>">
                                    <span class="symp-cog" aria-hidden="true"></span>
                                    <?php __('Settings') ?>
                                </a>

                            </li>
                        <?php } ?>
                        <li>

                            <a href="<?php echo Router::url(array('controller' => 'messages')) ?>">  
                                <span class="symp-envelope" aria-hidden="true"></span><?php __('Messages') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Router::url(array('controller' => 'schedule_categories', 'action' => 'index')) ?>">  
                                <span class="symp-calendar" aria-hidden="true"></span>
                                <?php __('Schedule') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Router::url(array('controller' => 'reports', 'action' => 'index')) ?>">  
                                <span class="symp-pencil" aria-hidden="true"></span>
                                <?php __('Reports') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout', 'prefix' => false, 'admin' => false)) ?>">
                                <span class="symp-switch" aria-hidden="true"></span><?php __('Signout') ?>
                            </a>
                        </li>
                    </ul>
                </div>
            <?php } ?>


            <div class="main">
                <?php
                echo $session->flash();
                echo $content_for_layout;
                ?>
                <script type="text/javascript">
                    $(".collapse").collapse();
                </script>
            </div>
            <?php if (!empty($config['footer'])) { ?>
                <div class="footer-center"><?php echo $config['footer']; ?></div>
            <?php } ?>
        </div>

        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>