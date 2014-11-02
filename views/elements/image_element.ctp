<?php
//debug($field);
if (isset($info) && !empty($info['basename'])) {
    ?>
    <div id="img-<?php echo $info['id'] ?>" >
        <?php if (!empty($info['dimensions'])) { ?>
            <p class="hint image_desc">Image size <?php echo  $info['dimensions'] ?>   </p>
    <?php } ?>
        <span class="image_base_name"><?php echo  $info['basename'] ?></span>
        <a href="<?php echo Router::url($info['path']); ?>" target="_blank" class="btn btn-small" ><i class="icon-search"></i></a>
        <a href="<?php echo Router::url(array('controller' => $info['controller'], 'action' => 'delete_field', $info['id'], $field)) ?>"  class="btn btn-small"><i class="icon-trash"></i></a>
        <div class="clear"></div>
    </div>
    <?php
}
?>