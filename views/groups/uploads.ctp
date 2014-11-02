      <div class="uploads"> 
                <?php echo $this->Form->create('Upload', array('type' => 'file','url'=>array('controller'=>'groups','action'=>'group_upload'))); ?>
                    <legend><?php __('Add Upload'); ?></legend>                       
                    <?php echo $this->Form->input("name");
                    echo $this->Form->input("File",array('type'=>'file'));
                    echo $this->Form->input('group_id',array('type'=>'hidden','value'=>$group['Group']['id']));
                echo $this->Form->end("Upload");?>
            <h3>PDFs</h3>
                <ul>
                    <?php
                        foreach($group['uploads']['pdf'] as $upload){
                            $upload=$upload['Upload'];
                            echo "<li>".$this->Html->link($upload['name'].".".$upload['type'],WWW_ROOT . 'uploads/groups' . DS .$upload['name'].'.'.$upload['type'])."</li>";
                        }
                    ?>
                </ul>
            <h3>Images</h3>                    
                <ul>
                    <?php
                        foreach($group['uploads']['img'] as $upload){
                            $upload=$upload['Upload'];
                            echo "<li><img height=120 src='".WWW_ROOT . 'uploads/groups' . DS .$upload['name'].'.'.$upload['type']."'>".$this->Html->link($upload['name'].".".$upload['type'],WWW_ROOT . 'uploads/groups' . DS .$upload['name'].'.'.$upload['type'])."</li>";
                        }
                    ?>
                </ul>
            </div>