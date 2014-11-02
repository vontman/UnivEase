<?php
if (!empty($this->data['User']['id'])) {

    $title = __('Edit User', true);
} else {

    $title = __('Add User', true);
}
?> 

<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'index')) ?>"><?php __('Users') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<h1>
<?php echo $title?>
</h1>


<?php echo $form->create('User', array('type' => 'file')); ?>

<?php
//    debug($this->data);
echo $form->input('id');
echo $form->input('name');
echo $form->input('username');
echo $form->input('password');
echo $form->input('passwd', array('label' => __('Re-enter password', true)));
echo $form->input('email');
echo $form->input('telephone');
echo $form->input('mobile');
echo $form->input('address');
echo $form->input('nationality');
 echo $form->input('type', array('type' => 'select',"options"=>array("1"=>"teacher ","2"=>"student"))); 
 if (empty($this->data['User']['id'])) {
echo $form->input('students', array('multiple' => true, 'label' =>__('Course', true),'type' => 'select', 'data-placeholder' => __("Choose a course", true), 'style' => "width:415px;", 'class' => "chzn-select chzn-rtl"));
 }
echo $form->input('birth_date', array('type' => 'text', 'class' => 'hasDate'));
echo $form->input('approved', array('label' => false, 'after' => '</div>', 'before' => '<label>' . __('Approved', true) . '</label><div class="switch" data-on-label="<i class=\'icon-ok icon-white\'></i>" data-off-label="<i class=\'icon-remove\'></i>">'));
?>
<div class = "input text">
    <label><?php __('Image'); ?></label>
    <?php
   echo $form->input('image', array('type' => 'file','label'=>false,
        'between' => $this->element('image_element', array('info' => !empty($this->data['User']['image']) ? $this->data['User']['image'] : '', 'field' => 'image'))));
    ?> 
</div>

<div class="form-actions">
    <?php
    echo $form->submit('Submit', array('class' => 'btn btn-primary'));
    ?>
</div>
<?php echo $form->end(); ?>



<?php
echo $javascript->link(array('jquery-ui-1.8.24.custom.min', 'jquery-ui-sliderAccess', 'jquery-ui-timepicker-addon', 'chosen.jquery'));
echo $html->css(array('jquery-ui-1.8.24.custom', 'datetimepicker', 'chosen'));



?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
            changeYear: true});
        change_students();
    });
    $('.hasDate').live('focus', function() {
        $('.hasDate').datepicker({"dateFormat": 'yy-mm-dd', changeMonth: true,
            changeYear: true});
    })
    
    
    //get courses
    function change_students()
    {
        
      
        $.ajax({
            async: true,
            type: "GET",
            url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'get_all_courses', 'admin' => false)) ?>",
            dataType: "json",
            
            success: function(data) {
                
                $('#UserStudents').html('');
                if (data.submenus.length != 0) {
                    for (var i = 0; i < data.submenus.length; i++)
                    {
                        var submenu = data.submenus[i];
                        var is_Selected = "";
                        selected_submenu = [<?php !empty($this->data['User']['students']) ? print(implode(',', $this->data['User']['students']))  : ''; ?>];
                        if (selected_submenu.indexOf(parseInt(submenu.Course.id)) != -1)
                        {
                            is_Selected = "selected=selected";
                        }
                        $('#UserStudents').append('<option value="' + submenu.Course.id + '"' + is_Selected + '>' + submenu.Course.name + '</option>');
                    }
                    document.getElementById('UserStudents').disabled = false;

                    //                    $('#UserStudents').chosen({no_results_text: "<?php __("No results matched") ?>",width:'415px;'});
                    $("#UserStudents").trigger("liszt:updated");

                } else {
                    document.getElementById('UserStudents').disabled = false;
                    //                    $('#UserStudents').chosen({no_results_text: "<?php __("No results matched") ?>"});
                    $("#UserStudents").trigger("liszt:updated");

                }

                return false;
            }

        });
    }
    
    $('#UserSections').chosen({no_results_text: "<?php __("No results matched") ?>", width: '415px'});
    $('#UserStudents').chosen({no_results_text: "<?php __("No results matched") ?>", width: '415px'});
    
    
</script>