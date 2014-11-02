<?php echo $html->css(array('add_posts'));?>
<?php echo $javascript->link(array('add_post'));?>
<div id='add_post_wrapper'>
            <div class="add_post">
                <div class='add_post_input'>
                    <?php echo $this->Form->input('content',array('label'=>'','type'=>'textarea','id'=>'add_post_body','placeholder'=>'Add new post...'));?>
                </div>
                <div class='add_post_functions'>
                    
                    <?php echo $form->submit('Submit', array('id'=>'add_post_sbmt','value'=>'post')); ?>
                    <?php echo $form->end(); ?>
                </div>
            </div>
            <div id="add_post_toggle"><img src="png/arrow451.png"/></div>
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