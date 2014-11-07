<?php $url = array('controller'=>'posts','action' => 'add_post'); ?>
<div class="teacher-wrapper">
    <div class="teacher-post">
        <?php echo $form->create('Post', array('type' => 'file', 'url' => $url)); ?>
        <?php echo $form->textarea('content'); ?>
        
    </div>
    <div class="click post">click</div>
</div>

<?php foreach($posts as $post){
  
    ?>
<div class="teacher-wrapper">


    <div class="teacher-post">
        <div class="teacher-image">
        <?php if(isset($post["User"]['image'])){?>
             <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile',$post['User']['id'])) ?>" class="thumbnail">
                  <img src="<?php echo Router::url($post['User']['image']); ?>" alt="<?php $post['User']['name']; ?>">
            </a>
        <?php }else{ ?>
            <img alt="" src="<?php echo Router::url('/css/images/default_user.png') ?>" width="40">
        <?php }?>
        </div>
        <h4 class="teacher-name"><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'view', $post['User']['id'])) ?>"><?php echo $post['User']['name']?></a></h4>
       
        <?php 
   
         if(!empty($post['bookmarks']))
            {?>
        <div target='<?php echo $post['Post']['id'];?>' title="remove this post from favourite list" class="bookmark unbook">unbookmark</div>
          <?php   }else{?>
         <div target='<?php echo $post['Post']['id'];?>'title="add to favourite list" class="bookmark book">bookmark</div>
         <?php } ?>
        
        <p target='<?php echo $post['Post']['id'];?>'class="teacher-body"><?php echo $post['Post']['content'];?></p>
        <div class="action" style="">
            <?php
            
            $likes="like";
            $class="like";
            $count= " ";
         if(!empty($post['likes']))
                {
                      $count=count($post['likes']);
                     if($count!=0){
                         $count=" ( ".$count." ) ";
                     }
            foreach($post['likes'] as $like){
                
           $userid=$like['Like']['user_id'];
             if($userid==$user_id){
                 $likes="un like";  
                 $class="un_like";
             }
            }
            }
            ?>
            <div style="" target="<?php echo $post['Post']['id'];?>" title="<?php echo $likes; ?>" class="like-action <?php echo $class; ?>"> <?php echo  $likes .$count ;?></div>
            <div style="" target="<?php echo $post['Post']['id'];?>" title="leave a comment" class="do-comment">Comment</div>
            
        </div>
        <br class="clear">
            <?php
            if(!empty($post['posts']))
                {
            foreach($post['posts'] as $comment){
            //debug($comment);?>
        <div class="comment-post">
            
            <div class="teacher-image">
                    <?php if(isset($comment["User"]['image'])){?>
                        <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'profile',$comment['User']['id'])) ?>" class="thumbnail">
                                        <img src="<?php echo Router::url($comment['User']['image']['thumb1']) ?>" alt="<?php $comment['User']['name']; ?>">
                         </a>
            
        <?php }else{ ?>
                <img alt="" src="<?php echo Router::url('/css/images/default_user.png') ?>" width="40">
        <?php }?>
            </div>
            <div target='<?php echo $comment['Comment']['id'];?>' class="comment-action">X</div>
            <h4 class="teacher-name"><?php echo $comment['User']['name']?></h4> 
            <p class="teacher-body"><?php echo $comment['Comment']['content']?></p>
        </div>
        <?php }
            }?>
        <?php $url = array('controller'=>'posts','action' => 'add_comment'); ?>
                
        <div class="comment-post CommentContent_<?php echo $post['Post']['id'];?>" target='<?php echo $post['Post']['id'];?>' contenteditable="true" >
                     

                    </div>
                    <div target='<?php echo $post['Post']['id'];?>'  title="add comment" class="click comment">click</div>
                
       
    </div>


</div>
<?php } ?>

<?php
echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'chosen.jquery'));
echo $html->css(array('jquery-ui-1.8.24.custom', 'chosen','comments'));
?>
<script>
$(document).ready(function(){
    
    $('.post').click(function(){
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
   $('.comment').click(function(){
      
    
    var postid=$(this).attr('target');
    var content=$('.CommentContent_'+postid).text();
        console.log(content);
     $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'add_comment')) ;?>",
                        {
                            data:content,
                            postid:postid
                            
                        }, 
                        function(data) {
                            console.log(postid);
			});
 });
    $('.like').click(function(){
      
    
    var postid=$(this).attr('target');
  
        
     $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'add_like')) ;?>",
                        {
                            
                            postid:postid
                            
                        }, 
                        function(data) {
                            console.log(data);
			});
 });
   $('.un_like').click(function(){
    var postid=$(this).attr('target');
     $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'remove_like')) ;?>",
                        {
                            
                            postid:postid
                            
                        }, 
                        function(data) {
                            console.log(data);
			});
 });
  $('.book').click(function(){
    var postid=$(this).attr('target');
     $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'add_bookmark')) ;?>",
                        {
                            
                            postid:postid
                            
                        }, 
                        function(data) {
                            console.log(data);
			});
 });
 $('.unbook').click(function(){
    var postid=$(this).attr('target');
     $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'remove_bookmark')) ;?>",
                        {
                            
                            postid:postid
                            
                        }, 
                        function(data) {
                            console.log(data);
			});
 });
 $('.comment-action').click(function(){
    var postid=$(this).attr('target');
    var delete_comm=$(this).parent('.comment-post');
    $(this).parent('.comment-post').slideUp(500,function(){
        (this).parent('.comment-post').remove();
    });
    console.log(delete_comm);
    $.post("<?php echo Router::url(array('controller' => 'posts', 'action' => 'remove_comment')) ;?>",
                        {
                            postid:postid 
                        }, 
                        function(data) {
                            console.log();
			});
 });
 $('.do-comment').click(function(){
     target=$(this).attr('target');
     console.log(target);
             $('.CommentContent_'+target).focus();
                 
    });
    });
    
    
</script>