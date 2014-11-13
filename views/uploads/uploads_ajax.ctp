
<?php
        echo $session->flash();
        echo '<tr id="add_folder" style="display:none; "><td>'.$this->Html->image('folder_icon.png',array('width'=>'25px','height'=>'25px')).'Add New Folder</td></tr>'; 
        if($folder_id!=0){
            echo '<tr folder_id="'.$back_id.'" id="back_folder" style="display:none; "><td>'.$this->Html->image('folder_icon.png',array('width'=>'25px','height'=>'25px')).'back ...</td></tr>';
        }
      foreach($folders as $upload){
          $upload=$upload['UploadFolder'];
        echo "<tr style='display:none;'><td>".$this->Html->image('folder_icon.png',array('width'=>'50px','height'=>'50px')).$this->Html->link($upload['name'],'#uploadsTab',array('id'=>$upload['name'].$upload['id'],'class'=>'folder','folder_id'=>$upload['id'])).'</td></tr><br>';
    }
      foreach($group['uploads'] as $upload){
        $upload=$upload['Upload'];
        if($upload['type']=='jpg' ||$upload['type']=='png' ||$upload['type']=='gif'  ){
            if($group_id==0){
                echo "<tr style='display:none;'><td>".$this->Html->image('uploaded_icons/users' . DS . $upload['user_id'] . DS .$upload['fileid'].".".$upload['type'],array('width'=>'50px')).$this->Html->link($upload['name'],array('controller'=>'uploads','action'=>'download',$upload['id'])).'</td></tr><br>';
            }else{
                echo "<tr style='display:none;'><td>".$this->Html->image('uploaded_icons/groups' . DS . $upload['group_id'] . DS .$upload['fileid'].".".$upload['type'],array('width'=>'50px')).$this->Html->link($upload['name'],array('controller'=>'uploads','action'=>'download',$upload['id'])).'</td></tr><br>';
            }
        }else{
            echo "<tr style='display:none;'><td>".$this->Html->image($upload['type'].'_icon.png',array('width'=>'50px')).$this->Html->link($upload['name'],array('controller'=>'uploads','action'=>'download',$upload['id']))."</td></tr>";
        }
    }