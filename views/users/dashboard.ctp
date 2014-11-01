<?php /* @var $html HtmlHelper */ ?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
    </ul>
</div>
<h1>
    <?php __('Courses'); ?>
</h1>
<div class="msghead" style="margin-bottom: 34px;">
<ul class="msghead-menu">
        <li>
             <a class="btn" href="<?php echo Router::url(array('controller' => 'course_users','action' => 'student_add',$user_id)) ?>"> 
                <?php __('submit courses') ?>
                <i class="icon-plus"></i>
            </a>
        </li>
</ul>
    
    
</div>
<hr />

<?php
if (!empty($courses)) {
    ?>
    <div class="items dashboard-items flexslider">
        <ul class="slides">
      
            <?php
            
            $i = 0;
            foreach ($courses as $course) {
                if (($i % 4) == 0) {
                    if ($i != 0) {
                        ?>
                        </li>
                    <?php } ?>
                    <li class="<?php echo $i ?>">  
                        <?php
                    }
                    ?>
                    <div class="book-wrap"><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $course['Course']['id'])) ?>" ><img src="<?php echo Router::url('/img/uploads/course.png') ?>" alt="" /></a><?php echo $course['Course']['name'] ?></div>
                    <?php
                    $i++;
                }
                ?>
            </li>
        </ul>
    </div>
<?php } else { ?>
    <div class="alert alert-block"> <?php __('There are not any active courses for you') ?></div>
<?php }
?>

<?php
//echo $html->css('flexslider');
//echo $html->script('flexslider-min');
?>
<script type="text/javascript" charset="utf-8">
    $(window).load(function() {
       // $('.flexslider').flexslider({animation: "slide", directionNav: true});
    });
</script>
