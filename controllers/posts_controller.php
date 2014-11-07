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
        $user_id=$users['User']['id'];
        $this->loadmodel('Post');
        $this->loadmodel('Like');
        $this->loadmodel('Friend');
        $this->loadmodel('Comment');
        $this->loadmodel('Bookmark');
        
        $this->Posts->recursive = 1;
        $this->Comment->recursive = 0;
        $this->Bookmark->recursive = -1;
        $this->Friend->recursive = -1;
        $friends=$this->Friend->find('all',array('fields'=>array('Friend.u1_id,Friend.u2_id'),'conditions'=>array('OR'=>array('Friend.u2_id'=>$user_id,'Friend.u1_id'=>$user_id))));
        //debug($friends);
        foreach($friends as $freind){
            $u=$freind['Friend']['u1_id'];
            if($u=$user_id){
                 $fr[]=$freind['Friend']['u2_id'];
            }else{
                $fr[]=$freind['Friend']['u1_id'];
            }
        }
        $fr[]=$user_id;
        
        $posts=$this->Post->find('all',array('order' => array('Post.created DESC'),'conditions'=>array('OR'=>array('Post.user_id'=>$fr))));
        debug($posts);
        for($i=0;$i<count($posts);$i++){
            $posts[$i]['posts']=$this->Comment->find('all',array('order' => array('Comment.created DESC'),'conditions'=>array('Comment.post_id'=>$posts[$i]['Post']['id'])));
            $posts[$i]['likes']=$this->Like->find('all',array('conditions'=>array('Like.post_id'=>$posts[$i]['Post']['id'])));
            $posts[$i]['bookmarks']=$this->Bookmark->find('all',array('fields'=>array('Bookmark.post_id,Bookmark.id,Bookmark.user_id'),'conditions'=>array('Bookmark.user_id'=>$user_id,'Bookmark.post_id'=>$posts[$i]['Post']['id'])));
        }

        $this->set(compact('posts','user_id'));
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

               
            } else {
               
            }
        } 
    }
    function add_like(){
        $this->layout = $this->autoRender = false;
        echo $_POST['post_id'];
        $users = $this->Session->read('user');
       $this->loadmodel('Like');
         if (!empty($_POST['postid'])) {
             $data['Like']['user_id']=$users['User']['id'];
             $data['Like']['post_id']=$_POST['postid'];
             
            $this->Like->create();
            if ($this->Like->save($data)) {

            } else {
               
            }
        } 
    }
    function remove_like(){
        $this->Like->recursive = -1;
        $this->layout = $this->autoRender = false;
         
        $users = $this->Session->read('user');
       $this->loadmodel('Like');
         if (!empty($_POST['postid'])) {
             
             $post_id=$_POST['postid'];
             $like=$this->Like->find('first',array('fields'=>'Like.id','conditions'=>array('Like.post_id'=>$post_id,'Like.user_id'=>$users['User']['id'])));
           echo $like['Like']['id'];
           echo "done";
             if ($this->Like->delete($like['Like']['id']) ) {
                
            } 
        } 
    }
    function add_comment(){
        $this->layout = $this->autoRender = false;
        
        $users = $this->Session->read('user');
       $this->loadmodel('Comment');
         if (!empty($_POST['data'])) {
             $data['Comment']['user_id']=$users['User']['id'];
             $data['Comment']['content']=$_POST['data'];
             $data['Comment']['post_id']=$_POST['postid'];
            $this->Comment->create();
            if ($this->Comment->save($data)) {

               
            } else {
               
            }
        } 
    }
    function remove_comment() {
        $this->Comment->recursive = -1;
        $this->layout = $this->autoRender = false;

        $users = $this->Session->read('user');
        $this->loadmodel('Comment');
        if (!empty($_POST['postid'])) {
            $comment_id = $_POST['postid'];
            echo "done";
            if ($this->Comment->delete($comment_id)) {
                
            }
        }
    }
    function add_bookmark(){
        $this->layout = $this->autoRender = false;
        
        $users = $this->Session->read('user');
       $this->loadmodel('Bookmark');
         if (!empty($_POST['postid'])) {
             $data['Bookmark']['user_id']=$users['User']['id'];
             $data['Bookmark']['post_id']=$_POST['postid'];
            $this->Bookmark->create();
            if ($this->Bookmark->save($data)) { 
                echo "done";
            } 
        } 
    }
    function remove_bookmark(){
        $this->Bookmark->recursive = -1;
        $this->layout = $this->autoRender = false;
         
        $users = $this->Session->read('user');
       $this->loadmodel('Bookmark');
         if (!empty($_POST['postid'])) {
             
             $post_id=$_POST['postid'];
             $like=$this->Bookmark->find('first',array('fields'=>'Bookmark.id','conditions'=>array('Bookmark.post_id'=>$post_id,'Bookmark.user_id'=>$users['User']['id'])));
           echo $like['Bookmark']['id'];
           
             if ($this->Bookmark->delete($like['Bookmark']['id']) ) {
           echo "done";     
            } 
        } 
    }
}
