<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?php echo $lang ?>">
    <!--<![endif]-->
    <head>
        <link rel="shortcut icon" sizes="16x16" href="<?php echo Router::url($config['logo']['thumb1']) ?>">
        <?php echo $html->charset(); ?>
        <title>
            <?php echo "Univ |".$title_for_layout; ?>
        </title>
        <meta name="viewport" content="width=device-width" />
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
        <?php
        echo $html->css(array('bootstrap','main'));
		 echo $html->css(array('print'), 'stylesheet', array('media' => 'print'));
        echo $javascript->link(array('jquery-1.8.2.min', 'app', 'switch', 'tabdrop', 'modernizr', "jquery.toastmessage"));
       echo $javascript->link(array('js/swfobject','js/recorder'));
        echo $scripts_for_layout;
        ?>
        <?php
        
		/*jquery-1.8.2.min*/
      $users = $this->Session->read('admin');
      
        
        if (isset($unreaded_messages)) {
            if($unreaded_messages>1){
            ?>
             <script type="text/javascript">
                $(window).load(function(){
                    $().toastmessage('showToast', {text :'<a href="<?php echo Router::url(array('controller' => 'messages')) ?>" class="new-message"><span> <?php echo $unreaded_messages; ?> </span> &nbsp;<?php __('Unreaded Messages'); ?></a>',position : 'top-center'});
                })
            </script>
        <?php } else{?>
        <script type="text/javascript">
                $(window).load(function(){
                    $().toastmessage('showToast', {text :'<a href="<?php echo Router::url(array('controller' => 'messages')) ?>" class="new-message">&nbsp;<?php __('Unreaded Message'); ?></a>',position : 'top-center'});
                })
            </script>
            
       <?php  } } ?>
		<!-- Js writeBuffer -->
	<?php
        debug($users);
	if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer')) echo $this->Js->writeBuffer();
	// Writes cached scripts
	?>  
    </head>
    <body>
        <div style='margin-top: 100px;'class="container <?php isset($scorm_layout) ? print('scorm')  : ''; ?>">
            <div class="row">
        <nav class="navbar navbar-default navbar-fixed-top upper-nav" role="navigation">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">UnivEasier</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="#">Profile</a></li>

                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <li><form class="navbar-form navbar-left" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>

                            </form>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Users</a></li>
                                <li><a href="#">subject</a></li>
                                <li><a href="#">faculty</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'logout', 'prefix' => false, 'admin' => false)) ?>">
                                <span class="symp-switch" aria-hidden="true"></span><?php __('logout') ?>
                            </a></li>
                        

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
    <div class="row">
            <div class="">
                 <!-- Start left panel-->
                <div class="col-xs-3 fixed-left ">
                     <!-- Start profile panel-->
                    <div class=" panel panel-default">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12 col-md-12">
                                    <a href="#" class="thumbnail">
                                        <img src="slide.png" alt="...">
                                    </a>
                                    <h4><a href="#"><?php echo $users['User']['name'] ?></a><br class="clear" /></h4>
                                    <h5><a href="#">department</a></h5>
                                    <h6><a href="#">type</a></h6>


                                </div>

                            </div>
                        </div>
                    </div>
                      <!-- End profile panel-->
                      
                      
                       <!-- Start subject panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding:3%;">
                            <h3 style="" class="panel-title">Subjects</h3>
                        </div>
                        <div style="padding:3%; " class="panel-body">
                            <div class="row">
                
        <div class="col-xs-4 col-md-4">
            <a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'add1','admin'=>'false')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/courses.png') ?>" width="64" />
            </a>
        </div>
                                 <div class="col-xs-4 col-md-4">
            <a href="<?php echo Router::url(array('controller' => 'faculties', 'action' => 'add','admin'=>'false')) ?>" class="dashboard-module">
                <img src="<?php echo Router::url('/css/images/ico/courses.png') ?>" width="64" />
            </a>
        </div>
                            
                             

                            </div>
                        </div>
                    </div>
                        <!-- End subject panel-->
                        
                        
                         <!-- Start professor panel-->
                    <div class="panel panel-default">
                        <div class="panel-heading" style="padding:3%;">
                            <h3 style="" class="panel-title">Professors</h3>
                        </div>
                        <div style="padding:3%; " class="panel-body">
                            <div class="row">
                                <div class="col-xs-4 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src="prof.jpg" alt="...">omar
                                    </a>
                                </div>
                                <div class="col-xs-4 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src="prof.jpg" alt="...">amr
                                    </a>

                                </div>
                                <div class="col-xs-4 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src="prof.jpg" alt="...">math
                                    </a>

                                </div>
                                <div class="col-xs-4 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src="prof.jpg" alt="...">math
                                    </a>
                                </div>
                                <div class="col-xs-4 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src="prof.jpg" alt="...">math
                                    </a>

                                </div>
                                <div class="col-xs-4 col-md-4">
                                    <a href="#" class="thumbnail">
                                        <img src="prof.jpg" alt="...">math
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                          <!-- End professor panel-->
                </div>
                  <!-- End left panel-->
            </div>
            
            <div class="col-xs-6">
                 <!-- Start posts -->
                <div class="wrapper" >

 <?php
                echo $session->flash();
                echo $content_for_layout;
                ?>
                <script type="text/javascript">
                    $(".collapse").collapse();
                </script>
                  


 <!-- End posts-->
                </div>
            </div>
            <!-- Start right panel-->
            <div class="col-xs-3 fixed-right">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:3%;">
                        <h3 style="" class="panel-title">new lectures</h3>
                    </div>
                    <div style="padding:3%; " class="panel-body">
                        <a class="lecture" href="#">First lecture</a>
                        <a class="lecture" href="#">First lecture</a>
                        <a class="lecture" href="#">First lecture</a>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding:3%;">
                        <h3 style="" class="panel-title">top cgpa</h3>
                    </div>
                    <div style="padding:3%; " class="panel-body">
                        <h5><a href="#">Omar el 2wl y3am 2ho 3shn hndsa bs :D</a></h5>
                        <h5><a href="#">amr b3d 2znk ltany :D</a></h5>
                    </div>
                </div>
                 <div class="panel panel-default">
                    <div class="panel-heading" style="padding:3%;">
                        <h3 style="" class="panel-title">recent news</h3>
                    </div>
                    <div style="padding:3%; " class="panel-body">
                        <h5><a href="#">Omar el 2wl y3am 2ho 3shn hndsa bs :D</a></h5>
                        <h5><a href="#">amr b3d 2znk ltany :D</a></h5>
                    </div>
                </div>
            </div>
             <!-- End right panel-->
        </div>

           
            <?php if (!empty($config['footer'])) { ?>
                <div class="footer-center"><?php echo $config['footer']; ?></div>
            <?php } ?>
        </div>

        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>