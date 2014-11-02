<?php $url = array('controller'=>'posts','action' => 'add_post'); ?>
<div class="teacher-wrapper">
    <div class="teacher-post">
        <?php echo $form->create('Post', array('type' => 'file', 'url' => $url)); ?>
        <?php echo $form->textarea('content'); ?>
        <?php echo $form->submit('Submit', array('class' => 'submit-reply'));?>
    </div>
    <div class="click">click</div>
</div>

<?php foreach($posts as $post) {?>
<div class="teacher-wrapper">


    <div class="teacher-post">
        <div class="teacher-image">
        <?php if(isset($post["User"]['image'])){
            
        }else{ ?>
            <img alt="" src="<?php echo Router::url('/css/images/default_user.png') ?>" width="40">
        <?php }?>
        </div>
        <h4 class="teacher-name"><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'view', $post['User']['id'])) ?>"><?php echo $post['User']['name']?></a></h4>
        <p target='<?php echo $post['Post']['id'];?>'class="teacher-body"><?php echo $post['Post']['content'];?></p>
        <div class="comment-post">
            <div class="teacher-image"><img class="img-responsive img-rounded" src="bg.jpg"></div>
            <h4 class="teacher-name">adsada</h4>
            <p class="teacher-body">sadsdsa adsad asdsa sdsasa</p>
        </div>
        <div class="comment-post">
            <div class="teacher-image"><img class="img-responsive img-rounded" src="bg.jpg"></div>
            <h4 class="teacher-name">adsada</h4>
            <p class="teacher-body">sadsdsa adsad asdsa sdsasa</p>
        </div>
        <div class="comment-post">
            <div class="teacher-image"><img class="img-responsive img-rounded" src="bg.jpg"></div>
            <h4 class="teacher-name">adsada</h4>
            <p class="teacher-body">sadsdsa adsad asdsa sdsasa</p>
        </div>
    </div>


</div>
<?php } ?>

<?php
echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'chosen.jquery'));
echo $html->css(array('jquery-ui-1.8.24.custom', 'chosen'));
?>
<script>
$(document).ready(function(){
    
    $('.click').click(function(){
    var content=$('#PostContent').val();
    console.log(content);
     $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'add_post')) ;?>",
                        {
                            data:content,
                            
                        }, 
                        function(data) {
                            console.log(data);
			});
 });    
    });
    
</script>