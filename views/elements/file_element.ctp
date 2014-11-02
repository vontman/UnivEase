
<?php
//   debug($info);
if (isset($info['basename']) && isset($info['id'])) {
    ?>

    <div id="img-<?php echo $info['id'] ?>" >
        <p class="hint image_desc">File formats (<?php echo  implode(',', $info['extensions']) ?>)</p>
        <span class="image_base_name"><?php echo  $info['basename'] ?></span>
        <a href="<?php echo Router::url($info['full_path']); ?>" target="_blank" class="btn btn-small" ><i class="icon-search"></i></a>
        <a href="<?php echo Router::url(array('controller' => $info['controller'], 'action' => 'delete_field', $info['id'], $info['field'])) ?>"  class="btn btn-small"><i class="icon-trash"></i></a>
        <div class="clear"></div>
    </div>
    <?php
} else {
    ?>
    <p class="hint image_desc">File formats (<?php echo implode(',', $info['extensions']) ?>)</p> 
<?php }
?>