<?php
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>


<h2><span><?php echo "<?php __('{$pluralHumanName}');?>" ?></span></h2>
<div class="module-table-body">
    <form action="<?php echo "<?php echo Router::url(array(\"action\" => \"do_operation\")) ?>"?>" id="forn" method="post">



        <table cellpadding="0" cellspacing="0">
            <tr>
                <?php foreach ($fields as $field):
                    if ($field == 'id') { ?>
                        <th><input type="checkbox" id="check_all" /></th>
                        <th><?php echo "<?php echo \$paginator->sort('{$field}');?>"; ?></th>
                    <?php } if ($field == 'name' || $field == 'title' || $field == 'ar_name' || $field == 'ar_title') {
                        ?>
                        <th><?php echo "<?php echo \$paginator->sort('{$field}');?>"; ?></th>
                    <?php } endforeach; ?>
                <th class="actions"><?php echo "<?php __('Actions');?>"; ?></th>
            </tr>
            <?php
            echo "<?php
	\$i = 0;
	foreach (\${$pluralVar} as \${$singularVar}):
		\$class = null;
		if (\$i++ % 2 == 0) {
			\$class = ' class=\"altrow\"';
		}
	?>\n";
            echo "\t<tr<?php echo \$class;?>>\n";
            foreach ($fields as $field) {
                $isKey = false;

                if ($field == 'id') {
                    ?>
                    <td>
                        <input  type="checkbox" name="chk[]" value="<?php echo "<?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>"; ?>" />
                    </td>
                    <?php echo "\t\t<td>\n\t\t\t<?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\n\t\t</td>\n"; ?>
                    <?php
                } elseif ($field == 'name' || $field == 'title' || $field == 'ar_name' || $field == 'ar_title') {
                    echo "\t\t<td>\n\t\t\t<?php echo \${$singularVar}['{$modelClass}']['{$field}']; ?>\n\t\t</td>\n";
                }


/*                if (!empty($associations['belongsTo'])) {
//                    foreach ($associations['belongsTo'] as $alias => $details) {
//                        if ($field === $details['foreignKey']) {
//                            $isKey = true;
//                            echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
//                            break;
//                        }
//                    }
                } */
               
            }

            echo "\t\t<td class=\"actions\">\n";
            echo "\t\t\t<?php echo \$html->link(__('Edit', true), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('class'=>'Edit')); ?>\n";
            echo "\t\t\t<?php echo \$html->link(__('Delete', true), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class'=>'Delete'), sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
            echo "\t\t</td>\n";
            echo "\t</tr>\n";
            echo "<?php endforeach; ?>\n";
            ?>
        </table>


        <div class="pagination">
            <?php echo "\t <?php if(\$paginator->numbers()){
            \n\t if (\$paginator->hasNext()) { ?> 
            \n\t" ?>
            <div class="button"><span> 

                    <?php echo "\t<?php echo \$paginator->next(__('Next', true), array(), null, array('class' => 'disabled'));?>\n  "; ?>
                    <img height="9" width="12" alt="Previous" src="<?php echo'<?php echo Router::url("/img/admin/arrow-180-small.gif") ?>' ?>">


                </span>
            </div>
            <?php echo "<?php } ?>"; ?>
            <div class="numbers"> 
                <?php echo "\t<?php echo \$paginator->numbers(array('separator'=>' | '));?>\n" ?>
            </div>
            <?php echo "\n\t <?php if (\$paginator->hasPrev()) { ?>" ?>
            <div class="button" >
                <span>
                    <img height="9" width="12" alt="Next"  src="<?php echo "<?php echo Router::url(\"/img/admin/arrow-000-small.gif\")?>"; ?>" />
                    <?php echo "\t <?php echo \$paginator->prev(__('Previous', true), array(), null, array('class'=>'disabled'));?>\n"; ?>


                </span>
            </div>
            <?php echo "<?php } ?>" ?>
            <?php echo "\t\t<?php }?>"; ?>
        </div>

        <div class="table-apply">
            <div>
                <span><?php echo '<?php echo __("Choose Operation")?>'; ?></span> 
                <select class="input-medium" id="acts" name="operation" style="width:auto;">
                    <option value="">
                        <?php echo '<?php echo __("Choose Operation")?>'; ?></option>
                    <option value="delete"><?php echo '<?php echo __("Delete")?>'; ?></option>
                </select>
            </div>

        </div>
    </form>
    <script type="text/javascript">
        $("#check_all").live('click',function(){
            if($(this).prop('checked')==true)
            {
                $('input[name="chk[]"]').prop('checked',true);
            }else{
                $('input[name="chk[]"]').prop('checked',false);
            }
	
        });
        $(document).ready(function(){
            $("#acts").change(function(){
                action=$(this).val();
                if(action!="")
                {
                    if($('input[name="chk[]"]:checked').length==0)
                    {
                        alert("<?php echo "<?php echo __('You must choose on element at least'); ?>"; ?>");
                        $(this).val('');
                    }else{
			
                        del=confirm("<?php echo "<?php echo __('Are you sure you want to perform this process?'); ?>"; ?>");
                        if(del)
                        {
                            $('#forn').submit();
                            $(this).val('');
                        }else{
                            $(this).val('');
                        }
                    }
	
                }
            });
        });
    </script>
</div>


