<?php

class GroupsController extends AppController {

    var $name = 'Groups';

    /**
     * @var Group */
    var $Group;
    
    var $components = array('RequestHandler');
public $helpers = array('Js','ajax');  
    function index($id=false) {
        $this->loadmodel('CourseUser');
        $this->CourseUser->recursive = -1;
        $users = $this->Session->read('user');
        $check=$this->CourseUser->find('first',array('fields'=>'CourseUser.id','conditions'=>array('CourseUser.user_id'=>$users['User']['id'],'CourseUser.course_id'=>$id)));
        if(!$check){
            $this->setFlash(__("u aren't registered in this course", true), 'alert alert-error');
            $this->redirect('/');
        }
        $this->loadmodel('Post');
        $this->Posts->recursive = 0;
        
        $posts=$this->Post->find('all',array('order' => array('Post.created DESC'),'conditions'=>array('Post.course_id'=>$id,'Post.type_id'=>1)));
        $this->set(compact('posts','id'));
    }
    
function add_ajax($id){
    $this->layout = $this->autoRender = false;
     $this->loadmodel('CourseUser');
        
        $users = $this->Session->read('user');
        $check=$this->CourseUser->find('first',array('fields'=>'CourseUser.id','conditions'=>array('CourseUser.user_id'=>$users['User']['id'],'CourseUser.course_id'=>$id)));
        if(!$check){
            $this->setFlash(__("u aren't registered in this course", true), 'alert alert-error');
            $this->redirect('/');
        }
        $this->loadmodel('Post');
        $this->Posts->recursive = 0;
        
        $posts=$this->Post->find('all',array('order' => array('Post.created DESC'),'conditions'=>array('Post.course_id'=>$id,'Post.type_id'=>1)));
        $this->set(compact('posts','id'));
    if ($this->RequestHandler->isAjax()) { //or $this->RequestHandler->isAjax() if you're in cake 1.3
            $this->layout = 'ajax';
            $this->layout=false;
        }
}
    function add_post($id=false){
        print_r($GLOBALS);
        $this->layout = $this->autoRender = false;
        $users = $this->Session->read('user');
       $this->loadmodel('Post');
         if (!empty($_POST['data'])) {
             $data['Post']['user_id']=$users['User']['id'];
             $data['Post']['type_id']=1;
             $data['Post']['course_id']=$id;
             $data['Post']['content']=$_POST['data'];
            $this->Post->create();
            if ($this->Post->save($data)) {

                $this->setFlash(__('New Post has been added', true), 'alert alert-success');
                $this->redirect(array('action'=>'index',$id));
            } else {
                $this->setFlash(__('The Post could not be saved. Please, try again.', true), 'alert alert-error');
            }
        } 
    }
     function users($id=false){
        
        $users = $this->Session->read('user');
        $this->loadmodel('CourseUser');
        $this->CourseUser->recursive = 0;
        
        $group_user=$this->CourseUser->find('all',array('conditions'=>array('CourseUser.course_id'=>$id)));
        
       $this->set(compact('group_user','id'));
    }
}
