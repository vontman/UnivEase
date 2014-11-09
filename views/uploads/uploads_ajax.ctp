
<?php
        echo $session->flash();
        echo '<li id="add_folder" style="display:none; ">'.$this->Html->image('folder_icon.png',array('width'=>'25px','height'=>'25px')).'Add New Folder</li>'; 
        if($folder_id!=0){
            echo '<li folder_id="'.$back_id.'" id="back_folder" style="display:none; ">'.$this->Html->image('folder_icon.png',array('width'=>'25px','height'=>'25px')).'back ...</li>';
        }
      foreach($folders as $upload){
          $upload=$upload['UploadFolder'];
        echo "<li style='display:none;'>".$this->Html->image('folder_icon.png',array('width'=>'50px','height'=>'50px')).$this->Html->link($upload['name'],'#uploadsTab',array('id'=>$upload['name'].$upload['id'],'class'=>'folder','folder_id'=>$upload['id'])).'</li><br>';
    }
      foreach($group['uploads'] as $upload){
        $upload=$upload['Upload'];
        if($upload['type']=='jpg' ||$upload['type']=='png' ||$upload['type']=='gif'  ){
        echo "<li style='display:none;'>".'<image style="max-width:50px;border:2px dashed;border-radius:5px;" src="/UnivEase/uploaded/groups/'.$upload['name'].'.'.$upload['type'].'"/>'.$this->Html->link($upload['name'],array('controller'=>'uploads','action'=>'download',$upload['id'])).'</li><br>';
        }else{
            echo "<li style='display:none;'>".$this->Html->image($upload['type'].'_icon.png',array('width'=>'50px')).$this->Html->link($upload['name'],array('controller'=>'uploads','action'=>'download',$upload['id']))."</li>";
        }
    }