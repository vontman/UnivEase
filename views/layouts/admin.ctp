<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $dir; ?>">
    <head>
        <?php echo $html->charset(); ?>
        <title>
            <?php echo $title_for_layout; ?>
        </title>
<!--        <script type="text/javascript" src="<?php echo Router::url('/js/jquery.min14.js') ?>"></script>-->
        <?php
        echo $html->css(array('admin_' . $lang));
        echo $javascript->link(array('jquery-1.8.2.min'));
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="container" class="wrapper">
            
            <div id="content">
                <table  width="96%" align="center" border="0" cellpadding="0" cellspacing="0" height="70%"> 
                    <tr>
                        <td colspan="2" height="70">
                            <?php echo $session->flash(); ?>
                        </td>
                    </tr>

                    <tr class="addCategory">
                        <td width="25%" valign="top" >
                            <?php //echo $this->element('side_menu'); ?>
                        </td>
                        <td width="75%" valign="top"  style="padding-right: 5px;padding-left: 5px;">
                            <div class="module">

                                <?php echo $content_for_layout; ?>                
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div id="footer">
                <table align="center" width="100%">

                    <tr>
                        <td colspan="11" align="center" style="padding-top:5px">

                        </td></tr>

                </table>
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>