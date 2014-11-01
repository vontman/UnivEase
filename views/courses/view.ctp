<?php

//session_start();
  $u=$_SESSION['user'];
  if(empty($u)){
      $u=$_SESSION['admin'];
  }
  $cc="";
?>
<script>
    $(document).ready(function() {
//       $(".password a").on('click',function(event){
//           event.preventDefault();
//           var url=$(this).attr("href");
//           var pass=window.prompt("Please Enter Security Code.");
//           if((pass==false)||(pass=='')||(pass==null)){
//               alert("Security Code Could not be empty");
//           }else{
//                $.ajax({
//                    url: "<?php echo Router::url(array('controller'=>'scodes','action'=>'find')); ?>",
//                    type: "POST",
//                    data: {
//                      pass:pass,
//                      c_id:"<?php // echo $user['Course']['id'];?>",
//                      u_id:"<?php echo $u['id'];?>"
//                    },
//                    success:function(data){
//                       if(data=="ok"){
//                          window.location.href=url;
//                       }else{
//                           alert("Security Code is wrong.");
//                       }    
//                    },
//                    error: function(){
//                        alert("error")
//                    }
//                })
//           }
//       });
//       
//   })
</script>

<?php // echo date('Y-m-d h:i:s');  ?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $user['Course']['name'] ?></li>
    </ul>
</div>
<h1>
    <?php
    echo $course['Course']['name'];
    ?>
</h1>


<div class="msghead">
    <ul class="msghead-menu">
        <?php if (isset($user['Group']['allowed_permissions'][7])) { ?>
                            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
        <a class="btn" href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'edit', $cuser['CourseUser']['course_id'])) ?>"> 
                <?php __('Edit') ?>
            <i class="icon-pencil"></i>
        </a>


                                    <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->



                                    <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
        <a class="btn" href="<?php echo Router::url(array('controller' => 'sections', 'action' => 'index', $cuser['CourseUser']['course_id'])) ?>"> 
                <?php __('Sections') ?>
            <i class="icon-cog"></i>
        </a>
        <?php } ?>
        <a class="btn" href="<?php echo Router::url(array('controller' => 'course_users', 'action' => 'index', $cuser['CourseUser']['course_id'])) ?>"> 
            <?php __('View participants') ?>
            <i class="icon-search"></i>
        </a>

		 <?php if (isset($user['Group']['allowed_permissions'][20])) { ?>
        <a class="btn" href="<?php echo Router::url(array('controller' => 'attendances', 'action' => 'index', $course['Course']['id'])) ?>"> 
                <?php __('Attendance') ?>
            <i class="icon-folder-open"></i>
        </a>
        <a class="btn" href="<?php echo Router::url(array('controller' => 'icons', 'action' => 'index', $course['Course']['id'])) ?>"> 
                <?php __('Icons Visibilty') ?>
            <i class="icon-cog"></i>
        </a>
      <?php } ?>

    </ul>
    <span class="clearall"></span> 
</div>


<hr />
<div class="content-section">
    <?php echo $course['Course']['description'] ?>
</div>
<div id="timeline" class="timeline">
    <div id="timeline" class="timeline-item">    
        <h3><a href="#level" data-toggle="collapse" data-target="#level" ><span class="timeline-icon"><i></i></span><?php __("Exams & Evaluations") ?></a>
        </h3>
 <?php  if (!empty($levels)) {
                                        
        ?>


        <div class="items accordion-body collapse  " id="level<?php  ?>">
            <ul>

                <li style="display:<?php echo $cc;?>" class="password"><a href="<?php echo Router::url(array('controller' => 'exams',
                                'action' => 'index', $course['Course']['id'])) ?>" class="item-audio">

                    <?php     foreach ($levels as $key => $level) {?>
                                    <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='exam')&&($add['Add']['counts']!=0)){
                                     ?>
                                    <?php //echo $add['Add']['counts'];
                                             if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                           <?php  echo $counts[$add['Add']['id']]; ?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                    } ?>
                        <span class="symp-pen" aria-hidden="true"></span></a><?php __('Exams') ?></li>
                                   <?php 

            if ($key == 0) {
                $class = '';
            } else {
                $class = 'in';
            }
                     foreach ($levels as $key => $level) {
                               $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="surveys")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="surveys")){
                                       $cc="";
                                   }
                               }
                    endforeach; }
                        ?>    
                        
                                
                                <!-- ###################Discussion ###################-->
                           
                                    
 <?php
 
 if ($discs === -1 || (isset($discs['Discussion']['id']) && !empty($discs['Discussion']['id']))) {  ?> 
                        <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'discussions', 'action' => 'index', 
                                $course['Course']['id'])) ?>"
                                                         class="item-events"><span class="symp-info" aria-hidden="true">
 </span></a><?php __('Discussion')?></li>
 <?php } ?>
                               
                                
                                <!-- ###################Survey ###################-->
                           
                                    
                                    <?php if ($surveys === -1 || (isset($surveys[$course['Course']['id']]) && !empty($surveys[$course['Course']['id']]))) { ?> 
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'surveys', 'action' => 'index', 
                                $course['Course']['id'])) ?>"
                                                         class="item-events"><span class="symp-info" aria-hidden="true">
                        </span></a><?php __('Surveys') ?></li>


                 <?php 
                 foreach ($levels as $key => $level) {
                
                   $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="events")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="events")){
                                       $cc="";
                                   }
                               }
                 endforeach; }
                
               if ($events === -1 || (isset($events[$course['Course']['id']]) && !empty($events[$course['Course']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'events',
                                'action' => 'index', $course['Course']['id'])) ?>" class="item-download">
<?php foreach ($levels as $key => $level) {
                                    
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='event')&&($add['Add']['counts']!=0)){
                                     ?>
                                     <?php //echo $add['Add']['counts'];
                                             if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                       <?php      echo $counts[$add['Add']['id']]; ?>

                        </div>
                                <?php
                                             }
                                    }
endforeach; }
                                ?> 
                        <span class="symp-calendar" aria-hidden="true"></span></a><?php __('Events') ?></li>

                        <?php }?>
                                     <?php
                                     foreach ($levels as $key => $level) {
                                 $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="announcements")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="announcements")){
                                       $cc="";
                                   }
                               }
                                     endforeach; }
                        ?> 
                        <?php  if ($announcements === -1 || (isset($announcements[$level['Level']['id']]) && !empty($announcements[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>">
                    <a href="<?php echo Router::url(array('controller' => 'announcements', 'action' => 'index'
                              ,$course['Course']['id']))?> "class="item-imgs" >
                        <div class="ann-notify"> 
                                        <?php 
                                            if (!empty($announces_cnt[$level['Level']['id']]))
                                                { echo $announces_cnt[$level['Level']['id']]; }
                                            else { echo '0';}
                                        ?> 
                        </div> 
                        <span class="symp-profile" aria-hidden="true"></span>
                    </a>
                                <?php __('Announcements') ?>
                </li> 
                        <?php } ?>

            </ul>


                        <?php }
                        
                        
                        
                                            }
                        ?>


        </div>


    </div>
<br>
    <hr />
<br><br>
    <?php
    if (!empty($levels)) {
        foreach ($levels as $key => $level) {

            if ($key == 0) {
                $class = '';
            } else {
                $class = 'in';
            }
            ?>
    <div id="timeline" class="timeline-item">
        <h3><a href="#level<?php echo $level['Level']['id'] ?>" data-toggle="collapse" data-target="#level<?php echo $level['Level']['id'] ?>"><span class="timeline-icon"><i></i></span><?php echo $level['Level']['name']; ?></a>
                    <?php if (isset($cuser['Group']['allowed_permissions'][7])) { ?>
            <a href="<?php echo Router::url(array('controller' => 'levels', 'action' => 'edit', $level['Level']['id'])) ?>" class="btn btn-small"><i class="icon-edit"></i></a>
            <a href="<?php echo Router::url(array('controller' => 'levels', 'action' => 'delete', $level['Level']['id'])) ?>" class="btn btn-small" onclick="javascript
                        :return confirm('<?php echo sprintf(__('Are you sure you want to delete %s?', true), $level['Level']['name']) ?>');"><i class="icon-remove"></i></a>
                    <?php } ?>
        </h3>

        <div class="items accordion-body collapse  <?php echo $class ?>" id="level<?php echo $level['Level']['id'] ?>">
            <ul>
                        <?php 
                          $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="assignments")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="assignments")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>
                          <?php if ($assignments === -1 || (isset($assignments[$level['Level']['id']]) && !empty($assignments[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'assignments', 
                                'action' => 'index', $course['Course']['id'], '?' => array('level' => $level['Level']['id']))) ?>" class="item-video">

                                     <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='assignment')&&($add['Add']['counts']!=0)){
                                     ?>
                                    <?php //echo $add['Add']['counts'];
                                             if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                           <?php  echo $counts[$add['Add']['id']]; ?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                        <span class="symp-suitcase " aria-hidden="true"></span></a><?php __('Assignments') ?></li>
                               <?php 
                                 $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="videos")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="videos")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>      
                        <?php } if ($videos === -1 || (isset($videos[$level['Level']['id']]) && !empty($videos[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'lessons', 
                                'action' => 'index', $course['Course']['id'], '?' => array('level' => $level['Level']['id'], 'type' => 'videos'))) ?>" class="item-download">
                                     <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='videos')&&($add['Add']['counts']!=0)){
                                     ?>
                                    <?php //echo $add['Add']['counts'];
                                              if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                        <?php     echo $counts[$add['Add']['id']]; ?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                        <span class="symp-camera-3" aria-hidden="true"></span></a><?php __('Videos') ?></li>
                             <?php 
                               $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="images")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="images")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>        
                        <?php }if ($images === -1 || (isset($images[$level['Level']['id']]) && !empty($images[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'lessons',
                                'action' => 'index', $course['Course']['id'], '?' => array('level' => $level['Level']['id'], 'type' => 'images'))) ?>" class="item-imgs">
                                    <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='images')&&($add['Add']['counts']!=0)){
                                     ?>
                                   <?php //echo $add['Add']['counts'];
                                               if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                       <?php      echo $counts[$add['Add']['id']]; ?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                        <span class="symp-pictures" aria-hidden="true"></span></a><?php __('Images') ?></li>
                                  <?php 
                                    $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="sounds")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="sounds")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>   
                        <?php } if ($sounds === -1 || (isset($sounds[$level['Level']['id']]) && !empty($sounds[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'lessons',
                                'action' => 'index', $course['Course']['id'], '?' => array('level' => $level['Level']['id'], 'type' => 'sounds'))) ?>" class="item-audio">
                                   <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='sounds')&&($add['Add']['counts']!=0)){
                                     ?>
                                    <?php //echo $add['Add']['counts'];
                                               if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                        <?php     echo $counts[$add['Add']['id']];?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                        <span class="symp-microphone" aria-hidden="true"></span></a><?php __('Sounds') ?></li>
                              <?php 
                                $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="attachments")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="attachments")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>       
                        <?php }if ($attachments === -1 || (isset($attachments[$level['Level']['id']]) && !empty($attachments[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'lessons', 
                                'action' => 'index', $course['Course']['id'], '?' => array('level' => $level['Level']['id'], 'type' => 'attachments'))) ?>" class="item-events">
                                   <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='attachments')&&($add['Add']['counts']!=0)){
                                     ?>
                                  <?php //echo $add['Add']['counts'];
                                            if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                         <?php    echo $counts[$add['Add']['id']];?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                        <span class="symp-download-2" aria-hidden="true"></span></a><?php __('Attachments') ?></li>

                              <?php 
                                $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="scorm")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="scorm")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>  
                        <?php }if ($scorms === -1 || (isset($scorms[$level['Level']['id']]) && !empty($scorms[$level['Level']['id']]))) { ?>
                <li style="display:<?php echo $cc;?>"><a href="<?php echo Router::url(array('controller' => 'lessons',
                                'action' => 'index', $course['Course']['id'], '?' => array('level' => $level['Level']['id'], 'type' => 'scorm'))) ?>" class="item-video">
                                    <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='scorm')&&($add['Add']['counts']!=0)){
                                     ?>
                                  <?php //echo $add['Add']['counts'];
                                            if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               

                        <div class="ann-notify"> 

                                         <?php    echo $counts[$add['Add']['id']];?>

                        </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                        <span class="symp-wallet" aria-hidden="true"></span></a><?php __('Scorm') ?></li>

                        <?php }?> 

                                <?php 
                                  $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="virtual_classroom")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="virtual_classroom")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?>  

                        <?php if (isset($cuser['Group']['allowed_permissions'][21])) { ?>
                <li style="display:<?php echo $cc;?>" class="password"> <a href="<?php echo Router::url(array( 'action' => 'slide_maker', $course['Course']['id']))?> 
                                                                           "class="item-video" ><span class="symp-film" aria-hidden="true"></span></a><?php __('Slide Maker') ?></li>
                             <?php 
                                  $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="slide_maker")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="slide_maker")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?> 
 <?php } 
                        // to open in التعليم الالكترونى فقط
                        if( $course['Course']['id'] == 6){
                        
                        if (isset($cuser['Group']['allowed_permissions'][15])) { ?>
                           <!-- utype=1  to login as teacher-->
                          
        <li style="display:<?php echo $cc;?>" class="password"><a href="<?php echo $this->base.'/webroot/scripts/vc/loadvc.php?fname='.$user["User"]["username"].'&ename='.$user["User"]["email"].'&utype=1'?>" target="_blank" class="item-download" ><span class="symp-camera-3" aria-hidden="true"></span></a>
                         
                <!--
                <li style="display:<?php echo $cc;?>" class="password"><a href="<?php echo 'http://www.learn-ubel.com/scripts/vc/loadvc.php?fname='.$user["User"]["username"].'&ename='.$user["User"]["email"].'&utype=2'?>" target="_blank" class="item-download" ><span class="symp-camera-3" aria-hidden="true"></span></a> 
                -->
                        
                    
                    <?php } else { ?>
                
                      <!-- utype=2  to login as student-->
        <li style="display:<?php echo $cc;?>" class="password"><a href="<?php echo $this->base.'/webroot/scripts/vc/loadvc.php?fname='.$user["User"]["username"].'&ename='.$user["User"]["email"].'&utype=2'?>" target="_blank" class="item-download" ><span class="symp-camera-3" aria-hidden="true"></span></a>
                
                
                
                <!--
                <li style="display:<?php echo $cc;?>" class="password"><a href="<?php echo 'http://www.learn-ubel.com/scripts/vc/loadvc.php?fname='.$user["User"]["username"].'&ename='.$user["User"]["email"].'&utype=1'?>" target="_blank" class="item-download" ><span class="symp-camera-3" aria-hidden="true"></span></a>
                -->

        <?php }  __('Virtual classrooms') ?></li>  
	<?php }?> 
                              
				 <?php
                                 $cc="";
                           foreach($icons as $icon):
                               if(($icon['Icon']['t_id']!=$u['id'])&&($icon['Icon']['user_id']!=$u['id'])&&($icon['Icon']['level_id']==$level['Level']['id'])){
                                   if(($icon['Icon']['state']=="hidden")&&($icon['Icon']['name']=="announcements")){
                                       $cc="none";
                                   }elseif(($icon['Icon']['state']=="visible")&&($icon['Icon']['name']=="announcements")){
                                       $cc="";
                                   }
                               }
                           endforeach;
                        ?> 

            </ul>
        </div>
    </div>
            <?php
        }
    } else {
        ?>
    <div class="alert alert-info"><? __('There is no levels in this coures') ?> </div>
    <?php }
    ?>

    <!-- timeline -->
</div> 
