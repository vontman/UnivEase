<?php
echo $this->Form->create('Groups');
echo $this->Form->input("name");
echo $this->Form->input('description');
echo $this->Form->input('course_id');
echo $this->Form->end('Add Group');