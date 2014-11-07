<br>      
<div class="uploads"> 
        <?php echo $this->Form->create('Upload', array('type' => 'file','url'=>array('controller'=>'uploads','action'=>'add_upload'))); ?>
            <legend><?php __('Add Upload'); ?></legend>                       
            <?php echo $this->Form->input("name");
            echo $this->Form->input("File",array('type'=>'file'));
            echo $this->Form->input('group_id',array('type'=>'hidden','value'=>0));
            echo $this->Form->input('folder_id',array('type'=>'hidden','value'=>0));
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

              <ul>
              </ul>
          </div>

            </div>
              <script>
                  var selected_folder=0;
                  var newfolder='<li id="add_folder" style="display:none; folder_id='+selected_folder+' ">New Folder</li>';
                  var url="<?php echo Router::url(array('controller'=>'uploads','action'=>'uploads_ajax')); ?>/";
                  var type;
                  function load_uploads(selected_url){
                     $('.uploads_view ul').children().hide('150',function(){$(this).remove();});
                     $.post(selected_url,{
                            uploads_type:type},
                            function(data){
                                console.log(selected_url);
                                $(newfolder).appendTo('.uploads_view ul').show(100);
                                $(data).appendTo('.uploads_view ul').show(100);
                            }
                        );
                  }
                  $('#uploadsTab a').click(function(){
//                      $('.uploads_view ul').children().hide('150',function(){$(this).remove();});
//                     type=$(this).attr('href');
//                     $.post(url+type+'/0/0/',{
//                            uploads_type:type},
//                            function(data){
//                                $(newfolder).appendTo('.uploads_view ul').show(100);
//                                $(data).appendTo('.uploads_view ul').show(100);
//                            }
//                        );
                      type=$(this).attr('href');
                      load_uploads(url+type+'/0/0/');
                  });
                  $('.uploads_view ul').delegate('.folder','click',function(){
//                     $('.uploads_view ul').children().hide('150',function(){$(this).remove();});
//                     selected_folder=$(this).attr('folder_id');
//                     $.post(url+type+'/0/'+selected_folder,{
//                            uploads_type:type},
//                            function(data){
//                                $(newfolder).appendTo('.uploads_view ul').show(100);
//                                $(data).appendTo('.uploads_view ul').show(100);
//                            }
//                        );
                      selected_folder=$(this).attr('folder_id');
                      load_uploads(url+type+'/0/'+selected_folder);
                  });
                  $('#uploadsTab a[href="all"]').trigger('click');
                  $('.uploads_view').delegate('#add_folder','click',function(){
                      $('.uploads_view ul').prepend('<li><input id="add_folder_input" type="text"/></li>');
                      $('.uploads_view ul input').focus();
                  });
                  $('.uploads_view ul').delegate('#add_folder_input','keypress',function(key){
                      if(key.which==13){
                          var name=$(this).val();
                          var selected=$(this).parent();
                          $.post("<?php echo Router::url(array('controller'=>'uploads','action'=>'add_folder'))?>/"+name+'/0/'+selected_folder,
                          {name:name},
                          function(data){
                              if(data){
                                  selected.hide(100,function(){
                                    selected.remove();
                                  });
                                }
                            });
                        }
                  });

              </script>