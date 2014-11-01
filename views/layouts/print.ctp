<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $dir; ?>">
    <head>
        <?php echo $html->charset(); ?>
        <title>

            <?php echo $title_for_layout; ?>
        </title>
        <?php if (isset($meta_keywords)) { ?>
            <meta name="keywords" content="<?php echo $meta_keywords ?>" /> 
            <?php
        }
        if (isset($meta_description)) {
            ?>
            <meta name="description" content="<?php echo $meta_description ?>" /> 
        <? } ?>
        <meta http-equiv="expires" content="Fri,31 Dec 2010 11:59:59 GMT" />
        <meta http-equiv="cache-control" content="no-cache" />

        <?php
        echo $html->css(array('style_'.$lang, 'font', 'sliders'));
        echo $html->meta('icon');


        echo $scripts_for_layout;
        ?>



    </head>

    <body class="<?php echo $lang ?>">
        <?php
        
        echo $content_for_layout;
        ?>
    </body>
</html>
