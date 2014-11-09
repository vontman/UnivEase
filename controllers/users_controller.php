<?php

class UsersController extends AppController {

    var $name = 'Users';

    /**
     * @var User */
    var $User;
    var $components = array('Email');
   public $helpers = array('Js');
    function __redirect() {
        $user = $this->Session->read('user');

        if (empty($user)) {
            $admin_url = array('controller' => 'users', 'action' => 'dashboard_home');
//            if ($this->Session->check('admin_redirect')) {
//                $admin_url = $this->Session->read('admin_redirect');
//                $this->Session->delete('admin_redirect');
//                header("location:http://" . $_SERVER["HTTP_HOST"] . $admin_url);
//            } else {
            $this->redirect($admin_url);
//            }
        } else {
             //$user=$this->is_user;
             //$this->redirect(array('controller'=>'posts','action' => 'index'));
           //$admin_url = array('controller'=>'user','action' => 'index');
           $this->redirect( array('controller'=>'posts','action' => 'index'));
            /*if($user["username"]=="parent"){
                $this->redirect(array('action' => 'index'));
            }else{
            if ($this->Session->check('user_redirect')) {
                $admin_url = $this->Session->read('user_redirect');
                $this->Session->delete('user_redirect');
                header("location:http://" . $_SERVER["HTTP_HOST"] . $admin_url);
            } else {
                $this->redirect($admin_url);
            }
        }*/
        }
    }

    function login() {
        
        $this->layout = false;
        
        if ($this->Session->check('user')) {
           
            $this->__redirect();
        } elseif ($this->Session->check('admin')) {
            $this->__redirect();
        } else {
            if (!empty($this->data)) {
                $user = false;
                
                
                $user = checka($this->data['User']['username'], $this->data['User']['password']);
                if ($user) {
                    
                    
                    
                    $this->Session->write('admin', $user['User']);
                    
                    $this->__redirect();
                }
                if (!$user) {
                      $this->User->recursive = 0;
                    $user = $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.password' => hashPassword($this->data['User']['password']))));
                    
                    
                }
                if (!empty($user['User']['id'])) {
                    if (!isset($user['User']['user_type']) && $user['User']['approved']) {
                        $this->loadModel("Courses");
                        $this->Courses->recursive = 0;
                        $this->loadModel('CourseUser');
                        $enrolled_courses=$this->CourseUser->find('all',array('fields'=>'Course.id,Course.name','conditions'=>array('CourseUser.user_id'=>$user['User']['id'])));
                        //$courses = $this->Courses->find('all');
                        foreach($enrolled_courses as $enroll =>$value){
                        $en[]=$value['Course'];}
                        debug($en);
                        
                        
                        $user['Courses'] = $en;
                        
                        
                        
                        $this->Session->write('user', $user);
                     
                        $this->__redirect();
                    } else {
                        $this->setFlash('Your account needed to be approve', 'alert alert-danger login-message');
                    }
                } else {
                    $this->setFlash('Invalid username and password', 'alert alert-danger login-message');
                }
            }
        }
    }

    function logout()
    {
        $this->Session->delete('user');
        $this->Session->delete('admin');
           $this->Session->destroy();
        $this->redirect('/');
    }
    function user(){
        $users = $this->Session->read('user');
        $this->loadmodel('Post');
        $this->Posts->recursive = 0;
        
        $posts=$this->Post->find('all',array('order' => array('Post.created DESC'),'conditions'=>array('Post.type_id'=>0,'Post.user_id'=>$users['User']['id'])));
        $this->set('posts',$posts);
    }
     
    function profile()
    {
        $user = $this->Session->read('user');
        $this->loadModel('CategoryUser');
        $this->loadModel('CourseUser');
        $this->CourseUser->recursive = 0;
        $this->loadModel('Category');
        $this->loadModel('Course');
         $user_id=$user['User']["id"];
        $faculty_id=$user['User']['faculty_id'];
        $category=$this->CategoryUser->find('list',array('fields'=>'CategoryUser.id,CategoryUser.category_id','conditions'=>array('CategoryUser.user_id '=>$user_id)));
     
        if(!$category){
            $courses=0;
            $category=$this->Category->find('list',array('fields'=>'Category.id,Category.name','conditions'=>array('Category.faculty_id'=>$faculty_id)));
        }else{
          
           foreach($user['Courses'] as $enroll){
              
               $en[]=$enroll['id'];
           }
           
            $courses=$this->Course->find('list',array('fields'=>'Course.id,Course.name','conditions'=>array('Course.category_id'=>$category,
                "NOT" => array( "Course.id" => $en )
                )));
         $category=0;
            
        }
       
    
      $this->set(compact('enrolled_courses','user','category','courses'));
    
     
     
     
        
    }
     function submit_categ()
    {
         
         $user = $this->Session->read('user');
        $this->loadmodel('CategoryUser');
        if (!empty($this->data)) {
            $category["CategoryUser"]["category_id"]=$this->data['User']['category_id']; 
            $category["CategoryUser"]["user_id"]=$user['User']['id'];
             $category["CategoryUser"]["user_type"]=0;
             debug($category);
            $this->CategoryUser->create();
       
            if ($this->CategoryUser->save($category)) {
                
              
                $this->setFlash(__('The category has been submitted', true), 'alert alert-success');
                $this->redirect(array('action'=>'profile'));
               
            } else {
                $this->setFlash(__('The Category could not be subnitted. Please, try again.', true), 'alert alert-danger');
                $this->redirect(array('action'=>'profile'));
            }
        }
        
        
    }
      function submit_courses()
    {
         
         $user = $this->Session->read('user');
        $this->loadmodel('CourseUser');
        if (!empty($this->data)) {
            $course["CourseUser"]["course_id"]=$this->data['User']['course_id']; 
             $course["CourseUser"]["user_id"]=$user['User']['id']; 
             $course["CourseUser"]["user_type"]=0;
             
            $this->CourseUser->create();
       
            if ($this->CourseUser->save($course)) {
                
              
                $this->setFlash(__('The course has been submitted', true), 'alert alert-success');
                $this->redirect(array('action'=>'profile'));
               
            } else {
                $this->setFlash(__('The course could not be subnitted. Please, try again.', true), 'alert alert-danger');
                $this->redirect(array('action'=>'profile'));
            }
        }
        
        
    }
    function index() {
            $this->User->recursive = 0;
        $conditions = array();
        $users = $this->paginate('User', $conditions);
        $userss = $this->User->find('all', array('recursive' => -1));
        $this->set('users', $users);
        $this->set('userss', $userss);
    
       /* $user = $this->is_user();
        if($user!=="teacher"){
        $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));     
        }*/
        
    }

   
	function admin_dashboard_home() {
            $this->loadmodel('Faculty');
            $this->loadmodel('Category');
            $this->loadmodel('Admin');
            $this->Faculty->recursive = -1;
            $this->Category->recursive = -1;
            $this->Admin->recursive = -1;
            $faculty=$this->Faculty->find('count');
            $category=$this->Category->find('count');
            $admin=$this->Admin->find('count');
            $this->set(compact('faculty','category','admin'));
        $this->layout = 'default_admin';
        $this->pageTitle = __('Home', true);
    }
	
    function admin_dashboard() {
        $this->loadModel('Category');
        $categories = $this->Category->find('threaded');
        $this->set('categories', $categories);
        $this->pageTitle = __('Home', true);
    }


            
    function register() {
        $this->layout = false;
        	
        if (!empty($this->data)) {
            $this->User->create();
            $this->data['User']['approved']=1;
            if ($this->User->save($this->data)) {
                $id = $this->User->getLastInsertID();
		if($this->uploadFile()){
                   return true; 
                }		else{
                    $this->setFlash('error uploading image', 'alert alert-danger', 'register');
                    return false;
                }
                $salt = substr(md5(uniqid(mt_rand(), true)), 0, 3);
                $usr_pass = md5(md5($this->data['User']['password']) . md5($salt));
               
		return $this->render('login');
                if ($this->config['user_activation'] == 1) {
                    $user = $this->User->read(null, $id);
                    $this->set('user_data', $user['User']);
                    $this->Email->to = $user['User']['email'];
                    $name = $user['User']['name'];
            
                    $this->setFlash('A message has been sent to confirm your registration', 'alert alert-success', 'register');
                    
                } else {
                    $this->setFlash(__('You have been registered successfully, we sould waiting for approving', true), 'alert alert-success', 'register');
                }
               
            } else {
                $this->setFlash(__('The user could not be saved. Please, try again.', true), 'alert alert-danger', 'register');
            }
        }
        $this->loadModel('Faculty');
             
            $faculties=$this->Faculty->find('list',array('fields'=>'Faculty.id,Faculty.name'));
            $this->set('faculty', $faculties);
    }
    function uploadFile() {
  $file = $this->data['User']['image'];
  if ($file['error'] === UPLOAD_ERR_OK) {
    $id = String::uuid();
    if (move_uploaded_file($file['tmp_name'], APP.'webroot'.DS.'data'.DS.$id.$file['name'])) {
   
      return true;
    }
  }
  return false;
}
    function categ_add_ajax() {
        die();
        $faculty_id = $this->params['url']['faculty_id'];
        
    // Fill select form field after Ajax request.
         $this->loadModel('Category');
    $category = $this->Category->find('list', array('fields'=>'Category.id,Category.name','conditions' => array('Category.faculty_id'=>$faculty_id)));
   
  
         $this->set('category',$category);
    $this->layout = 'ajax';
     }
     function courses_add_ajax() {
        
        $category_id = $this->params['url']['category_id'];
        
    // Fill select form field after Ajax request.
         $this->loadModel('Course');
    $courses = $this->Course->find('list', array('fields'=>'Category.id,Category.name','conditions' => array('Course.category_id'=>$category_id)));
   
  
         $this->set('courses',$courses);
    $this->layout = 'ajax';
     }


	function admin_find()
    {
        $user_id = $_GET['txtuserid'];
        $user = $this->User->find('first', array('conditions' => array('User.id =' . $user_id)));

        if(!empty($user))
        {  
            $this->set('user', $user['User']);
        }
        else
        {
            $this->setFlash(__("Sorry, can not find that user", true), "alert alert-danger");     
            $this->redirect(array('controller'=>'users','action' => 'index'));
         }
    }

}

