
<?php
        echo '<h3>'.$type.'</h3>'; 
      foreach($folders as $upload){
          $upload=$upload['UploadFolder'];
        echo "<li style='display:none;'>".$this->Html->image('folder_icon.png',array('width'=>'50px','height'=>'50px')).$this->Html->link($upload['name'],'#'.$upload['name'].$upload['id'],array('id'=>$upload['name'].$upload['id'],'class'=>'folder','folder_id'=>$upload['id'])).'</li><br>';
    }
      foreach($group['uploads'] as $upload){
        $upload=$upload['Upload'];
        if($upload['type']=='jpg' ||$upload['type']=='png' ||$upload['type']=='gif'  ){
        echo "<li style='display:none;'>".'<image style="max-width:50px;border:2px dashed;border-radius:5px;" src="/UnivEase/uploaded/groups/'.$upload['name'].'.'.$upload['type'].'"/>'.$this->Html->link($upload['name'],WWW_ROOT.'/UnivEase/uploaded/groups/'.$upload['name'].'.'.$upload['type']).'</li><br>';
        }else{
            echo "<li style='display:none;'>".$this->Html->image($upload['type'].'_icon.png',array('width'=>'50px')).$this->Html->link($upload['name'],WWW_ROOT.'/UnivEase/uploaded/groups/'.$upload['name'].'.'.$upload['type'])."</li>";
        }
    }