<div class="row down-row">
        <nav class="navbar navbar-default navbar-fixed-top down-nav " role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#collapse">
                    <span class="sr-only">toggle navigation </span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>

                </button>
            </div>
            <div class="container">
                <div class="collapse navbar-collapse" id="collapse">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="<?php echo Router::url(array('controller' => 'users','action'=>'profile')) ?>">User name</a></li>
                        <li><a href="#">Edit</a></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'friends','action'=>'friend')) ?>">Friends</a></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'friends','action'=>'request')) ?>">request</a></li>
                        
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <br class="clear">
<?php 
if($category!=0){
    if(!empty($category)){
echo $form->create('User', array('type' => 'post','action' =>'submit_categ')); 
    
         echo $this->Form->input('category_id', array('id'=>'UsercourseId','options'=> $category));
    
    
echo '<div class="form-actions">';

echo $form->submit('Submit', array('class' => 'btn btn-primary'));

echo "</div>";

 echo $form->end(); 
 }
}else{
    if(!empty($courses)){
  echo $form->create('User', array('type' => 'post','action' =>'submit_courses')); 
    
         echo $this->Form->input('course_id', array('id'=>'UsercourseId','options'=> $courses));
    
    
echo '<div class="form-actions">';

echo $form->submit('Submit', array('class' => 'btn btn-primary'));

echo "</div>";

 echo $form->end();   
 }
}