<br>      
<div class="uploads"> 
        <?php echo $this->Form->create('Upload', array('type' => 'file','url'=>array('controller'=>'uploads','action'=>'add_upload'))); ?>
            <legend><?php __('Add Upload'); ?></legend>                       
            <?php echo $this->Form->input("name",array('required'));
            echo $this->Form->input("File",array('type'=>'file','id'=>'file_upload','required'));
            echo $this->Form->input('group_id',array('type'=>'hidden','value'=>$group_id));
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
                  $('#file_upload').change(function(){
                      files=$(this)[0].files;
                      console.log($(this).val());
                      $.each(files,function(k,file){
                        $.each(file,function(key,value){
                            console.log(key+':'+value);
                        });
                      });
                      $('#UploadName').val(files[0]['name']);
                  });
                  var group_id=$('#UploadGroupId').val();
                  var add_folder_toggle=false;
                  var counter=0;
                  var prev_folder=[0];
                  var selected_folder=0;
                  var url="<?php echo Router::url(array('controller'=>'uploads','action'=>'uploads_ajax',$group_id)); ?>/";
                  var last_url;
                  var type;
                  function load_uploads(selected_url){
                      $('#UploadFolderId').val(selected_folder);
                      selected_url=selected_url || last_url;
                      last_url=selected_url;
                     $('.uploads_view ul').children().slideUp('100',function(){$(this).remove();});
                     $.post(selected_url+'/'+prev_folder[counter],{
                            uploads_type:type},
                            function(data){
                                console.log(selected_url);
                                $(data).appendTo('.uploads_view ul').slideDown(100,function(){if($('#flashMessage').length){
                                        setTimeout(function(){$('#flashMessage').slideUp(1000);},3000);
                                    }
                                });
                            }
                        );
                  }
                  $('#uploadsTab a').click(function(){
                      type=$(this).attr('href');
                      load_uploads(url+type+'/0/');
                  });
                  $('.uploads_view ul').delegate('.folder','click',function(){
                      counter++;
                      prev_folder[counter]=selected_folder;
                      selected_folder=$(this).attr('folder_id');
                      load_uploads(url+type+'/'+selected_folder);
                  });
                  $('.uploads_view ul').delegate('#back_folder','click',function(){
                      counter--;
                      selected_folder=$(this).attr('folder_id');
                      load_uploads(url+type+'/'+selected_folder);
                  });
                  $('.uploads_view').click(function(){
                    setTimeout(function(){
                      if(!add_folder_toggle&&$('#add_folder_input').length){
                        $('#add_folder_input').parent().remove();
                      }
                      add_folder_toggle=false;
                    },100);
                  });
                  $('.uploads_view').delegate('#add_folder','click',function(){
                      setTimeout(function(){add_folder_toggle=true;},100);
                      if(!$('#add_folder_input').length){
                            $('.uploads_view ul').add('<li><input id="add_folder_input" type="text"/></li>');
                            $('<li><input id="add_folder_input" type="text"/></li>').insertAfter($(this));
                      }
                      $('.uploads_view ul input').focus();
                  });
                  $('.uploads_view ul').delegate('#add_folder_input','keypress',function(key){
                      if(key.which==13){
                          var name=$(this).val();
                          $.post("<?php echo Router::url(array('controller'=>'uploads','action'=>'add_folder',$group_id))?>/"+name+'/'+selected_folder,
                          {name:name},
                          function(){
                                setTimeout(function(){add_folder_toggle=false;},100);
                                load_uploads();
                            });
                        }
                  });
                  $('#uploadsTab a[href="all"]').trigger('click');

              </script>