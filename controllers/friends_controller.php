<?php

class FriendsController extends AppController {

    var $name = 'Friends';
    /*
0 wait for friend request..
1 friends
2 refused
3 block
     *      */
    var $Freind;


   
function request(){
    $this->loadmodel('Friend');
    $this->Friend->recursive = 0;
    $user=$this->Session->read('user');
    if(!empty($this->data)){
        $this->Friend->create();
        
        debug($this->data);
        $this->data['Friend']['u1_id']=$user['User']['id'];
        $this->data['Friend']['u2_id']=$this->data['Friend']['id'];
        $this->data['Friend']['status']=0;
        if($this->Friend->save($this->data)){
            $this->setFlash(__('the request has been send', true), 'alert alert-success');
            $this->redirect(array('controller'=>'users','action'=>'profile'));
        }
    }
    
    $requests=$this->Friend->find('all',array('conditions'=>array('Friend.u2_id'=>$user['User']['id'],'Friend.status'=>'0')));
    
    $this->set(compact('requests'));
}
  function friend(){
       $this->loadmodel('Friend');
    $this->Friend->recursive = 0;
    $user=$this->Session->read('user');
  
    
    $friends=$this->Friend->find('all',array('conditions'=>array('OR'=>array('Friend.u1_id'=>$user['User']['id'],'Friend.u2_id'=>$user['User']['id']),'Friend.status'=>'1')));
    
    $this->set(compact('friends')); 
    }
  function getFriends() {
        $this->layout = $this->autoRender = false;
        $this->loadmodel('User');

        $data = array();

        $users = $this->User->find('all',array('conditions'=>array('')));

        foreach ($users as $i => $user) {
                $data[] = array('User' => array('id' => $user['User']['id'], 'name' => $user['User']['name']));
        }
        
        $submenus['submenus'] = $data;

        echo json_encode($submenus);
    }
function accept($id=FALSE){
    $this->layout = $this->autoRender = false;
     $this->loadmodel('Friend');
     
    $process=$this->Friend->updateAll(array('status' => 1), array('Friend.id' =>$id ));
    if($process){
        $this->setFlash(__('The Request has been accepted', true), 'alert alert-success');
        $this->redirect(array('action'=>'request'));
    }
}
function refuse($id=FALSE){
    $this->layout = $this->autoRender = false;
     $this->loadmodel('Friend');
     
    $process=$this->Friend->updateAll(array('status' => 2), array('Friend.id' =>$id ));
    if($process){
        $this->setFlash(__('The Request has been refused', true), 'alert alert-success');
        $this->redirect(array('action'=>'request'));
    }
}
function unfriend($id=FALSE){
    $this->layout = $this->autoRender = false;
     $this->loadmodel('Friend');
     
    $process=$this->Friend->delete($id);
    if($process){
        $this->setFlash(__('The Friend deleted', true), 'alert alert-success');
        $this->redirect(array('action'=>'friend'));
    }
}
function block($id=FALSE){
    $this->layout = $this->autoRender = false;
     $this->loadmodel('Friend');
     
    $process=$this->Friend->updateAll(array('status' => 3), array('Friend.id' =>$id ));
    if($process){
        $this->setFlash(__('The Friend has been blocked', true), 'alert alert-success');
        $this->redirect(array('action'=>'friend'));
    }
}
}