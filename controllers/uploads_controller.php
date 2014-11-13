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
    var $components = array('RequestHandler','Session','Image');
    
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
                $user=$this->Session->read('user');
                $this->data['Upload']['user_id']=$user['User']['id'];
                if($this->uploadFile()){            
                    if($this->Upload->save($this->data)){
                        $this->setFlash(__('The file was uploaded successfully',true),'alert alert-success');
                        if($group_id==0){
                            $this->redirect(array('controller'=>'uploads','action'=>'index',$group_id));
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
                        $this->redirect(array('controller'=>'uploads','action'=>'index',$group_id));
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
        }elseif($this->data['Upload']['File']['size']>(25*1024*1024)){
            $this->setFlash(__('File is Too Large',true),'alert alert-danger');
            $this->redirect(array('action'=>'index',$this->data['Upload']['group_id']));
        }else{
            $this->data['Upload']['post_type']=0;
            $this->data['Upload']['size']=$file['size'];
            $id=String::uuid();
            $this->data['Upload']['fileid']=$id;
//                $destination=WWW_ROOT . 'uploaded/groups' . DS .$this->data['Upload']['name'].".".$this->data['Upload']['type'];
            if($this->data['Upload']['group_id']==0){
                    $newfolder=new folder(APP . 'uploaded/users' . DS . $this->data['Upload']['user_id'],true);
                    $destination=APP . 'uploaded/users' . DS . $this->data['Upload']['user_id'] . DS . $this->data['Upload']['name'].$id.".".$this->data['Upload']['type'];
            }else{
                    $newfolder=new folder(APP . 'uploaded/groups' . DS . $this->data['Upload']['group_id'],true);
                    $destination=APP . 'uploaded/groups' . DS . $this->data['Upload']['group_id'] . DS .$this->data['Upload']['name'].$id.".".$this->data['Upload']['type'];
            }
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                if($this->data['Upload']['type']=='jpg' || $this->data['Upload']['type']=='gif' || $this->data['Upload']['type']=='png' ){
                    $icon =new ImageComponent();
                    $icon->prepare($destination);
                    $icon->resize(50,55);               
                    if($this->data['Upload']['group_id']==0){
                        $newfolder=new folder(WWW_ROOT . 'img/uploaded_icons/users' . DS . $this->data['Upload']['user_id'],true);
                        $icon->save(WWW_ROOT . 'img/uploaded_icons/users' . DS . $this->data['Upload']['user_id'] . DS .$this->data['Upload']['fileid'].".".$this->data['Upload']['type']);
                    }else{
                        $newfolder=new folder(WWW_ROOT . 'img/uploaded_icons/groups' . DS . $this->data['Upload']['group_id'],true);
                        $icon->save(WWW_ROOT . 'img/uploaded_icons/groups' . DS . $this->data['Upload']['group_id'] . DS .$this->data['Upload']['fileid'].".".$this->data['Upload']['type']);
                    }
                }
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
    function delete_file($id){
        $this->autoRender=false;
        $this->layout='ajax';
        $this->Upload->recursive=-1;
        if(!$this->Upload->exists($id)){
            $this->setFlash(__("File doesn't exist !",true),'alert alert-danger');
            $this->redirect('/');
        }
        $uploaded_file=$this->Upload->findById($id);
        $user=$this->Session->read("user");
        if($user['User']['id']==$uploaded_file['Upload']['user_id']){
            if($uploaded_file['Upload']['group_id']==0){
                $file=new File(APP . 'uploaded/users' . DS . $uploaded_file['Upload']['user_id'] . DS .$uploaded_file['Upload']['name'].$uploaded_file['Upload']['fileid'].".".$uploaded_file['Upload']['type']);
            }else{
                $file=new File(APP . 'uploaded/groups' . DS . $uploaded_file['Upload']['group_id'] . DS .$uploaded_file['Upload']['name'].$uploaded_file['Upload']['fileid'].".".$uploaded_file['Upload']['type']);
            }
            if($file->delete()){
                if($uploaded_file['Upload']['group_id']==0){
                    $file=new File(WWW_ROOT . 'img/uploaded/users' . DS . $uploaded_file['Upload']['user_id'] . DS .$uploaded_file['Upload']['fileid'].".".$uploaded_file['Upload']['type']);
                }else{
                    $file=new File(WWW_ROOT . 'img/uploaded/groups' . DS . $uploaded_file['Upload']['group_id'] . DS .$uploaded_file['Upload']['fileid'].".".$uploaded_file['Upload']['type']);
                }
                $file->delete();
                if($this->Upload->delete($id)){
                    $this->setFlash(__('File deleted successfully',true),'alert alert-success');
                    $this->redirect(array('action'=>'index'));
                }
            }else{
                $this->setFlash(__('File deleted successfully',true),'alert alert-success');
                $this->redirect(array('action'=>'index'));
            }
        }else{
            $this->setFlash(__('Permission Denied !',true),'alert alert-danger');
            $this->redirect('/');
        }
    }
    function delete_folder($id){
        $this->autoRender=false;
        $this->layout='ajax';
        $this->loadModel('UploadFolder');
        if(!$this->UploadFolder->exists($id)){
            $this->setFlash(__("Folder doesn't exist !",true),'alert alert-danger');
            $this->redirect('/');
        }
        $this->UploadFolder->recursive=-1;
        $file=$this->UploadFolder->findById($id);
        $user=$this->Session->read("user");
        if($user['User']['id']==$file['user_id']){
            if($this->UploadFolder->delete($id)){
                $this->setFlash(__('Folder deleted successfully',true),'alert alert-success');
                $this->redirect(array('action'=>'index'));
            }
        }else{
            $this->setFlash(__('Permission Denied !',true),'alert alert-danger');
            $this->redirect('/');
        }
    }
}
