<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of uploads_controller
 *
 * @author omar
 */
class UploadsController extends AppController{
    
    var $name = 'Uploads';

    /**
     * @var Group */
    var $Upload;
    
  var $helpers = array('Html','Ajax','Javascript');
    var $components = array('RequestHandler');
    
    function index(){
        
    }
    function add_upload(){
        $this->autoRender=false;
        $this->layout='ajax';
        $this->Upload->create();
        $group_id=$this->data['Upload']['group_id'];
        if(!empty($this->data)){
            if($this->data['Upload']['File']['size']<(10*1024*1024)){
                if($this->uploadFile(0)){            
                    $users=$this->Session->read('user');
                    $this->data['Upload']['user_id']=$users['User']['id'];
                    $this->Upload->save($this->data);
                    $this->setFlash(__('The file was uploaded successfully',true),'alert alert-success');
                    $this->redirect(array('action'=>'index',$group_id));
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
   function uploads_ajax($type,$group_id=0,$folder_id=0,$back_id=0){
       $this->layout='ajax';
        $this->Upload->recursive=-1;
        $this->loadModel('UploadFolder');
        $this->UploadFolder->recursive=-1;
        $folders=$this->UploadFolder->find('all',array('conditions'=>array('group_id'=>$group_id,'folder_id'=>$folder_id)));
        if($type=='all'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('group_id'=>$group_id,'folder_id'=>$folder_id)));
        }elseif($type=='pdf'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.type'=>'pdf','group_id'=>$group_id,'folder_id'=>$folder_id),'order'=>'Upload.name'));
        }elseif($type=='doc'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.type'=>array('doc','docx'),'group_id'=>$group_id,'folder_id'=>$folder_id),'order'=>'Upload.name'));
        }elseif($type=='ppt'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.type'=>array('ppt','pptx'),'group_id'=>$group_id,'folder_id'=>$folder_id),'order'=>'Upload.name'));
        }elseif($type=='img'){
            $group['uploads']=$this->Upload->find('all',array('conditions'=>array('Upload.type'=>array('gif','jpg','png'),'group_id'=>$group_id,'folder_id'=>$folder_id),'order'=>'Upload.name'));
        }
        $this->set(compact(array('group','folder_id','back_id','group_id','folders')));
   }
    function uploadFile($type) {
            $mod_name=  explode('.',$this->data['Upload']['name']);
            $this->data['Upload']['name']=$mod_name[0];
            $file = $this->data['Upload']['File'];
            $this->data['Upload']['post_type']=0;
            $this->data['Upload']['group_id']=$this->data['Upload']['group_id'];
            $array=explode('.',$file['name']);
            $this->data['Upload']['type']=array_pop($array);
//            if($type==0){
                $destination=WWW_ROOT . 'uploaded/groups' . DS .$this->data['Upload']['name'].".".$this->data['Upload']['type'];
//            }elseif($type==1){
//                $destination=WWW_ROOT . 'uploads/courses' . DS .$this->data['Upload']['name'].$this->data['Upload']['type'];
//            }
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return true;
            }else{
                return false;
            }
        }
        function add_folder($name,$group_id=0,$folder_id=0){
            $users=$this->Session->read('user');
            $this->layout='ajax';
            $this->loadModel('UploadFolder');
            $this->UploadFolder->create();
            $folder=array('name'=>$name,'group_id'=>$group_id,'folder_id'=>$folder_id,'user_id'=>$users['User']['id']);
            $this->UploadFolder->save($folder);
            return true;
        }
}
