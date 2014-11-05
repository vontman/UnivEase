
<?php

        echo '<h3>'.$type.'</h3>';
      foreach($group['uploads'] as $upload){
        $upload=$upload['Upload'];
        if($type=='img'){
        echo "<li style='display:none;'>".$this->Html->link($upload['name'],WWW_ROOT.'/UnivEase/uploads/groups/'.$upload['name'].'.'.$upload['type']).'<image style="max-width:120px;border:2px dashed;border-radius:5px;" src="/UnivEase/uploads/groups/'.$upload['name'].'.'.$upload['type'].'"/>'.'</li><br>';
        }else{
            echo "<li style='display:none;'>".$this->Html->link($upload['name'],WWW_ROOT.'/UnivEase/uploads/groups/'.$upload['name'].'.'.$upload['type'])."</li>";
        }
    }