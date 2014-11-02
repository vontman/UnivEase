<?php if (!empty($info)) { ?>
    <div id="img-<?php echo $info['id'] ?>" >
        <?php if (!empty($info['dimensions'])) { ?>
            <p class="hint image_desc">Image size <?= $info['dimensions'] ?>   </p>
        <? } ?>
        <span class="image_base_name"><?= $info['basename'] ?></span>
        <a href="<?php echo Router::url($info['path']); ?>" target="_blank" class="Preview" ><?php __("Preview") ?></a>
        <a href="<?php echo Router::url(array('action' => 'delete_field', $info['id'], 'image')) ?>"  class="Delete"><?php __("Delete") ?></a>
        <div class="clear"></div>
    </div>
    <?php
}
?>