<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $html->charset(); ?>
        <title>
            <?php echo 'Login'; ?>
        </title>
        <?php
        echo $html->css(array('admin_'.$lang));
        echo $javascript->link(array('jquery.min15'));
        ?>
    </head>
    <body>
        <table height="211" border="0" align="center" style="background:#FFF;" width="40%" >
            <tr>
                <td align="right">
                    <?php echo  $session->flash(); ?>
                    <div class="module">
                        <h2><span><?php __("Login") ?></span></h2>
                        <div class="module-body">
                            <?php echo $form->create('Admin', array('action' => 'login')); ?>
                            <?php echo $form->input('username'); ?>
                            <?php echo $form->input('password'); ?>
                            <?php echo $form->submit('Submit') ?>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </body>
</html>