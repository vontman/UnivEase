<?php

class PostsController extends AppController {

    var $name = 'Posts';

    /**
     * @var Chat */
    var $Post;
  var $helpers = array('Html','Ajax','Javascript');
    var $components = array( 'RequestHandler' );
    function index() {
        $users = $this->Session->read('user');
        $this->loadmodel('Post');
        $this->Post->recursive = 0;
        
        $posts=$this->Post->find('all',array('order' => array('Post.created DESC'),'conditions'=>array('Post.user_id'=>$users['User']['id'])));
        
        $this->set('posts',$posts);
        
    }
    function add_post(){
        $this->layout = $this->autoRender = false;
        
        $users = $this->Session->read('user');
       $this->loadmodel('Post');
         if (!empty($_POST['data'])) {
             $data['Post']['user_id']=$users['User']['id'];
             $data['Post']['type_id']=0;
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
    
}
