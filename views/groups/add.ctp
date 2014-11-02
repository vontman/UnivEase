<?php
echo $this->Form->create('Group');
echo $this->Form->input("name");
echo $this->Form->input('description');
echo $this->Form->input("course_id",array('empty'=>__('Select Course',true)));
echo $this->Form->end('Add Group');