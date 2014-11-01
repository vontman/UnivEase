<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $ccourse['Course']['id'])) ?>"> <?php echo $ccourse['Course']['name'] ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo __('Slide Maker', true) ?></li>
    </ul>
</div>
<!--<iframe src="http://e-teacherdiploma.com/SlideMaker" width="100%" height="1000px"  > </iframe>-->
<iframe  id="myframe" width="100%" height="1000px" visibility="hidden" class="hidden" aria-hidden="true"></iframe>
        

<script>
        $(document).ready(function() {
            $('#myframe').attr('src', 'http://learn-ubel.com/SlideMaker');
            //$('#myframe').attr('src', 'http://localhost/SlideMaker');
        });
               
</script>