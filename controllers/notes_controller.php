<?php

class NotesController extends AppController {

    var $name = 'Notes';

    /**
     * @var Note */
    var $Note;

   function index($student_id)
    {
        $this->Note->recursive = 0;
        $this->loadModel('Users');
        $this->Users->recursive = 0;
        
         $username= $this->Users->find('first',array("fields"=>"Users.name",'conditions'=>array('Users.id'=>$student_id)));
        $this->set('notes', $this->paginate('Note', array('Note.course_id' =>$_GET["crs_id"],'Note.student_id'=>$student_id)));
        
        $this->set('username',$username['Users']['name']);
        
    }


    function view($id = null) {

        if (!$id) {
            $this->setFlash(__('Invalid message', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('note', $this->Note->read(null, $id));
        $this->Note->updateAll(array('Note.read' => 1), array('Note.id' => $id));
    }

    function send_note($student_id = false) {
        $user=$this->is_user();
        $this->loadModel("User");
        $users_ids = explode(",", $this->data["Note"]["student_id"]);
        $course_id= @$_GET['crs_id'];
        $this->loadModel('Courses');
        $this->Courses->recursive = 0;
         $course_name= $this->Courses->find('first',array("fields"=>"Courses.name",'conditions'=>array('Courses.id'=>$course_id)));
        if (!empty($this->data)) {
            $this->data['Note']['sender_id'] = $user['id'];
           
            
            $this->data['Note']['read'] = 0;
            $this->Note->create();
           //debug($this->data);
                $error = false;
                    if ($this->Note->save($this->data)) {
                        $this->setFlash(__('done', true), 'alert alert-success ');
                        $this->redirect(array('action' => 'index',$student_id,'?' => array('crs_id' => $this->data['Note']['course_id'])));
                        
                    } else {
                        $error = true;
                        $this->setFlash(__('The message could not be saved. Please, try again.', true), 'alert alert-danger');
                       
                    }
                
               
            
            $this->set('student_id', $student_id);
        }
        if (empty($this->data)) {
            $this->data['Note']['student_id'] = $student_id;
        }
        $this->set("student_id", $student_id);
        $this->set("course_id", $course_id);
        $this->set("course_name", $course_name['Courses']['name']);
    }
    function admin_sendall($student_id = false) {
         $this->loadModel('User');
               
                $users = $this->User->find('list', array("fields"=>"User.id,User.name"));
              //  debug($users);
             
        
        $userAccount = $this->config["sms_username"];
        $passAccount = $this->config["sms_password"];
        $sender = $this->config["sms_sender"];
        $user = $this->is_admin();
        
        if (!empty($this->data)) {
          
            for($i=0;$i<count($users);$i++){
                $error = false;
                foreach ($users as $id=>$value) {
                    $this->Note->create();
                    $this->data['Note']['sender_id'] = $user['id'];
                    $this->data['Note']['sender_type'] = 'admin';
                    $this->data['Note']['receiver_type'] = 'user';
                    $this->data['Note']['read'] = 0;
                    $this->data['Note']['receiver_id'] = $id;
                    if ($this->Note->save($this->data)) {
                        $this->setFlash(__('The message has been sent', true), 'alert alert-success');
                    } else {
                        $error = true;
                        $this->setFlash(__('The message could not be saved. Please, try again.', true), 'alert alert-danger');
                        break;
                    }
                }
                if (!$error) {
                    
                    $this->redirect(array('action' => 'index'));
                }
            } 
            $this->set('receiver_id', $student_id);
        }
        if (empty($this->data)) {
            $this->data['Note']['receiver_id'] = $student_id;
        }
        $this->set("receiver_id", $student_id);
    }

    


    function reply($id = false) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid id for message', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $user = $this->is_user();
        $message = $this->Note->read(null, $id);
        if (!empty($this->data)) {
            $this->data['Note']['sender_id'] = $user['id'];
            $this->data['Note']['sender_type'] = 'user';
            $this->data['Note']['receiver_id'] = $message['Note']['sender_id'];
            $this->data['Note']['receiver_type'] = $message['Note']['sender_type'];
            $this->data['Note']['read'] = 0;
            $this->Note->create();
            if ($this->Note->save($this->data)) {
                $this->setFlash(__('The message has been sent', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', '#' => 'sent'));
            } else {
                $this->setFlash(__('The message could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        $this->set('message', $message);
    }

    

    function delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for message', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Note->delete($id)) {
            $this->setFlash(__('Note deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index'));
        }
        $this->setFlash(__('Note was not deleted', true), 'alert alert-danger');
        $this->redirect(array('action' => 'index'));
    }



}

