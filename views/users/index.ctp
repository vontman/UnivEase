<!-- For print -->
<style>
    @media print {
    .print {
        background-color: white;
        height: 100%;
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        margin: 0;
        padding: 15px;
        font-size: 14px;
        line-height: 18px;
    }
}
    
</style>
<script>
function printdiv(el)
{
var restorepage=document.body.innerHTML;
var printcontent=document.getElementById(el).innerHTML;
document.body.innerHTML=printcontent;
window.print();
document.body.innerHTML=restorepage;

}
</script>


<!-- End print -->

<h1><?php echo __('Users', true) ?></h1>

<hr />

<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
               
                <th><?php echo $paginator->sort('id'); ?></th>
                <th><?php echo $paginator->sort('name'); ?></th>
                

            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($users as $users):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
             
                <td>
                    <?php echo $users['User']['id']; ?>
                </td>
                <td>
                    
                    <a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'check_password',$users['User']['username'])) ?>"> <?php echo $users['User']['name']; ?></a>
                   
                </td>

       
            </tr>
        <?php endforeach; ?>
    </table>


    <div class="pagination">
        <ul>
            <?php
            if ($paginator->numbers()) {

                if ($paginator->hasNext()) {
                    ?> 
                    <?php echo $paginator->next(__('Next', true), array('tag' => 'li'), null, array('class' => 'disabled')); ?>
                <?php } ?> 


                <?php echo $paginator->numbers(array('tag' => 'li', 'separator' => '')); ?>


                <?php if ($paginator->hasPrev()) { ?>

                    <?php echo $paginator->prev(__('Previous', true), array('tag' => 'li'), null, array('class' => 'disabled')); ?>

                <?php } ?>            		
            <?php } ?> 
        </ul>
    </div>


</form>



<!-- start print-->
<div id="print" style="display: none;">
    
<form action="<?php echo Router::url(array("action" => "do_operation")) ?>" id="forn" method="post">
    <table class="table table-bordered messages-list  mailinbox">
        <thead>
            <tr>
                <th><?php  __('id'); ?></th>
                <th><?php __('name'); ?></th>
         

            </tr>
        </thead>
        <?php
        $i = 0;
        foreach ($userss as $users):
            $class = null;
            if ($i++ % 2 == 0) {
                $class = ' class="altrow"';
            }
            ?>
            <tr<?php echo $class; ?>>
               
                <td>
                    <?php echo $users['User']['id']; ?>
                </td>
                <td>
                    <?php echo $users['User']['name']; ?>
                </td>
            

                
            </tr>
        <?php endforeach; ?>
    </table>




</form>
</div>


<!-- End print-->
<script type="text/javascript">
    $("#check_all").live('click', function() {
        if ($(this).prop('checked') == true)
        {
            $('input[name="chk[]"]').prop('checked', true);
        } else {
            $('input[name="chk[]"]').prop('checked', false);
        }

    });
    $(document).ready(function() {
        $("#acts").change(function() {
            action = $(this).val();
            if (action != "")
            {
                if ($('input[name="chk[]"]:checked').length == 0)
                {
                    alert("<?php echo __('You must choose on element at least'); ?>");
                    $(this).val('');
                } else {

                    del = confirm("<?php echo __('Are you sure you want to perform this process?'); ?>");
                    if (del)
                    {
                        $('#forn').submit();
                        $(this).val('');
                    } else {
                        $(this).val('');
                    }
                }
            }
        });
    });
</script>



