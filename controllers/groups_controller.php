<?php

class GroupsController extends AppController {

    var $name = 'Groups';

    /**
     * @var Group */
    var $Group;
    
  var $helpers = array('Html','Ajax','Javascript');
    var $components = array('RequestHandler');
//    public $helpers = array('Js','ajax');  
    
    function index($id=false) {
        $this->loadmodel('GroupUser');
        $this->GroupUser->recursive = -1;
         $this->Group->id=$id;
         if(!$id || !$this->Group->exists($id)){
             $this->setFlash(__("Group Doesn't Exist !!",true),'alert alert-error');
             $this->redirect('/');
         }else{
            $users = $this->Session->read('user');
            $check=$this->GroupUser->find('first',array('fields'=>'GroupUser.id','conditions'=>array('GroupUser.user_id'=>$users['User']['id'],'GroupUser.group_id'=>$id)));
            if(!$check){
                $this->setFlash(__("u aren't registered in this group", true), 'alert alert-error');
                $this->redirect('/');
            }
         }
         $this->set(compact('id'));

    }
    function group_info($id=false){
        $group=$this->Group->find('first',array('conditions'=>array('Group.id'=>$id)));
        $this->set(compact('group'));
    }
//    function returnto_ajax($action){
//        $this->layout = $this->autoRender = false;
//        if ($this->RequestHandler->isAjax()) { //or $this->RequestHandler->isAjax() if you're in cake 1.3
//                $this->layout = 'ajax';
//                $this->layout=false;
//            }
//            $this->referer(array('action'));
//    }
    function view_posts($id=false){
        $this->loadmodel('Post');
        $this->Post->recursive = 0;
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
        $this->loadmodel('GroupUser');
        $this->GroupUser->recursive = -1;
         $this->Group->id=$id;
         if(!$id || !$this->Group->exists()){
             $this->setFlash(__("Group Doesn't Exist !!",true),'alert alert-error');
             $this->redirect(array('action'=>'index'));
         }else{
            $user = $this->Session->read('user');
            $check=$this->GroupUser->find('first',array('fields'=>'GroupUser.id','conditions'=>array('GroupUser.user_id'=>$user['User']['id'],'GroupUser.group_id'=>$id)));
            if(!$check){
                $this->setFlash(__("u aren't registered in this group", true), 'alert alert-error');
                $this->redirect('/');
            }
         }
//        $this->CourseUser->recursive = 0;
//        $group_user=$this->CourseUser->find('all',array('conditions'=>array('CourseUser.course_id'=>$id)));
        $this->GroupUser->recursive = 0;
        $group_users=$this->GroupUser->find("all",array('conditions'=>array('GroupUser.group_id'=>$id)));
       $this->set(array('group_user'=>$group_users,'id'=>$id));
        if ($this->RequestHandler->isAjax()) { //or $this->RequestHandler->isAjax() if you're in cake 1.3
             $this->layout = 'ajax';
             $this->layout=false;
         }
    }    
//    function index(){
//        $user=$this->Session->read('user');
//        $this->set('groups',$this->paginate('Group'));
//    }
    function group_upload(){
        $this->loadModel('Upload');
        $this->Upload->create();
        $group_id=$this->data['Upload']['group_id'];
        if(!empty($this->data)){
            if($this->data['Upload']['File']['size']<(10*1024*1024)){
                if($this->uploadFile(0)){
                    $this->Upload->save($this->data);
                    $this->setFlash(__('The file was uploaded successfully',true),'alert alert-success');
                    $this->redirect(array('action'=>'view',$group_id));
                }else{
                    $this->setFlash(__('Upload Failed',true),'alert alert-error');
                    $this->redirect(array('action'=>'view',$group_id));
                }
            }else{
                $this->setFlash(__('File is Too Large',true),'alert alert-error');
                $this->redirect(array('action'=>'view',$group_id));
            }
        }
        $this->set('file',$this->data);
//        echo "   sdldjkldsjl";
;    }
    function uploads($id=false){
        $this->loadModel('Upload');
        $this->set('id',$id);
    }
   function uploads_ajax($id,$type){
       $this->layout='ajax';
        $this->loadModel('Upload');
        $this->Upload->recursive=0;
        if($type=='all'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id)));
        }elseif($type=='pdf'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id,'Upload.type'=>'pdf'),'order'=>'Upload.name'));
        }elseif($type=='doc'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id,'Upload.type'=>array('doc','docx')),'order'=>'Upload.name'));
        }elseif($type=='ppt'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id,'Upload.type'=>array('ppt','pptx')),'order'=>'Upload.name'));
        }elseif($type=='img'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id,'Upload.type'=>array('gif','jpg','png')),'order'=>'Upload.name'));
        }
        $this->set(compact(array('group','type','id')));
   }
    function admin_add(){
        $courses=$this->Group->Course->find('list',array('order'=>"Course.name"));
        $this->set('courses',$courses);
        if (!empty($this->data)) {
            $this->Group->create();
            if ($this->Group->save($this->data)) {
                $this->setFlash(__('The group has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The group could not be saved. Please, try again.', true), 'alert alert-error');
            }
            
        }
    }
    function admin_view($id=null){
        $this->Group->id=$id;
        $this->Group->recursive=1;
        if (!$id || !$this->Group->exists()) {
            $this->setFlash(__('Invalid group', true),'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }else{
            $this->loadModel('GroupUser');
            $this->loadModel('Upload');
            $this->GroupUser->recursive=0;
            $group=$this->Group->find('first',array('conditions'=>array('Group.id'=>$id)));
            $group['students']=$this->GroupUser->find('all',array('conditions'=>array('GroupUser.group_id'=>$id,'GroupUser.user_type'=>0),'order'=>'User.username'));
//            $group['teachers']=$this->GroupUser->find('all',array('conditions'=>array('GroupUser.group_id'=>$id,'GroupUser.user_type'=>1),'order'=>'User.username'));
            $group['uploads']['pdf']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id,'Upload.type'=>'pdf'),'order'=>'Upload.name'));
            $group['uploads']['img']=$this->Upload->find('all',array('conditions'=>array('Upload.group_id'=>$id,'Upload.type !='=>'pdf'),'order'=>'Upload.name'));
            $this->set("group",$group);
        }
    }
    function admin_edit($id=null){
        $this->Group->id=$id;
        if (!$id || !$this->Group->exists()) {
            $this->setFlash(__('Invalid group', true),'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }else{
            $this->Group->read(null,$id);
        }
        if(!empty($this->data)){
            if ($this->Group->save($this->data)) {
                $this->setFlash(__('The group has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The group could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
    }
    function admin_delete($id = null) {
        $this->Group->id=$id;
        if (!$id || !$this->Group->exists()) {
            $this->setFlash(__('Invalid id for group', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }else{
            if ($this->Group->delete($id)) {
                $this->setFlash(__('Group deleted', true));
                $this->redirect(array('action' => 'index'));
            }else{
                $this->setFlash(__('Group was not deleted', true), 'alert alert-error');
                $this->redirect(array('action' => 'index'));
            }
        }
    }
}
