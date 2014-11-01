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
                '/formbuilder/formbuilder'
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
        <div class="">

            <div class="main">
                <?php
                echo $session->flash();
                echo $content_for_layout;
                ?>
                <script type="text/javascript">
                    $(".collapse").collapse();
                </script>
            </div>

        </div>

    </body>
</html>