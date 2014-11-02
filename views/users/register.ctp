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

                    <div id="wrapper">







                        <div id="register" class="animate form">
                            <?php 
$url = array('action' => 'registser');

 echo $form->create('User', array('type' => 'file')); ?>
                            <h1>Sign up</h1> 
                            <h1>University Easier </h1>
                            <?php echo $session->flash();?>
<?php
//    debug($this->data);
 echo $form->input('id');?>
                            <p> 

 <?php echo $form->input('name',array('id'=>'username')); ?>
                            </p>   

                            <p> 

 <?php echo $form->input('username',array('id'=>'usernamesignup')); ?>
                            </p>
                            <p> 

<?php echo $form->input('password',array('id'=>'passwordsignup')); ?>
                            </p>

                            <p> 

<?php echo $form->input('passwd',array('id'=>'passwordsignup')); ?>
                            </p>
                            <p> 


 <?php echo $form->input('email',array('class'=>'youmail','id'=>'emailsignup')); ?> 
                            </p>
     <?php echo $form->input('birth_date', array('type' => 'text', 'class' => 'hasDate')); ?>
<?php
  echo $this->Form->input('faculty_id', array('label'=>'Faculty','options'=>array($faculty))); 
      
        echo '<div id="categ_rep">';
      echo "hi";
    echo '</div>';
    echo '<div id="categ_rep">';
      
    echo '</div>';
?>

                            <div class = "input text">
                                <label><?php __('Image'); ?></label>
    <?php
    echo $form->input('image', array('type' => 'file','label'=>false,
        'between' => $this->element('image_element', array('info' => !empty($this->data['User']['image']) ? $this->data['User']['image'] : '', 'field' => 'image')))); ?>

                            </div>

                            <div class="form-actions">
    <?php
 echo $form->submit('Submit', array('class' => 'btn btn-primary')); ?>

                            </div>
                            <div class="change_link">  

                                Already a member ?
                                <div class="design replace_register"><a href="<?php echo Router::url(array('controller' => 'users','action'=>'login')) ?>">login</a></div>
                            </div>
<?php echo $form->end(); ?>


                        </div>

                    </div>
                </div>  
            </section>
        </div>
   
  


<?php
 echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'jquery-ui-timepicker-addon', 'chosen.jquery')); ?>
<?php echo $html->css(array('jquery-ui-1.8.24.custom', 'datetimepicker', 'chosen')); ?>

     <?php
$this->Js->get('#FacultysId')->event('change', 
	$this->Js->request(array(
		'controller'=>'users',
		'action'=>'categ_add_ajax'
		), array(
		'update'=>'#categ_rep',
		'async' => true,
		//'method' => 'post',
		'dataExpression'=>true,
		'data'=> '$("#FacultyId").serialize()'
		))
	);
?>






    <script type="text/javascript">
        $(".collapse").collapse();
        $(document).ready(function() {
            $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
                changeYear: true});
            
        });
        $('.hasDate').live('focus', function() {
            $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
                changeYear: true});
        })
     
    </script>

            <?php if (!empty($config['footer'])) { ?>

            <?php } ?>


        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>

