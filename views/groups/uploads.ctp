<br>      
<div class="uploads"> 
        <?php echo $this->Form->create('Upload', array('type' => 'file','url'=>array('controller'=>'groups','action'=>'group_upload'))); ?>
            <legend><?php __('Add Upload'); ?></legend>                       
            <?php echo $this->Form->input("name");
            echo $this->Form->input("File",array('type'=>'file'));
            echo $this->Form->input('group_id',array('type'=>'hidden','value'=>$id));
        echo $this->Form->end("Upload");?>
          <br>      <br>        
            
        <ul class="nav nav-tabs" style="margin-left:0;" id="uploadsTab">
            <li class="active"><a  data-toggle="tab" href="all" >All</a></li>
            <li><a data-toggle="tab" href="pdf">Pdfs</a></li>
            <li><a data-toggle="tab" href="img">Images</a></li>
            <li><a data-toggle="tab" href="doc">Documents</a></li>
            <li><a data-toggle="tab" href="ppt">Slides</a></li>
            </li>
        </ul>
          <div class="uploads_view">
              <script>
                  $('#uploadsTab a').click(function(){
                      $('.uploads_view ul').children().hide('100',function(){$(this).remove();})
                     var type=$(this).attr('href');
                     $.post("<?php echo Router::url(array('controller'=>'groups','action'=>'uploads_ajax',$id)); ?>/"+type,{
                            type:type},
                            function(data){
                                $(data).appendTo('.uploads_view ul').show(100);
                            }
                        );
                  });
                  $('#uploadsTab a[href="all"]').trigger('click');
              </script>
              <ul>

              </ul>
          </div>

            </div>