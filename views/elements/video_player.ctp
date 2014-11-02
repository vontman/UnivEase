<?php
$width = empty($width) ? 550 : $width;
$height = empty($height) ? 310 : $height;
$autoPlayer = empty($autoPlayer) ? false : true;
$thumb_image = empty($video['image']) ? '' : get_resized_image_url($video['image'], $width, $height);
$style = "display:block;width:{$width}px;height:{$height}px;";
$play_btn = '';
if (empty($autoPlayer) && !empty($thumb_image)) {
    $style.="background-image: url('$thumb_image');text-align: center;";
    $margin_top = ($height / 2) - 20;
    $play_btn = "<img src='" . $play_img . "' style='cursor: pointer;margin-top: {$margin_top}px;'/>";
}
echo $javascript->link(
        array('jquery-1.8.2.min', 'flowplayer/flowplayer-3.2.9.min')
);
?>
<?php
$rand_number = time() . "_" . rand(1, 1000);
?>
<a href="<?php echo $file ?>" style="<?php echo $style ?>" class="PlayerVideo content-video">
    <?php echo $play_btn ?>
</a>

<script type="text/javascript">
    $('document').ready(function(){
        flowplayer("a.PlayerVideo",{wmode: "transparent",src: "<?php echo Router::url('/js/flowplayer/flowplayer-3.2.9.swf', true) ?>"},{
            clip: {
                autoPlay: false,
                autoBuffering: true
            }
        } );
    });
</script>