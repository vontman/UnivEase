<?php

class CourseUsersController extends AppController {

    var $name = 'CourseUsers';

    /**
     * @var CourseUser */
    var $CourseUser;

    
    public $helpers = array('Js');
    
    function admin_index($course_id)
    {
        $this->CourseUser->recursive = 0;
        $this->get_current_course($course_id);
        $this->set('courseUsers', $this->paginate('CourseUser', array('CourseUser.course_id' => $course_id)));
        $this->set('types', $this->CourseUser->Group->find('list'));
        $this->set('course_id', $course_id);
    }

    function index($course_id=false) {
     //   die("$course_id");
        $user = $this->get_user_info($course_id);
        $status=$user['User']['status'];
        $this->CourseUser->recursive = 0;
        $this->loadModel('User');
        $this->set('courseUsers', $this->paginate('CourseUser', array('CourseUser.course_id' => $course_id, 'CourseUser.user_id !=' => $user['User']['id'])));
        $firstyear = $this->User->find('all', array('conditions' => array('Year(User.created) =' => date('Y')), 'order' => 'User.id'));

        foreach ($firstyear as $user) {
            $first[$user['User']['id']] = $user['User']['name'];
        }


        $this->set('types', $this->CourseUser->Group->find('list'));
        $this->set('course_id', $course_id);
        $this->set('users', $first);
        $this->set('status', $status);
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid course user', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('courseUser', $this->CourseUser->read(null, $id));
    }
    
    function admin_add_all($course_id = false) {
        $this->loadModel("Course");
        $this->loadModel("User");
        $this->loadModel("CourseUser");
        /* $courses = $this->Course->find("list");
         unset($courses[$course_id]); */
        $error = array();
        $done = 0;

        $firstyear = $this->User->find('all', array('recursive' => -1,'fields' => 'User.id,User.name','conditions' => array('Year(User.created) =' => date('Y')), 'order' => 'User.id'));
        //debug($firstyear);
        //$this->get_user_info($course_id);
        foreach ($firstyear as $user) {
           // $first[$user['User']['id']] = $user['User']['name'];
            $allowed_courses = $this->Course->find('first', array('recursive' => -1,'conditions' => array('Course.id ='.$course_id )));
            $pre = $allowed_courses['Course']['pre'];
            $check = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id ='.$course_id.' AND CourseUser.user_id =' . $user['User']['id'])));
            $data_e["CourseUser"]["user_id"] =  $user['User']['id'];
            $data_e["CourseUser"]["course_id"] = $course_id;
            //debug($this->CourseUser->save($data_e));
            $this->CourseUser->create();
            
            if ($pre > 0) {

                $request = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $allowed_courses['Course']['pre'] . ' AND CourseUser.user_id =' . $user['User']['id'])));
                if ($request['CourseUser']['status'] == 0) {

                    $error[] = $uesr["User"]["id"] . "haven't succed in the pre request";
                } elseif ($check['CourseUser']['user_id'] == $user['User']['id']) {

                    $error[] = $user["User"]["id"] . "already en rolled in this course";
                } else {
                    // foreach ($this->data['CourseUser']['user_id'] as $user_id) {
                    // $this->CourseUser->create();
                    // $this->data['CourseUser']['user_id'] = $user_id;
                    
                    if ($this->CourseUser->save($data_e)) {
                        $done+=1;
                    } else {
                        $error[] = $user["User"]["name"] . "not saved";
                    }
                }
            } else {
                if ($check['CourseUser']['user_id'] == $user['User']['id']) {
                    $error[] = $user["User"]["name"] . "already en rolled in this course";
                } else {
                    if ($this->CourseUser->save($data_e)) {
                        $done+=1;
                    } else {
                        $error[] = $user["User"]["name"] . "not saved";
                    }
                }
            }
            
        }
        //debug($error);
        $this->set(compact('done', 'error'));
        $this->set('error',$error);
        $this->redirect(array('action' => 'index',$course_id));
    }
    
    
    
     function add_all($course_id = false) {
        $this->loadModel("Course");
        $this->loadModel("User");
        $this->loadModel("CourseUser");
        /* $courses = $this->Course->find("list");
         unset($courses[$course_id]); */
        $error = array();
        $done = 0;

        $firstyear = $this->User->find('all', array('recursive' => -1,'fields' => 'User.id,User.name','conditions' => array('Year(User.created) =' => date('Y')), 'order' => 'User.id'));
        //debug($firstyear);
        //$this->get_user_info($course_id);
        foreach ($firstyear as $user) {
           // $first[$user['User']['id']] = $user['User']['name'];
            $allowed_courses = $this->Course->find('first', array('conditions' => array('Course.id ='.$course_id )));
            $pre = $allowed_courses['Course']['pre'];
            $check = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id ='.$course_id.' AND CourseUser.user_id =' . $user['User']['id'])));
            $data_e["CourseUser"]["user_id"] =  $user['User']['id'];
            $data_e["CourseUser"]["course_id"] = $course_id;
            //debug($this->CourseUser->save($data_e));
            $this->CourseUser->create();
            
            if ($pre > 0) {

                $request = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $allowed_courses['Course']['pre'] . ' AND CourseUser.user_id =' . $user['User']['id'])));
                if ($request['CourseUser']['status'] == 0) {

                    $error[] = $uesr["User"]["id"] . "haven't succed in the pre request";
                } elseif ($check['CourseUser']['user_id'] == $user['User']['id']) {

                    $error[] = $user["User"]["id"] . "already en rolled in this course";
                } else {
                    // foreach ($this->data['CourseUser']['user_id'] as $user_id) {
                    // $this->CourseUser->create();
                    // $this->data['CourseUser']['user_id'] = $user_id;
                    
                    if ($this->CourseUser->save($data_e)) {
                        $done+=1;
                    } else {
                        $error[] = $user["User"]["name"] . "not saved";
                    }
                }
            } else {
                if ($check['CourseUser']['user_id'] == $user['User']['id']) {
                    $error[] = $user["User"]["name"] . "already en rolled in this course";
                } else {
                    if ($this->CourseUser->save($data_e)) {
                        $done+=1;
                    } else {
                        $error[] = $user["User"]["name"] . "not saved";
                    }
                }
            }
            
        }
        //debug($error);
        $this->set(compact('done', 'error'));
        $this->set('error',$error);
        $this->redirect(array('action' => 'index',$course_id));
    }
    

    function admin_add($course_id = false, $filterd_id = false) {
        $this->loadModel("Course");
        $this->loadModel("CourseUser");
        $courses = $this->Course->find("list");
        unset($courses[$course_id]);

        $this->set("courses", $courses);
        $this->get_user_info($course_id);

         if (!empty($this->data)) {

            if (!empty($this->data['CourseUser']['user_id'])) {
                if($this->data['CourseUser']['user_type']==1){
                    
                     if ($this->CourseUser->save($this->data)) {
                            $this->setFlash(__('The teacher has been added', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The teacher could not be added. Please, try again.', true), 'alert alert-error');
                        }
                }
                else{
                $allowed_courses = $this->Course->find('first', array('recursive' => -1,'conditions' => array('Course.id =' . $this->data['CourseUser']['course_id'])));
                $pre = $allowed_courses['Course']['pre'];
                $check = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $this->data['CourseUser']['course_id'] . ' AND CourseUser.user_id =' . $this->data['CourseUser']['user_id'])));
                if ($pre > 0) {

                    $request = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $allowed_courses['Course']['pre'] . ' AND CourseUser.user_id =' . $this->data['CourseUser']['user_id'])));
                    if ($request['CourseUser']['status'] == 0) {
                        $this->setFlash(__('You have to succed in the pre request.', true), 'alert alert-error');
                    } elseif ($check['CourseUser']['user_id'] == $this->data['CourseUser']['user_id']) {
                        $this->setFlash(__('You already enrolled .', true), 'alert alert-error');
                    } else {
                        // foreach ($this->data['CourseUser']['user_id'] as $user_id) {
                        // $this->CourseUser->create();
                        // $this->data['CourseUser']['user_id'] = $user_id;

                        if ($this->CourseUser->save($this->data)) {
                            $this->setFlash(__('The course user has been savsed', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
                        }
                    }
                } else {
                    if ($check['CourseUser']['user_id'] == $this->data['CourseUser']['user_id']) {
                        $this->setFlash(__('You already enrolled .', true), 'alert alert-error');
                    } else {
                        if ($this->CourseUser->save($this->data)) {
                            $this->setFlash(__('The course user has been savsed', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
                        }
                    }
                }
            }

                $this->redirect(array('action' => 'index', $this->data['CourseUser']['course_id']));
            } else {
                $this->setFlash(__('Please choose at least one user to be enrolled in course, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {

            $this->data['CourseUser']['course_id'] = $course_id;
        }
        $extra_cond = "";
        if ($filterd_id) {
            $extra_cond = ' AND User.id In (select course_users.user_id from course_users where course_users.course_id=' . $filterd_id . ')';
            $this->data["CourseUser"]["course"] = $filterd_id;
        }
        $users = $this->CourseUser->User->find('list', array('conditions' => array('User.id Not In (select course_users.user_id from course_users where course_users.course_id=' . $course_id . ')' . $extra_cond)));
        $this->set('userTypes', $this->CourseUser->Group->find('list'));
        $this->set(compact('users'));
    }

    function add($course_id = false, $filterd_id = false) {
        $this->loadModel("Course");
        $this->loadModel("CourseUser");
        $courses = $this->Course->find("list");
        unset($courses[$course_id]);

        $this->set("courses", $courses);
        $this->get_user_info($course_id);

        if (!empty($this->data)) {

            if (!empty($this->data['CourseUser']['user_id'])) {
                if($this->data['CourseUser']['user_type']=="1"){
                     if ($this->CourseUser->save($this->data)) {
                            $this->setFlash(__('The teacher has been added', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The teacher could not be added. Please, try again.', true), 'alert alert-error');
                        }
                }
                else{
                $allowed_courses = $this->Course->find('first', array('recursive' => -1,'conditions' => array('Course.id =' . $this->data['CourseUser']['course_id'])));
                $pre = $allowed_courses['Course']['pre'];
                $check = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $this->data['CourseUser']['course_id'] . ' AND CourseUser.user_id =' . $this->data['CourseUser']['user_id'])));
                if ($pre > 0) {

                    $request = $this->CourseUser->find('first', array('recursive' => -1,'fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $allowed_courses['Course']['pre'] . ' AND CourseUser.user_id =' . $this->data['CourseUser']['user_id'])));
                    if ($request['CourseUser']['status'] == 0) {
                        $this->setFlash(__('You have to succed in the pre request.', true), 'alert alert-error');
                    } elseif ($check['CourseUser']['user_id'] == $this->data['CourseUser']['user_id']) {
                        $this->setFlash(__('You already enrolled .', true), 'alert alert-error');
                    } else {
                        // foreach ($this->data['CourseUser']['user_id'] as $user_id) {
                        // $this->CourseUser->create();
                        // $this->data['CourseUser']['user_id'] = $user_id;

                        if ($this->CourseUser->save($this->data)) {
                            $this->setFlash(__('The course user has been savsed', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
                        }
                    }
                } else {
                    if ($check['CourseUser']['user_id'] == $this->data['CourseUser']['user_id']) {
                        $this->setFlash(__('You already enrolled .', true), 'alert alert-error');
                    } else {
                        if ($this->CourseUser->save($this->data)) {
                            $this->setFlash(__('The course user has been savsed', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
                        }
                    }
                }
            }

                $this->redirect(array('action' => 'index', $this->data['CourseUser']['course_id']));
            } else {
                $this->setFlash(__('Please choose at least one user to be enrolled in course, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data['CourseUser']['course_id'] = $course_id;
        }
        $extra_cond = "";
        if ($filterd_id) {
            $extra_cond = ' AND User.id In (select course_users.user_id from course_users where course_users.course_id=' . $filterd_id . ')';
            $this->data["CourseUser"]["course"] = $filterd_id;
        }
        $users = $this->CourseUser->User->find('list', array('conditions' => array('User.id Not In (select course_users.user_id from course_users where course_users.course_id=' . $course_id . ')' . $extra_cond)));
        $this->set('userTypes', $this->CourseUser->Group->find('list'));
        $this->set(compact('users'));
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid course user', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $course_user = $this->CourseUser->read(null, $id);
        $this->get_current_course($course_user['CourseUser']['course_id']);
        if (!empty($this->data)) {
            if ($this->CourseUser->save($this->data)) {
                $this->setFlash(__('The course user has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $this->data['CourseUser']['course_id']));
            } else {
                $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data = $course_user;
        }
        $this->set('userTypes', $this->CourseUser->Group->find('list'));
        $users = $this->CourseUser->User->find('list', array('conditions' => array('recursive' => -1,'User.id Not In (select course_users.user_id from course_users where course_users.course_id=' . $course_user['CourseUser']['course_id'] . ')')));
        $this->set(compact('users'));
        $this->render('admin_add');
    }

    function edit($id = false) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid course user', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $course_user = $this->CourseUser->read(null, $id);
        $this->get_user_info($course_user['CourseUser']['course_id']);
        if (!empty($this->data)) {
            if ($this->CourseUser->save($this->data)) {
                $this->setFlash(__('The course user has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $this->data['CourseUser']['course_id']));
            } else {
                $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }

        if (empty($this->data)) {
            $this->data = $course_user;
        }
        
        $this->set('userTypes', $this->CourseUser->Group->find('list'));
        $users = $this->CourseUser->User->find('list', array('conditions' => array('User.id Not In (select course_users.user_id from course_users where course_users.course_id=' . $course_user['CourseUser']['course_id'] . ')')));
        $this->set(compact('users'));
        $this->render('add');
    }
  
     function student_cat_ajax() {
        $user=  $this->is_user();
        $user_id=$user["id"];
        $category_id = $this->params['url']['category_id'];
        
    // Fill select form field after Ajax request.
         $this->loadModel('Course');
    $enrolled_courses = $this->CourseUser->find('list', array('fields'=>'CourseUser.course_id','conditions' => array('CourseUser.user_id'=>$user_id)));
   
    $courses = $this->Course->find('list', array(
            'conditions' => array('Course.category_id' => $category_id,
                 "NOT" => array( "Course.id" => $enrolled_courses )
                ),
            'recursive' => -1
        ));
         $this->set('courses',$courses);
    $this->layout = 'ajax';
     }
     function approved_all($course_id=false){
         if(!$course_id){
                $this->redirect('/');
            }
            $this->loadModel('CourseUser');
            $this->CourseUser->create();
             //$this->CourseUser->course_id=$course_id;
             $done=$this->CourseUser->updateAll(array("approved"=>1), array('CourseUser.course_id'=>$course_id,'CourseUser.approved'=>0));
               if ($done) {
            $this->setFlash(__('The students has been approved', true), 'alert alert-success');
            $this->redirect(array('controller'=>'course_users','action' => 'index',$course_id));
            
        } else {
            $this->setFlash(__("The student couldn't approved", true), 'alert alert-error');
        }
     }
        function approved($course_id=false){
            if(!$course_id){
                $this->redirect('/');
            }
            
            $this->loadModel('CourseUser');
            $this->CourseUser->create();
             $this->CourseUser->id=$course_id;
             $done=$this->CourseUser->saveField("approved",1);
             $course_id = $this->params['url']['crs_id'];
             
            if ($done) {
            $this->setFlash(__('The student has been approved', true), 'alert alert-success');
            $this->redirect(array('controller'=>'course_users','action' => 'index',$course_id));
            
        } else {
            $this->setFlash(__("The student couldn't approved", true), 'alert alert-error');
        }
    }
    function student_add($user_id=false){
        $user=  $this->is_user();
        $user_id=$user["id"];
        $this->loadModel('User');
        $this->loadModel('CourseUser');
        $this->loadModel('Course');
        $this->loadModel('Category');
       $categ=$this->Category->find('list');
        $this->set('user_id',$user_id);
        
        
          if (!empty($this->data)) {
              $this->data['CourseUser']['user_type']=2;
              $this->data['CourseUser']['approved']=0;
               $this->CourseUser->create();
              
            if (!empty($this->data['CourseUser']['course_id'])) {
                $allowed_courses = $this->Course->find('first', array('conditions' => array('Course.id =' . $this->data['CourseUser']['course_id'])));
                $pre = $allowed_courses['Course']['pre'];
                $check = $this->CourseUser->find('first', array('fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $this->data['CourseUser']['course_id'] . ' AND CourseUser.user_id =' . $this->data['CourseUser']['user_id'])));
                if ($pre > 0) {

                    $request = $this->CourseUser->find('first', array('fields' => 'CourseUser.user_id,CourseUser.course_id,CourseUser.status', 'conditions' => array('CourseUser.course_id =' . $allowed_courses['Course']['pre'] . ' AND CourseUser.user_id =' . $this->data['CourseUser']['user_id'])));
                    if ($request['CourseUser']['status'] == 0) {
                        $this->setFlash(__('You have to successed in the pre request.', true), 'alert alert-error');
                    } elseif ($check['CourseUser']['user_id'] == $this->data['CourseUser']['user_id']) {
                        $this->setFlash(__('You already enrolled .', true), 'alert alert-error');
                    } else {
                        // foreach ($this->data['CourseUser']['user_id'] as $user_id) {
                        // $this->CourseUser->create();
                        // $this->data['CourseUser']['user_id'] = $user_id;

                        if ($this->CourseUser->save($this->data)) {
                            
                            $this->setFlash(__('The course user has been savsed', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
                        }
                    }
                } else {
                    if ($check['CourseUser']['user_id'] == $this->data['CourseUser']['user_id']) {
                        $this->setFlash(__('You already enrolled .', true), 'alert alert-error');
                    } else {
                        if ($this->CourseUser->save($this->data)) {
                            $lid=$this->CourseUser->getLastInsertId(); 
                            
                            
                            $this->setFlash(__('The course user has been savsed', true), 'alert alert-success');
                        } else {
                            $this->setFlash(__('The course user could not be saved. Please, try again.', true), 'alert alert-error');
                        }
                    }
                }


                $this->redirect(array('action' => 'student_add', $this->data['CourseUser']['course_id']));
            } else {
                $this->setFlash(__('Please choose at least one user to be enrolled in course, try again.', true), 'alert alert-error');
            }
        }
      
        $this->set(compact('user_id','users','categ','courses'));
       //  $this->redirect(array('action' => 'student_add'));
    }
    function delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for course user', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $course_user = $this->CourseUser->read(null, $id);
        if ($this->CourseUser->delete($id)) {
            $this->loadModel('Section');
            $sections = $this->Section->find('all', array('conditions' => array('Section.course_id' => $course_user['CourseUser']['course_id'])));
            if (!empty($sections)) {
                foreach ($sections as $section) {
                    if (!empty($section['Section']['students'])) {

                        foreach ($section['Section']['students'] as $key => $student) {
                            if ($student == $course_user['CourseUser']['user_id']) {
                                unset($section['Section']['students'][$key]);
                            }
                        }
                    }
                    if (!empty($section['Section']['students'])) {

                        $this->Section->updateAll(array('Section.students' => implode(',', $section['Section']['students'])), array('Section.id' => $section['Section']['id']));
                    } else {
                        $this->Section->delete($section['Section']['id']);
                    }
                }
            }
            $this->setFlash(__('Course user deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $course_user['CourseUser']['course_id']));
        }
        $this->setFlash(__('Course user was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index', $course_user['CourseUser']['course_id']));
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for course user', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $course_user = $this->CourseUser->read(null, $id);
        if ($this->CourseUser->delete($id)) {
            $this->loadModel('Section');
            $sections = $this->Section->find('all', array('conditions' => array('Section.course_id' => $course_user['CourseUser']['course_id'])));
            if (!empty($sections)) {
                foreach ($sections as $section) {
                    if (!empty($section['Section']['students'])) {

                        foreach ($section['Section']['students'] as $key => $student) {
                            if ($student == $course_user['CourseUser']['user_id']) {
                                unset($section['Section']['students'][$key]);
                            }
                        }
                    }
                    if (!empty($section['Section']['students'])) {

                        $this->Section->updateAll(array('Section.students' => implode(',', $section['Section']['students'])), array('Section.id' => $section['Section']['id']));
                    } else {
                        $this->Section->delete($section['Section']['id']);
                    }
                }
            }
            $this->setFlash(__('Course user deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $course_user['CourseUser']['course_id']));
        }
        $this->setFlash(__('Course user was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index'));
    }

    function do_operation() {
        $this->admin_do_operation();
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->CourseUser->deleteAll(array('CourseUser.id' => $ids))) {
                $this->setFlash(__('Course user deleted alert alert-successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Course user can not be deleted', true), 'alert alert-error');
            }
        } elseif ($operation == 'message') {
            $users_ids = $this->CourseUser->find("list", array("fields" => array("CourseUser.user_id", "CourseUser.user_id"), "conditions" => array("CourseUser.id" => $this->params['form']["chk"])));
            $this->data["Message"]["receiver_id"] = implode(",", $users_ids);
            $this->render("/messages/send");
        } elseif ($operation == 'sms') {
            $users_ids = $this->CourseUser->find("list", array("fields" => array("CourseUser.user_id", "CourseUser.user_id"), "conditions" => array("CourseUser.id" => $this->params['form']["chk"])));
            $this->data["Message"]["receiver_id"] = implode(",", $users_ids);
            $this->render("/messages/sendsms");
        } else
            $this->redirect($this->referer());
    }

    public function admin_teachers() {
        $course_id = $this->params['url']['data']['ScheduleDetail']['course_id'];
        //debug( $this->params['url']['data']);
        $this->loadModel('Group');
        $selected_groups = $this->Group->find('all', array('conditions' => array("Group.permissions LIKE  '%17%'")));

        for ($i = 0; $i < count($selected_groups); $i++) {
            $teacher_group[] = $selected_groups[$i]['Group']['id'];
        }
        $teacher_ids = $this->CourseUser->find('all', array('conditions' => array('CourseUser.course_id =' . $course_id . ' AND CourseUser.user_type' => $teacher_group)));

        for ($i = 0; $i < count($teacher_ids); $i++) {
            $teacher[$teacher_ids[$i]['CourseUser']['user_id']] = $teacher_ids[$i]['User']['name'];
        }

        $this->set('teacher', $teacher);
        $this->layout = 'ajax';
    }

}
