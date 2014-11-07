<br>      
<div class="uploads"> 
        <?php echo $this->Form->create('Upload', array('type' => 'file','url'=>array('controller'=>'uploads','action'=>'add_upload'))); ?>
            <legend><?php __('Add Upload'); ?></legend>                       
            <?php echo $this->Form->input("name");
            echo $this->Form->input("File",array('type'=>'file','id'=>'file_upload'));
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
                  $('#file_upload').change(function(){
                      files=$(this)[0].files;
                      console.log($(this).val());
                      $.each(files,function(k,file){
                        $.each(file,function(key,value){
                            console.log(key+':'+value);
                        });
                      });
                  });
                  var counter=0;
                  var prev_folder=[0];
                  var selected_folder=0;
//                  var newfolder='<li id="add_folder" style="display:none; ">New Folder</li>';
                  var url="<?php echo Router::url(array('controller'=>'uploads','action'=>'uploads_ajax')); ?>/";
                  var last_url;
                  var type;
                  function load_uploads(selected_url){
                      selected_url=selected_url || last_url;
                      last_url=selected_url;
                     $('.uploads_view ul').children().fadeOut('100',function(){$(this).remove();});
                     $.post(selected_url+'/'+prev_folder[counter],{
                            uploads_type:type},
                            function(data){
                                console.log(selected_url);
//                                $(newfolder).appendTo('.uploads_view ul').fadeIn(100);
                                $(data).appendTo('.uploads_view ul').fadeIn(100);
//                                $(newfolder).insertAfter('.uploads_view ul h3').fadeIn(100);
                            }
                        );
                  }
                  $('#uploadsTab a').click(function(){
                      type=$(this).attr('href');
                      load_uploads(url+type+'/0/0/');
                  });
                  $('.uploads_view ul').delegate('.folder','click',function(){
                      counter++;
                      prev_folder[counter]=selected_folder;
                      selected_folder=$(this).attr('folder_id');
                      load_uploads(url+type+'/0/'+selected_folder);
                  });
                  $('.uploads_view ul').delegate('#back_folder','click',function(){
                      counter--;
                      selected_folder=$(this).attr('folder_id');
                      load_uploads(url+type+'/0/'+selected_folder);
                  });
                  $('#uploadsTab a[href="all"]').trigger('click');
                  $('.uploads_view').delegate('#add_folder','click',function(){
                      $('.uploads_view ul').add('<li><input id="add_folder_input" type="text"/></li>');
                      $('<li><input id="add_folder_input" type="text"/></li>').insertAfter($(this));
                      $('.uploads_view ul input').focus();
                  });
                  $('.uploads_view ul').delegate('#add_folder_input','keypress',function(key){
                      if(key.which==13){
                          var name=$(this).val();
                          $.post("<?php echo Router::url(array('controller'=>'uploads','action'=>'add_folder'))?>/"+name+'/0/'+selected_folder,
                          {name:name},
                          function(data){
                              if(data){
                                  load_uploads();
                                }
                            });
                        }
                  });

              </script>