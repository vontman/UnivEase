<?php
$title = $course['Course']['name'];
?>
<div class="breadcrumbwidget">
    <ul class="breadcrumb">
        <li><a href="<?php echo Router::url(array('controller' => 'users', 'action' => 'dashboard')) ?>"><?php __('Home') ?></a></li>
        <span class="divider"> / </span>
        <li><a href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'index')) ?>"><?php __('Courses') ?></a></li>
        <span class="divider"> / </span>
        <li class="active"><?php echo $title ?></li>
    </ul>
</div>
<div class="msghead">
    <ul class="msghead-menu">
        <li>
            <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'courses', 'action' => 'edit', $course['Course']['id'])) ?>"> 

                <i class="icon-pencil"></i>
            </a>

			<!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <?php echo $html->link('<i class="icon-trash"></i>', 
					array('action' => 'delete', $course['Course']['id']), array('class' => 'btn','escape'=>false), 
					sprintf(__('Are you sure you want to delete # %s?', true), $course['Course']['id'])); ?>

         <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'course_users', 'action' => 'index', $course['Course']['id'])) ?>"> 
                <?php __('Enrolled users') ?>
                <i class="icon-search"></i>
            </a>

         <!--<button class="btn"><span class="iconsweets-alert2"></span> الابلاغ عن الاساءة</button>-->
            <a class="btn" href="<?php echo Router::url(array('controller' => 'sections', 'action' => 'index', $course['Course']['id'])) ?>"> 
                <?php __('Sections') ?>
                <i class="icon-cog"></i>
            </a>
			
			<a class="btn" href="<?php echo Router::url(array('controller' => 'attendances', 'action' => 'index', $course['Course']['id'])) ?>"> 
                <?php __('Attendance') ?>
                <i class="icon-folder-open"></i>
            </a> 
            <a class="btn" href="<?php echo Router::url(array('controller' => 'icons', 'action' => 'index', $course['Course']['id'])) ?>"> 
                <?php __('Icons Visibilty') ?>
                <i class="icon-cog"></i>
            </a>
            <a class="btn" href="<?php echo Router::url(array('controller' => 'scodes', 'action' => 'add', $course['Course']['id'])) ?>"> 
                <?php __('Add Security Code') ?>
                <i class="icon-cog"></i>
            </a>
        </li>
    </ul>
    <span class="clearall"></span> 
</div>
<h1><?php echo $title?></h1>
<hr />
<div class="content-section">
    <?php echo $course['Course']['description'] ?>
</div>
<div id="timeline" class="timeline">
    <div id="timeline" class="timeline-item">
        <?php  if (!empty($levels)) {
                                        
        ?>

 <h3><a href="#level" data-toggle="collapse" data-target="#level" ><span class="timeline-icon"><i></i></span><?php __("Exams & Evaluations") ?></a>
        </h3>
        <div class="items accordion-body collapse  " id="level<?php  ?>">
           
            <ul> 
                <li style="" class="password"><a href="<?php echo Router::url(array('controller' => 'exams',
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
            
                      

            <li><a href="<?php echo Router::url(array('controller' => 'surveys', 'action' => 'index', 
                                $course['Course']['id'])) ?>"
                                class="item-download">
                                 <span class="symp-info" aria-hidden="true">
                                    </span></a><?php __('Surveys') ?></li>
                                    <li><a href="<?php echo Router::url(array('controller' => 'events', 'action' => 'index', $course['Course']['id']
                           )) ?>" class="item-download">
                                <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='event')&&($add['Add']['counts']!=0)){
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
                                <span class="symp-calendar" aria-hidden="true"></span></a>
                                <?php __('Events') ?></li>
                                    <li>
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
        
            </ul>
        </div>
        <?php } ?>
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
                <h3><a href="#level<?php e($level['Level']['id']) ?>" data-toggle="collapse" data-target="#level<?php e($level['Level']['id']) ?>"><span class="timeline-icon"><i></i></span><?php echo $level['Level']['name']; ?></a>
                    <a href="<?php echo Router::url(array('controller' => 'levels', 'action' => 'edit', $level['Level']['id'])) ?>" class="btn btn-small"><i class="icon-edit"></i></a>
                    <a href="<?php echo Router::url(array('controller' => 'levels', 'action' => 'delete', $level['Level']['id'])) ?>" class="btn btn-small" onclick="javascript:return confirm('<?php echo sprintf(__('Are you sure you want to delete %s?', true), $level['Level']['name']) ?>');"><i class="icon-remove"></i></a>
                </h3>

                <div class="items accordion-body collapse  <?php echo $class ?>" id="level<?php echo $level['Level']['id'] ?>">
                    <ul>
						<li><a href="<?php echo Router::url(array('controller' => 'assignments', 'action' => 'index', $course['Course']['id'],
                            '?' => array('level' => $level['Level']['id']))) ?>" class="item-video">
                               <?php 
                                    foreach($adds as $add):
                                          if (($add['Add']['topic']=='assignment')&&($add['Add']['counts']!=0)){
                                ?>
                               <?php //echo $add['Add']['counts'];
                                           if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               
                                                 
                                                 <div class="ann-notify"> 
                                  
                                    <?php         echo $counts[$add['Add']['id']];?>
                                          
                               </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?>                          
                             <span class="symp-suitcase " aria-hidden="true"></span></a>
                                <?php __('Assignments') ?></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'lessons', 'action' => 'index', $course['Course']['id'],
                            '?' => array('level' => $level['Level']['id'], 'type' => 'videos'))) ?>" class="item-download">
                                <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='videos')&&($add['Add']['counts']!=0)){
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
                                <span class="symp-camera-3" aria-hidden="true"></span></a>
                                <?php __('Videos') ?></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'lessons', 'action' => 'index', $course['Course']['id'],
                            '?' => array('level' => $level['Level']['id'], 'type' => 'images'))) ?>" class="item-imgs">
                                <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='images')&&($add['Add']['counts']!=0)){
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
                                <span class="symp-pictures" aria-hidden="true"></span></a>
                                <?php __('Images') ?></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'lessons', 'action' => 'index', $course['Course']['id'],
                            '?' => array('level' => $level['Level']['id'], 'type' => 'sounds'))) ?>" class="item-audio">
                                 <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='sounds')&&($add['Add']['counts']!=0)){
                                     ?>
                                    <?php //echo $add['Add']['counts'];
                                          if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               
                                                 
                                                 <div class="ann-notify"> 
                                  
                                          <?php   echo $counts[$add['Add']['id']];?>
                                          
                               </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?> 
                                <span class="symp-microphone" aria-hidden="true"></span></a>
                                <?php __('Sounds') ?></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'lessons', 'action' => 'index', $course['Course']['id'],
                            '?' => array('level' => $level['Level']['id'], 'type' => 'attachments'))) ?>" class="item-events">
                                  <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='attachments')&&($add['Add']['counts']!=0)){
                                     ?>
                                   <?php //echo $add['Add']['counts'];
                                             if(!empty($counts)&&($counts[$add['Add']['id']] != 0)){
                                  ?>               
                                                 
                                                 <div class="ann-notify"> 
                                  
                                            <?php echo $counts[$add['Add']['id']]; ?>
                                          
                               </div>
                                <?php
                                             }
                                    }
                                    endforeach;
                                ?>  
                                <span class="symp-download-2" aria-hidden="true"></span></a>
                                <?php __('Attachments') ?></li>
                        <li><a href="<?php echo Router::url(array('controller' => 'lessons', 'action' => 'index', $course['Course']['id'],
                            '?' => array('level' => $level['Level']['id'], 'type' => 'scorm'))) ?>" class="item-video">
                                <?php 
                                           foreach($adds as $add):
                                               if (($add['Add']['topic']=='scrom')&&($add['Add']['counts']!=0)){
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
                                <span class="symp-wallet" aria-hidden="true"></span></a>
                                <?php __('Scorm') ?></li>
                       
<!--                        <li><a href="http://learn-ubel.com/twasole" class="item-imgs" target="_blank">
                                <span class="symp-chat-3" ></span></a>
                            <?php// __('Communicate') ?></li>-->
                       
                        
                        <li> <a href="<?php echo Router::url(array( 'action' => 'slide_maker', $course['Course']['id']))?> "
                                class="item-video" ><span class="symp-film" aria-hidden="true"></span></a>
                                    <?php __('Slide Maker') ?></li>
                        <li> <a href="<?php echo 'http://www.learn-ubel.com/scripts/vc/loadvc.php?fname='.$user["username"].'&ename='.$user["email"].'&utype=2'?>" target="_blank" class="item-download" ><span class="symp-camera-3" aria-hidden="true"></span></a>
                                <?php __('Virtual classrooms') ?></li>
                                      
                        <li> <a href="<?php echo 'http://www.learn-ubel.com/scripts/vd/lm.php'?>" target="_blank" class="item-audio" ><span class="symp-edit" aria-hidden="true"></span></a>
                                <?php __('Lectur Maker') ?></li>
                        <li>
					</ul>
                </div>
            </div>
            <?php
        }
    }
    ?>

    <!-- timeline -->
</div>