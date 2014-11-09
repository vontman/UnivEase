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
    
  var $helpers = array('Html','Ajax','Javascript','Session');
    var $components = array('RequestHandler','Session');
    
    function index($id=0){
        if($id!=0){
            $this->loadModel('Group');
            $this->Group->id=$id;
            if(!$this->Group->exists()){
                $this->setFlash(__("Group Doesn't Exist",true),'alert alert-danger');
                $this->redirect(array('controller'=>'posts','action'=>'index'));
            }
        }
        $this->set('group_id',$id);
    }
    function add_upload(){
        $this->autoRender=false;
        $this->layout='ajax';
        $this->Upload->create();
        $group_id=$this->data['Upload']['group_id'];
        if(!empty($this->data)){
                if($this->uploadFile()){            
                    $users=$this->Session->read('user');
                    $this->data['Upload']['user_id']=$users['User']['id'];
                    if($this->Upload->save($this->data)){
                        $this->setFlash(__('The file was uploaded successfully',true),'alert alert-success');
                        if($group_id==0){
                            $this->redirect(array('controller'=>'posts','action'=>'index',$group_id));
                        }else{
                            $this->redirect(array('controller'=>'groups','action'=>'index',$group_id));
                        }
                    }else{
                        $this->setFlash(__('Upload Failed !!',true),'alert alert-danger');
                        print_r($this->data['Upload']);
                    }
                }else{
                    $this->setFlash(__('Upload Failed',true),'alert alert-danger');
                    if($group_id==0){
                        $this->redirect(array('controller'=>'posts','action'=>'index',$group_id));
                    }else{
                        $this->redirect(array('controller'=>'groups','action'=>'index',$group_id));
                    }
                }
            $this->set('file',$this->data);
        }
    }
    function uploadFile() {
        $mod_name=  explode('.',$this->data['Upload']['name']);
        $this->data['Upload']['name']=$mod_name[0];
        $file = $this->data['Upload']['File'];
        $array=explode('.',$file['name']);
        $this->data['Upload']['type']=array_pop($array);
        $type=$this->data['Upload']['type'];
        if($type!='pdf' && $type!='jpg' && $type!='gif' && $type!='png' && $type!='doc' && $type!='docx' && $type!='ppt' &&$type!='pptx' ){
            $this->setFlash(__('The filetype not supported',true),'alert alert-danger');
            $this->redirect(array('action'=>'index',$this->data['Upload']['group_id']));
        }elseif($this->Upload->hasAny(array('Upload.name'=>$this->data['Upload']['name'],'Upload.folder_id'=>$this->data['Upload']['folder_id']))){
            $this->setFlash(__('The filename already exists',true),'alert alert-warning');
            $this->redirect(array('action'=>'index',$this->data['Upload']['group_id']));
        }elseif($this->data['Upload']['File']['size']>(10*1024*1024)){
            $this->setFlash(__('File is Too Large',true),'alert alert-danger');
            $this->redirect(array('action'=>'index',$this->data['Upload']['group_id']));
        }else{
            $this->data['Upload']['post_type']=0;
            $this->data['Upload']['size']=$file['size'];
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
    }
   function uploads_ajax($group_id,$type,$folder_id=0,$back_id=0){
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
        if($folder_id!=0){
            $folder=$this->UploadFolder->findById($folder_id);
            $back_id=$folder['UploadFolder']['folder_id'];
        }
        $this->set(compact(array('group','folder_id','back_id','group_id','folders')));
   }

    function add_folder($group_id,$name,$folder_id=0){
        $users=$this->Session->read('user');
        $this->layout='ajax';
        $this->loadModel('UploadFolder');
        $this->UploadFolder->recursive=-1;
        $this->UploadFolder->create();
        if($this->UploadFolder->hasAny(array('UploadFolder.name'=>$name,'UploadFolder.group_id'=>$group_id,'UploadFolder.folder_id'=>$folder_id))){
            $this->Session->setFlash(__('Folder Already exists !!', true), 
                        'default', 
                         array('class' => 'alert alert-danger'));
        }else{
            $folder=array('name'=>$name,'group_id'=>$group_id,'folder_id'=>$folder_id,'user_id'=>$users['User']['id']);
            if(!$this->UploadFolder->save($folder)){
                $this->Session->setFlash(__('Folder Creation Failed !!', true), 
                                        'default', 
                                         array('class' => 'alert alert-danger'));
            }else{
                $this->Session->setFlash(__('Folder added Successfully !!', true), 
                        'default', 
                         array('class' => 'alert alert-success'));
            }
        }
        $this->redirect(array('action'=>'index')); // ???!?!?!?!?!?!?
    }
}
