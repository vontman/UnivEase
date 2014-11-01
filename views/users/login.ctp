<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->


<html lang="<?php  echo $lang ?>">

    <!--<![endif]-->
    <head>

        <?php echo $html->charset(); ?>
        <title>
            <?php echo "Univ |"; ?>
        </title>
        <meta name="viewport" content="width=device-width" />
                <!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>-->
        <?php
        echo $html->css(array('demo','style1','animate-custom','bootstrap')); ?>
		 <?php echo $html->css(array('print'), 'stylesheet', array('media' => 'print')); ?>
        <?php echo $javascript->link(array('jquery-1.8.2.min', 'app', 'switch', 'tabdrop', 'modernizr', "jquery.toastmessage")); ?>
       <?php echo $javascript->link(array('js/swfobject','js/recorder')); ?>
        
      
	<?php
	if (class_exists('JsHelper') && method_exists($this->Js, 'writeBuffer'))  echo $this->Js->writeBuffer();
	// Writes cached scripts
	?>  
    </head>
    <body>

        <div class="containers">

            <section>				
                <div id="container_demo" >
                    <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
                    <a class="hiddenanchor" id="toregister"></a>
                    <a class="hiddenanchor" id="tologin"></a>
                    <div id="wrapper">
                        <div id="login" class="animate form">
        <?php                    
echo $form->create('User', array('url' => array('action' => 'login')));
 ?>
                            <h1>Log in</h1> 
                            <h1>University Easier </h1>
                          <?php  echo $session->flash();?>
<?php
//    debug($this->data);
 echo $form->input('username',array('label' =>'username','class'=>'uname','id'=>'username')); ?>
<?php echo $form->input('password',array('label' =>'password','class'=>'youpasswd','id'=>'password')); ?>






                            <div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary')); ?>

                            </div>
                            <div class="change_link">  
                                
                                join us ? ?
                                <div class="design replace_login"><a href="<?php echo Router::url(array('controller' => 'users','action'=>'register')) ?>">register</a></div>
                                 </div>
                        
<?php echo $form->end(); ?>

                        </div>
                        
                        
                        



                    </div>
                </div>  
            </section>
        </div>
    </body>


<?php
 echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'jquery-ui-timepicker-addon', 'chosen.jquery')); ?>
<?php echo $html->css(array('jquery-ui-1.8.24.custom', 'datetimepicker', 'chosen')); ?>








    <script type="text/javascript">
        $(".collapse").collapse();
           $(document).ready(function() {
        $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
            changeYear: true});
        change_students();
    });
    $('.hasDate').live('focus', function() {
        $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
            changeYear: true});
    })
    $('.replace_login').click(function(){
        $('#login').fadeOut(1000);
        $('#register').fadeIn(1000);
    });
    $('.replace_register').click(function(){
        $('#login').fadeIn(1000);
        $('#register').fadeOut(1000);
    });
    </script>

            <?php if (!empty($config['footer'])) { ?>

            <?php } ?>


        <?php echo $this->element('sql_dump'); ?>

</html>
