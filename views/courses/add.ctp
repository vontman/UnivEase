

<?php
if (!empty($this->data['Course']['id'])) {
    $title = __('Edit Course', true);
} else {
    $title = __('Add Course', true);
}
?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'view',$cuser['Course']['id'])) ?>"> <?php echo $cuser['Course']['name']; ?></a></li>
        <span class="divider"> / </span> 
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1><?php echo $title ?></h1>

<hr />

<?php echo $form->create('Course', array('type' => 'file')); ?>

<?php
//    debug($this->data);
echo $form->input('id');
echo $form->input('name');
echo $form->input('category_id', array('empty' => __('Select one', true)));
echo $fck->load('Course', 'description');
?>

<div id="Authors">
    <?php
    $section_count = 0;
//                debug($this->data['AssignmentFile']);
    if (!empty($levels)) {
        foreach ($levels as $j => $level) {
            //debug($level);
            ?>

            <div id='row<?php echo $j ?>' class="url-div">
                <?php
                echo $form->input('Level.' . $j . '.id', array('value' => $level['Level']['id']));
                echo $form->input('Level.' . $j . '.name', array('value' => $level['Level']['name']));
                echo $form->input('Level.' . $j . '.display_order', array('value' => $level['Level']['display_order']));
                ?>
                &nbsp;
                &nbsp<a href = '#' class = "delete-section2 btn btn-small" onClick = 'removeFormField("#row<?php echo $j ?>");
                        return false;'><i class="icon-remove"></i></a>
            </div>
            <?php
            $section_count++;
        }
    } else {
        ?>
        <div id='row0' class="url-div">
            <?php
//                echo $form->input('Author.0.id');
            echo $form->input('Level.' . 0 . '.name', array());
            echo $form->input('Level.' . 0 . '.display_order', array());
            ?>
        </div>
    <?php } ?>

</div>
<a href="#" class="add-author btn">
    <i class="icon-plus"></i> <?php echo __('Add Level') ?> </a>



<?php
echo $form->input('image', array('type' => 'file',
    'between' => $this->element('image_element', array('info' => !empty($this->data['Course']['image']) ? $this->data['Course']['image'] : '', 'field' => 'image'))));
echo $form->input('active', array('label' => false, 'after' => '</div>', 'before' => '<label>' . __('Active', true) . '</label><div class="switch" data-on-label="<i class=\'icon-ok icon-white\'></i>" data-off-label="<i class=\'icon-remove\'></i>">'));
?>
<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>

<?php echo $form->end(); ?>
<script type="text/javascript">

            var section_count = '<?php echo $section_count ?>';
            $('.add-author').live('click', function() {

                section_count++;

                x = '<?php echo $javascript->escapeString($form->input('Level.' . 0 . '.name', array())) ?>';
                x += '<?php echo $javascript->escapeString($form->input('Level.' . 0 . '.display_order', array())) ?>';
                x += '<a href="#" onClick=\'removeFormField("#row0"); return false;\' class="delete-section2 btn btn-small"><i class="icon-remove"></i></a>';




                y = x.replace(/Level0/g, 'Level' + section_count);
                y = y.replace(/row0/g, 'row' + section_count);
                y = y.replace(/\[Level]\[0\]/g, '[Level][' + section_count + ']');

                $('#Authors').append('<div class="url-div" id="row' + section_count + '">' + y + '</div>');
                $('#Authors').find('.url-div:last').find('input').val('');
                $('#Authors').find('.url-div:last').find('textarea').val('');
                $('#Authors').find('.url-div:last').find('input').attr('checked', false);


                return false;

            });

            function removeFormField(id) {
                $(id).remove();
            }
</script>
