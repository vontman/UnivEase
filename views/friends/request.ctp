<ul class="list-group">
    <?php foreach($requests as $request){?>
  <li class="list-group-item">
      <a href="<?php echo Router::url(array('controller' => 'users','action'=>'profile',$request['User']['id'])) ?>"><?php echo $request['User']['name']?></a>
      <br class="clear">
      <div class="action-group" style="float: right;margin-top: -25px;">
      <a  class="btn btn-success" href="<?php echo Router::url(array('controller' => 'friends','action'=>'accept',$request['Friend']['id'])) ?>">Accept</a>
      <a class="btn btn-danger" href="<?php echo Router::url(array('controller' => 'friends','action'=>'reject',$request['Friend']['id'])) ?>">Reject</a>
      </div>
      <br class="clear">
      </li>
    <?php } ?>

</ul>