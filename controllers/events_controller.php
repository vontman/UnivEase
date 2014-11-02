<?php

class EventsController extends AppController {

    var $name = 'Events';

    /**
     * @var Event */
    var $Event;
    var $uses=array('Add','Event','Suadd');
    function index($course_id) {
         $counts=0;
      $admin=$this->Session->read('user');
       $conditions=array('course_id'=>$course_id,'topic'=>'event');
        $adds=$this->Add->find('first',array('conditions'=>$conditions));
        if(!empty($adds)){
            $cods=array('add_id'=>$adds['Add']['id'],'user_id'=>$admin['id']);
            $suadd=$this->Suadd->find('first',array('conditions'=>$cods));
            if(!empty($suadd)){
                $time1=  strtotime($adds['Add']['created'])>strtotime($adds['Add']['updated'])?strtotime($adds['Add']['created']):strtotime($adds['Add']['updated']);
                $time2=  strtotime($suadd['Suadd']['created'])>strtotime($suadd['Suadd']['updated'])?strtotime($suadd['Sudd']['created']):strtotime($suadd['Suadd']['updated']) ; 
                $counts=$adds['Add']['counts'];              
                $this->Suadd->read(null,$suadd['Suadd']['id']);
                $this->Suadd->set(array('count'=>$counts,
                    'updated'=>date("Y-m-d H:i:s")));
                $this->Suadd->save();
            }else{
                $this->Suadd->set(array(
                    "add_id"=>$adds['Add']['id'],
                    "count"=>$adds['Add']['counts'],
                    "user_id"=>$admin['id']
                ));
                $this->Suadd->save();
            }
        } 
        $user = $this->get_user_info($course_id);
    }
    function admin_index($course_id) {
        $counts=0;
      $admin=$this->Session->read('admin');
       $conditions=array('course_id'=>$course_id,'topic'=>'event');
        $adds=$this->Add->find('first',array('conditions'=>$conditions));
        if(!empty($adds)){
            $cods=array('add_id'=>$adds['Add']['id'],'user_id'=>$admin['id']);
            $suadd=$this->Suadd->find('first',array('conditions'=>$cods));
            if(!empty($suadd)){
                $time1=  strtotime($adds['Add']['created'])>strtotime($adds['Add']['updated'])?strtotime($adds['Add']['created']):strtotime($adds['Add']['updated']);
                $time2=  strtotime($suadd['Suadd']['created'])>strtotime($suadd['Suadd']['updated'])?strtotime($suadd['Sudd']['created']):strtotime($suadd['Suadd']['updated']) ; 
                $counts=$adds['Add']['counts'];              
                $this->Suadd->read(null,$suadd['Suadd']['id']);
                $this->Suadd->set(array('count'=>$counts,
                    'updated'=>date("Y-m-d H:i:s")));
                $this->Suadd->save();
            }else{
                $this->Suadd->set(array(
                    "add_id"=>$adds['Add']['id'],
                    "count"=>$adds['Add']['counts'],
                    "user_id"=>$admin['id']
                ));
                $this->Suadd->save();
            }
        }
        $user = $this->get_current_course($course_id);
    }

    function view($id = null) {
        $event = $this->Event->read(null, $id);
        $user = $this->get_user_info($event['Event']['course_id']);
        if (!$id) {
            $this->setFlash(__('Invalid event', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('event', $event);
    }
    
    function admin_view($id = null) {
        $event = $this->Event->read(null, $id);
        $user = $this->get_current_course($event['Event']['course_id']);
        if (!$id) {
            $this->setFlash(__('Invalid event', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('event', $event);
    }

    function add($course_id = false) {
        $user = $this->get_user_info($course_id);

        if (!empty($this->data)) {
            $this->data['Event']['teacher_id'] = $user['User']['id'];
            $this->Event->create();
            if ($this->Event->save($this->data)) {
                $conditions=array("course_id"=>$course_id,"topic"=>"event");
                $adds=$this->Add->find('first', array('conditions' => $conditions));
                if(!empty($adds)){
                    $counts=$adds['Add']['counts'];
                    if($counts<10){
                        $counts++;
                    }else{
                        $counts=1;
                    }
                    $this->Add->read(null,$adds['Add']['id']);                    
                    $this->Add->set(array('counts'=>$counts,
                        'updated'=>date("Y-m-d H:i:s")));
                    $this->Add->save();
                }else{
                    $this->Add->set(array(
                      "course_id"=>$course_id,
                      
                      "topic"=>"event",
                      "counts"=>1
                        
                    ));
                    $this->Add->save();
                }
                
                $this->setFlash(__('The event has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $this->data['Event']['course_id']/*, '?' => array('level' => $this->data['Event']['level'])*/));
            } else {
                $this->setFlash(__('The event could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data['Event']['course_id'] = $course_id;
            
        }
    }
    function admin_add($course_id = false) {
        $user = $this->get_current_course($course_id);

        if (!empty($this->data)) {
           
            $this->Event->create();
            if ($this->Event->save($this->data)) {
                 $conditions=array("course_id"=>$course_id,"topic"=>"event");
                $adds=$this->Add->find('first', array('conditions' => $conditions));
                if(!empty($adds)){
                    $counts=$adds['Add']['counts'];
                    if($counts<10){
                        $counts++;
                    }else{
                        $counts=1;
                    }
                    $this->Add->read(null,$adds['Add']['id']);                    
                    $this->Add->set(array('counts'=>$counts,
                        'updated'=>date("Y-m-d H:i:s")));
                    $this->Add->save();
                }else{
                    $this->Add->set(array(
                      "course_id"=>$course_id,
                      
                      "topic"=>"event",
                      "counts"=>1
                        
                    ));
                    $this->Add->save();
                }
                
                $this->setFlash(__('The event has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $this->data['Event']['course_id']/*, '?' => array('level' => $this->data['Event']['level'])*/));
            } else {
                $this->setFlash(__('The event could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data['Event']['course_id'] = $course_id;
            
        }
    }

    function feed($course_id) {
        $user = $this->get_user_info($course_id);
        $start = date('Y-m-d H:i:s', $_GET['start']);
        $end = date('Y-m-d H:i:s', $_GET['end']);
        $this->Event->recursive = -1;
        $conditions = array('Event.course_id' => $course_id,  'Event.start >=' => $start, 'Event.end <=' => $end);
        $events = $this->Event->find('all', array('conditions' => $conditions));
        $arr = array();
        if (!empty($events)) {
            foreach ($events as $i => $event) {
                $arr[$i]['title'] = date('h:m a', strtotime($event['Event']['start'])) . ' ' . $event['Event']['title'];
                $arr[$i]['start'] = $event['Event']['start'];
                $arr[$i]['end'] = $event['Event']['end'];
                $arr[$i]['allDay'] = $event['Event']['all_day'];
                $arr[$i]['url'] = Router::url(array('controller' => 'events', 'action' => 'view', $event['Event']['id']));
            }
        }
        echo json_encode($arr);
        $this->layout = $this->autoRender = false;
    }
    function admin_feed($course_id) {
        $start = date('Y-m-d H:i:s', $_GET['start']);
        $end = date('Y-m-d H:i:s', $_GET['end']);
        $this->Event->recursive = -1;
        $conditions = array('Event.course_id' => $course_id,  'Event.start >=' => $start, 'Event.end <=' => $end);
        $events = $this->Event->find('all', array('conditions' => $conditions));
        
        $arr = array();
        if (!empty($events)) {
            foreach ($events as $i => $event) {
                $arr[$i]['title'] = date('h:m a', strtotime($event['Event']['start'])) . ' ' . $event['Event']['title'];
                $arr[$i]['start'] = $event['Event']['start'];
                $arr[$i]['end'] = $event['Event']['end'];
                $arr[$i]['allDay'] = $event['Event']['all_day'];
                $arr[$i]['url'] = Router::url(array('controller' => 'events', 'action' => 'view', $event['Event']['id']));
            }
        }
        echo json_encode($arr);
        $this->layout = $this->autoRender = false;
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid event', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $event = $this->Event->read(null, $id);
        $user = $this->get_user_info($event['Event']['course_id']);
        if (!empty($this->data)) {
            if ($this->Event->save($this->data)) {
                $this->setFlash(__('The event has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $user['CourseUser']['course_id']/*, '?' => array('level' => $this->data['Event']['level'])*/));
            } else {
                $this->setFlash(__('The event could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data = $event;
        }

        $this->render('add');
    }
    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid event', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $event = $this->Event->read(null, $id);
        $this->get_current_course($event['Event']['course_id']);
        if (!empty($this->data)) {
            if ($this->Event->save($this->data)) {
                $this->setFlash(__('The event has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $event['Event']['course_id']/*, '?' => array('level' => $this->data['Event']['level'])*/));
            } else {
                $this->setFlash(__('The event could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data = $event;
        }

        $this->render('admin_add');
    }

    function delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for event', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $event = $this->Event->read(null, $id);
        $user = $this->get_user_info($event['Event']['course_id']);
        if ($this->Event->delete($id)) {
            $this->setFlash(__('Event deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $event['Event']['course_id']/*, '?' => array('level' => $event['Event']['level'])*/));
        }
        $this->setFlash(__('Event was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index'));
    }
    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for event', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $event = $this->Event->read(null, $id);
        
        if ($this->Event->delete($id)) {
            $this->setFlash(__('Event deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $event['Event']['course_id']/*, '?' => array('level' => $event['Event']['level'])*/));
        }
        $this->setFlash(__('Event was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index'));
    }

   

}
