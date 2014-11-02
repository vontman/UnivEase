<?php // debug($cuser);  ?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>

        <?php if (isset($cuser)) { ?>
            <span class="divider"> / </span>
            <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $cuser['Course']['id'])) ?>"> <?php echo $cuser['Course']['name'] ?></a></li>
            <span class="divider"> / </span>
            <li><a href="<?php echo Router::url(array('controller' => 'chats', 'action' => 'index', $cuser['Course']['id'], '?' => array('level' => $chat['Chat']['level']))) ?>"> <?php __('Chat sessions') ?></a></li>

        <?php } else { ?>
            <span class="divider"> / </span>
            <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view', $ccourse['Course']['id'])) ?>"> <?php echo $ccourse['Course']['name'] ?></a></li>
            <span class="divider"> / </span>
            <li><a href="<?php echo Router::url(array('controller' => 'chats', 'action' => 'index', $ccourse['Course']['id'], '?' => array('level' => $chat['Chat']['level']))) ?>"> <?php __('Chat sessions') ?></a></li>
        <?php } ?>
        <span class="divider"> / </span>
        <li class="active"><?php echo $chat['Chat']['name'] ?></li>
    </ul>
</div>
<h1><?php echo $chat['Chat']['name'] ?></h1>
<div id="iframe">
    <iframe  frameborder="0"  id="chat" src ="<?php echo Router::url(array('controller' => 'chats', 'action' => 'chat', $chat['Chat']['id'], 'admin' => false), true) ?>" name="chat" width="100%" height="700" scrolling="no" border="0" style="border:none 0px;" >
    <p>Your browser does not support iframes.</p>
    </iframe>
</div>

