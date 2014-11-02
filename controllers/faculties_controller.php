<?php

class FacultiesController extends AppController {

    var $name = 'Faculties';
    //var $uses = array('Add','Course','Suadd');
    /**
     * @var Course */
    var $Faculty;


    function admin_index() {
        $this->Course->recursive = 0;
        $this->set('courses', $this->paginate('Course'));
    }

    function admin_view($id = null) {
        $this->loadModel('Add');
        if (!$id) {
            $this->setFlash(__('Invalid course', true));
            $this->redirect(array('action' => 'index'));
        }
        
        $user = $this->is_admin();
        $this->set("user",$user);
        $course = $this->Course->read(null, $id);
        $this->set('course', $course);
        $this->loadModel('Level');
        $levels = $this->Level->find('all', array('conditions' => array('Level.course_id' => $id), 'order' => 'Level.display_order asc'));
        
		$this->loadModel('Announcement');
        $announces_cnt = array();
        $all_announcements = $this->Announcement->find('all', array('conditions' => array('Announcement.course_id' => $id)));
            if (!empty($all_announcements)) {
                foreach ($all_announcements as $announce) {
                    $announces_cnt[$announce['Announcement']['level']] = $this->Announcement->find('count', array('conditions' => array('Announcement.course_id' => $id, 'Announcement.level' => $announce['Announcement']['level'])));
                }
            }
            $admin=$this->Session->read('admin');
        $counts=array();
        $conditions=array('course_id'=>$id);
        $adds=$this->Add->find('all',array('conditions'=>$conditions));
        
        if(!empty($adds)){
            foreach($adds as $add):
           $cods=array('add_id'=>$add['Add']['id'],'user_id'=>$admin['id'],'add_id'=>$add['Add']['id']);
            $suadd=$this->Suadd->find('first',array('conditions'=>$cods));
            if(!empty($suadd)){
                $time1=  strtotime($add['Add']['created'])>strtotime($add['Add']['updated'])?strtotime($add['Add']['created']):strtotime($add['Add']['updated']);
                $time2=  strtotime($suadd['Suadd']['created'])>strtotime($suadd['Suadd']['updated'])?strtotime($suadd['Sudd']['created']):strtotime($suadd['Suadd']['updated']) ; 
                if($time2>$time1){
                    $counts[$add['Add']['id']]=0;
                }else{
                    if($add['Add']['counts']>$suadd['Suadd']['count']){
                       $counts[$add['Add']['id']]=$add['Add']['counts']-$suadd['Suadd']['count'];
                    }elseif($add['Add']['counts']<$suadd['Suadd']['count']){
                        $counts[$add['Add']['id']]=$add['Add']['counts'];
                    }else{
                        $counts[$add['Add']['id']]=0;
                    }
                }
            }else{
                $counts[$add['Add']['id']]=$add['Add']['counts'];
            }
          endforeach;
        }
         $this->set('counts',$counts);
        $this->set('adds',$adds);
        $this->set(compact('announces_cnt','levels'));
        $icons=$this->Icon->find("all",array("conditions"=>array('course_id'>$id)));
        $this->set('icons',$icons);
        $this->pageTitle = $course['Course']['name'];
    }

    function admin_add() {
         if (!empty($this->data)) {
            $this->Faculty->create();
            if ($this->Faculty->save($this->data)) {

                $this->setFlash(__('New Faculty has been added', true), 'alert alert-success');
                $this->redirect('/');
            } else {
                $this->setFlash(__('The chat could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
    
        
    }
    
    function get_all_courses() {
//        Configure::write('debug', 0);
        $this->layout = $this->autoRender = false;
        $subcategories = $this->Course->getCourse('all');
        $submenus['submenus'] = $subcategories;

        echo json_encode($submenus);
    }
    
    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid course', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }

        $course = $this->Course->read(null, $id);
        if (!empty($this->data)) {
            $this->Course->addLevels($this->data);
            if ($this->Course->save($this->data)) {
                $id = $this->Course->id;
                $path = WWW_ROOT . 'data/' . $id . '/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $this->setFlash(__('The course has been saved', true), 'alert alert-success');
                $this->redirect(array('controller' => 'categories', 'action' => 'view', $this->data['Course']['category_id']));
            } else {
                $this->setFlash(__('The course could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data = $course;
        }
        $this->loadModel('Level');
        $levels = $this->Level->find('all', array('conditions' => array('Level.course_id' => $id)));
        $categories = $this->Course->Category->findCategories();
        $this->set(compact('categories', 'levels'));
        $this->render('admin_add');
    }

    function admin_delete($id = null) {

        if (!$id) {
            $this->setFlash(__('Invalid id for course', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $course = $this->Course->read(null, $id);
        if ($this->Course->delete($id)) {
            $this->loadModel('CourseUser');
            $this->CourseUser->deleteall(array('CourseUser.course_id' => $id));

            $this->loadModel('Assignment');
            $this->loadModel('Lesson');
            $this->loadModel('Event');
			$this->loadModel('Attendance');
            $this->loadModel('Exam');
            $this->loadModel('Level');
            $this->loadModel('ReportAttendance');
            $this->loadModel('ScheduleDetail');
            $this->loadModel('VirtualClassroom');
            $this->loadModel('Survey');
            $this->loadModel('Section');
            $this->loadModel('Announcement');
			
            $this->Assignment->deleteall(array('Assignment.course_id' => $id), true, true);
            $this->Lesson->deleteall(array('Lesson.course_id' => $id), true, true);
            $this->Event->deleteall(array('Event.course_id' => $id), true, true);
            $this->Attendance->deleteall(array('Attendance.course_id' => $id), true, true);
            $this->Exam->deleteall(array('Exam.course_id' => $id), true, true);
            $this->Level->deleteall(array('Level.course_id' => $id), true, true);
            $this->ReportAttendance->deleteall(array('ReportAttendance.course_id' => $id), true, true);
            $this->ScheduleDetail->deleteall(array('ScheduleDetail.course_id' => $id), true, true);
            $this->VirtualClassroom->deleteall(array('VirtualClassroom.course_id' => $id), true, true);
            $this->Survey->deleteall(array('Survey.course_id' => $id), true, true);
            $this->Section->deleteall(array('Section.course_id' => $id), true, true);
            $this->Announcement->deleteall(array('Announcement.course_id' => $id), true, true);

            $this->setFlash(__('Course deleted', true), 'alert alert-success');
            $this->redirect(array('controller' => 'categories', 'action' => 'view', $course['Course']['category_id']));
        }
        $this->setFlash(__('Course was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Course->deleteall(array('Course.id' => $ids))) {
                $this->setFlash(__('Course deleted alert alert-successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Course can not be deleted', true), 'alert alert-error');
            }
        }
        $this->redirect($this->referer());
    }

    function view($id = false) {
        $user = $this->get_user_info($id);
        $this->set("user",$user);
        $course = $this->Course->read(null, $id);
        $this->loadModel('Assignment');
        $this->loadModel('Lesson');
        $this->loadModel('Faculty');
        $this->loadModel('Level');
        $this->loadModel('Event');
        $this->loadModel('Exam');
        $this->loadModel('Discussion');
        $this->loadModel('VirtualClassroom');
        $this->loadModel('Poll');
		$this->loadModel('Survey');
        $this->loadModel('Announcement');
		
        $levels = $this->Level->find('all', array('conditions' => array('Level.course_id' => $id), 'order' => 'Level.display_order asc'));
     
	$this->set('course', $course);
        $this->set('levels', $levels);
        $assignments = array();
        $videos = array();
        $sounds = array();
        $attachments = array();
        $scorms = array();
        $images = array();
        $discussions=array();
        $tawasol = array();
        $events = array();
        $chats = array();
        $exams = array();
	$surveys = array();
        $virtual_classrooms = array();
        $announcements = array();
        $announces_cnt = array();
		
        if (isset($user['Group']['allowed_permissions'][2])) {
            $all_assignments = $this->Assignment->find('all', array('conditions' => array('Assignment.course_id' => $id, 'Assignment.publish_date <=' => date('Y-m-d H:i:s')), " concat(',',Assignment.receiver_students,',') like '%,{$user['CourseUser']['user_id']},%' "));
            if (!empty($all_assignments)) {
                foreach ($all_assignments as $assign) {
                    $assignments[$assign['Assignment']['level']] = $this->Assignment->find('count', array('conditions' => array('Assignment.course_id' => $id, 'Assignment.publish_date <=' => date('Y-m-d H:i:s')), " concat(',',Assignment.receiver_students,',') like '%,{$user['CourseUser']['user_id']},%' ", 'Assignment.level' => $assign['Assignment']['level']));
                }
            }
        } elseif (isset($user['Group']['allowed_permissions'][1])) {
            $assignments = -1;
        }
        
        if (isset($user['Group']['allowed_permissions'][4])) {
            $all_attachments = $this->Lesson->find('all', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'attachments')));
            if (!empty($all_attachments)) {
                foreach ($all_attachments as $attach) {
                    $attachments[$attach['Lesson']['level']] = $this->Lesson->find('count', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'attachments', 'Lesson.level' => $attach['Lesson']['level'])));
                }
            }
            $all_sounds = $this->Lesson->find('all', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'sounds')));
            if (!empty($all_sounds)) {
                foreach ($all_sounds as $sound) {
                    $sounds[$sound['Lesson']['level']] = $this->Lesson->find('count', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'sounds', 'Lesson.level' => $sound['Lesson']['level'])));
                }
            }
            $all_videos = $this->Lesson->find('all', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'videos')));
            if (!empty($all_videos)) {
                foreach ($all_videos as $video) {
                    $videos[$video['Lesson']['level']] = $this->Lesson->find('count', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'videos', 'Lesson.level' => $video['Lesson']['level'])));
                }
            }
            $all_scorms = $this->Lesson->find('all', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'scorm')));
            if (!empty($all_scorms)) {
                foreach ($all_scorms as $scorm) {
                    $scorms[$scorm['Lesson']['level']] = $this->Lesson->find('count', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'scorm', 'Lesson.level' => $scorm['Lesson']['level'])));
                }
            }

            $all_images = $this->Lesson->find('all', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'images')));
            if (!empty($all_images)) {
                foreach ($all_images as $image) {
                    $images[$image['Lesson']['level']] = $this->Lesson->find('count', array('conditions' => array('Lesson.course_id' => $id, 'Lesson.type' => 'images', 'Lesson.level' => $image['Lesson']['level'])));
                }
            }
        } elseif (isset($user['Group']['allowed_permissions'][3])) {
            $attachments = -1;
            $sounds = -1;
            $videos = -1;
            $scorms = -1;
            $images = -1;
            //$discussions=-1;
        }
        if (isset($user['Group']['allowed_permissions'][6])) {
            $all_events = $this->Event->find('all', array('conditions' => array('Event.course_id' => $id)));
            if (!empty($all_events)) {
                foreach ($all_events as $event) {
                    @$events[$event['Event']['course']] = $this->Event->find('all', array('conditions' => array('Event.course_id' => $id)));
                }
            }
        } elseif (isset($user['Group']['allowed_permissions'][5])) {
            $events = -1;
        }
		
        if (isset($user['Group']['allowed_permissions'][10])) {
             $tawasol = -1;
        }
        
        if (!isset($user['Group']['allowed_permissions'][27])) {
            debug($id);
             $conditions = array('Discussion.course_id' => $id);
             $all_disc = $this->Discussion->find('all', array('fields'=>array('Discussion.course_id,Discussion.id'),'conditions' => $conditions));
            // debug($all_disc); 
             if (!empty($all_disc)) {
                foreach ($all_disc as $disc) {
                    $discs['Discussion']['id'][] = $disc['Discussion']['id'];
                   
                }
            }
        }else{
            $discs=-1;
        }
        
        if (!isset($user['Group']['allowed_permissions'][14])) {

            $conditions = array('Exam.course_id' => $id, 'Exam.publish_date <=' => date('Y-m-d H:i:s'), 'Exam.delivery_date >=' => date('Y-m-d H:i:s'));
            $conditions['OR'] = array("concat(',',Exam.students,',') like '%,{$user['User']['id']},%' ", 'Exam.for_all' => 1);
            if (isset($user['User']["Sectios"][$id])) {
                $conditions['OR'] = array("concat(',',Exam.students,',') like '%,{$user['User']['id']},%' ", 'Exam.for_all' => 1, "concat(',',Exam.sections,',') like '%,{$user['User']["Sectios"][$id]},%' ");
            }
            $all_exams = $this->Exam->find('all', array('conditions' => $conditions));
            if (!empty($all_exams)) {
                foreach ($all_exams as $exam) {
                    $exams[$exam['Exam']['level_id']][$exam['Exam']['id']] = $exam;
                }
            }
        } else {
            $exams = -1;
        }

        if (!isset($user['Group']['allowed_permissions'][15])) {
            $all_classrooms = $this->VirtualClassroom->find('all', array('conditions' => array('VirtualClassroom.course_id' => $id)));
            if (!empty($all_classrooms)) {
                foreach ($all_classrooms as $classroom) {
                    $virtual_classrooms[$classroom['VirtualClassroom']['level_id']] = $this->VirtualClassroom->find('all', array('conditions' => array('VirtualClassroom.course_id' => $id, 'VirtualClassroom.level_id' => $classroom['VirtualClassroom']['level_id'], 'VirtualClassroom.publish_date <=' => date('Y-m-d H:i:s'), 'VirtualClassroom.cutoff_date >=' => date('Y-m-d H:i:s'))));
                }
            }
        } else {
            $virtual_classrooms = -1;
        }

        if (!isset($user['Group']['allowed_permissions'][16])) {
           $all_surveys = $this->Survey->find('all', array('conditions' => array('Survey.course_id' => $id)));
            if (!empty($all_surveys)) {
                foreach ($all_surveys as $survey) {
                    $surveys[$survey['Survey']['course_id']] = $this->Survey->find('all', array('conditions' => array('Survey.course_id' => $id,  'Survey.publish_date <=' => date('Y-m-d H:i:s'), 'Survey.cutoff_date >=' => date('Y-m-d H:i:s'))));
                }
            }
        } else {
            $surveys = -1;
        }
        
		
		if (isset($user['Group']['allowed_permissions'][23])) 
        {}
            $announcements = -1;
            $all_announcements = $this->Announcement->find('all', array('conditions' => array('Announcement.course_id' => $id )));
            if (!empty($all_announcements)) {
                foreach ($all_announcements as $announce) 
                {
                    $announces_cnt[$announce['Announcement']['course_id']] = $this->Announcement->find('count', array('conditions' => array('Announcement.course_id' => $id)));
                }
            }
        
        else 
        {
            $all_announcements = $this->Announcement->find('all', array('conditions' => 
                array('Announcement.course_id' => $id, 'Announcement.publish_date <=' => date('Y-m-d H:i:s'), 'Announcement.last_publish_date >=' => date('Y-m-d H:i:s'))));
           
            if (!empty($all_announcements)) {
                foreach ($all_announcements as $announce) {
                    $announcements[$announce['Announcement']['course']] = $this->Announcement->find('count', array('conditions' => array('Announcement.course_id' => $id, 'Announcement.publish_date <=' => date('Y-m-d H:i:s'), 'Announcement.last_publish_date >=' => date('Y-m-d H:i:s'))));
                }
                $announces_cnt = $announcements;
            }
        }
             $admin=$this->Session->read('user');
        $counts=array();
        $conditions=array('course_id'=>$id);
        $adds=$this->Add->find('all',array('conditions'=>$conditions));
        
        if(!empty($adds)){
            foreach($adds as $add):
            $cods=array('add_id'=>$add['Add']['id'],'user_id'=>$admin['id'],'add_id'=>$add['Add']['id']);
            $suadd=$this->Suadd->find('first',array('conditions'=>$cods));
            if(!empty($suadd)){
                $time1=  strtotime($add['Add']['created'])>strtotime($add['Add']['updated'])?strtotime($add['Add']['created']):strtotime($add['Add']['updated']);
                $time2=  strtotime($suadd['Suadd']['created'])>strtotime($suadd['Suadd']['updated'])?strtotime($suadd['Sudd']['created']):strtotime($suadd['Suadd']['updated']) ; 
                
                if($time2>$time1){
                    $counts[$add['Add']['id']]=0;
                }else{
                    if($add['Add']['counts']>$suadd['Suadd']['count']){
                       $counts[$add['Add']['id']]=$add['Add']['counts']-$suadd['Suadd']['count'];
                    }elseif($add['Add']['counts']<$suadd['Suadd']['count']){
                        $counts[$add['Add']['id']]=$add['Add']['counts'];
                    }else{
                        $counts[$add['Add']['id']]=0;
                    }
                }
            }else{
                $counts[$add['Add']['id']]=$add['Add']['counts'];
            }
          endforeach;
        }
         $this->set('counts',$counts);
        $this->set('adds',$adds);
         
        $icons=$this->Icon->find("all",array("conditions"=>array('course_id'>$id)));
        $this->set('icons',$icons);

		//debug(array($images, $sounds, $scorms, $videos, $attachments, $assignments, $posts));
        $this->set(compact('discs','announcements', 'announces_cnt', 'images', 'sounds', 'scorms', 'videos', 'attachments', 'assignments','tawasol', 'events', 'exams','virtual_classrooms','surveys'));
        $this->pageTitle = $course['Course']['name'];
    }

    function edit($id = false) {
        $this->get_user_info($id);
        $course = $this->Course->read(null, $id);
        if (!empty($this->data)) {
            $this->Course->addLevels($this->data);
            if ($this->Course->save($this->data)) {

                $id = $this->Course->id;
                
                $path = WWW_ROOT . 'data/' . $id . '/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $this->setFlash(__('The course has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'view', $this->data['Course']['id']));
            } else {
                $this->setFlash(__('The course could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data = $course;
        }
        $this->loadModel('Level');
        $levels = $this->Level->find('all', array('conditions' => array('Level.course_id' => $id)));
        $categories = $this->Course->Category->findCategories();
        $this->set(compact('categories', 'levels'));

        $this->pageTitle = $course['Course']['name'];
        $this->render('add');
    }

	 function get_url() 
    {
        $url = "http://e-teacherdiploma.com/SlideMakerv2/app";
        echo file_get_contents($url);
        $this->autoRender = false;
    }
    
    function admin_get_url() 
    {
        $url = "http://e-teacherdiploma.com/SlideMakerv2/app";
        echo file_get_contents($url);
        $this->autoRender = false;
    }
}