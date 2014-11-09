<!--<div class="row down-row">
        <nav class="navbar navbar-default navbar-fixed-top down-nav " role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">toggle navigation </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
            </div>
            <div class="container">
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav nav-tabs">
                        
                        <li class="active"><a href="<?php // echo Router::url(array('action'=>'index',$id)) ?>">all</a></li>
                        <li><a href="<?php // echo Router::url(array('action'=>'users',$id)) ?>">users</a></li>
                        <li><a href="<?php // echo Router::url(array('action'=>'lecture')) ?>">lecture</a></li>
                        <li><a href="<?php // echo Router::url(array('action'=>'request')) ?>">request</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>-->
<h2>Admins</h2>
<ul class="list-group">
    <?php
    
    foreach($group_user as $user){
        if($user['GroupUser']['user_type']==1){?>
  <li class="list-group-item">
      <a href="<?php echo Router::url(array('controller' => 'users','action'=>'profile',$user['User']['id'])) ?>"><?php echo $user['User']['name']?></a>
      <br class="clear">
      <div class="action-group" style="float: right;margin-top: -25px;">
     </div>
      <br class="clear">
    </li>
    <?php } } ?>

</ul>
<h3>Colleagues </h3>
<ul class="list-group">
    <?php foreach($group_user as $user){
        if($user['GroupUser']['user_type']==0){?>
  <li class="list-group-item">
      <a href="<?php echo Router::url(array('controller' => 'users','action'=>'profile',$user['User']['id'])) ?>"><?php echo $user['User']['name']?></a>
      <br class="clear">
      <div class="action-group" style="float: right;margin-top: -25px;">
     </div>
      <br class="clear">
    </li>
    <?php } } ?>

</ul>