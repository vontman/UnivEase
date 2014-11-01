<?php

class CoursesController extends AppController {

    var $name = 'Courses';
    var $uses = array('Add','Course','Suadd');
    public $helpers = array('Js');
    /**
     * 
     * @var Course */
    var $Course;

	 
    function admin_index() {
        $this->Course->recursive = 0;
        $this->set('courses', $this->paginate('Course'));
    }

    function admin_add1($category_id = false) {
        if (!empty($this->data)) {
            $this->Course->create();
                if ($this->data['Course']['pre']) {
                    foreach ($this->data['Course']['pre'] as $key => $value) {
                        $this->data["Course"]["pre"] = $value;
                
                        //$id = $this->CourseUser->getLastInsertID();
                    }
                }else{
                     $this->data["Course"]["pre"] = 0;
                }
            if ($this->Course->save($this->data)) {
                
                $id = $this->Course->getInsertID();
                $path = WWW_ROOT . 'data/' . $id . '/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                if ($this->uploadFile($path)) {
                    return true;
                } else {
                    $this->setFlash('error uploading image', 'alert alert-error', 'register');
                    return false;
                }
                $this->setFlash(__('The course has been saved', true), 'alert alert-success');
               
            } else {
                $this->setFlash(__('The course could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
      if (empty($this->data)) {
            $this->loadModel('Faculty');
             
            $faculties=$this->Faculty->find('list',array('fields'=>'Faculty.id,Faculty.name'));
            $this->set('faculty', $faculties);
        }
       
        $this->set(compact('categories','course'));
    }
    
    function get_all_courses() {
//        Configure::write('debug', 0);
        $this->layout = $this->autoRender = false;
        $subcategories = $this->Course->getCourse('all');
        $submenus['submenus'] = $subcategories;

        echo json_encode($submenus);
    }
    
    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid course', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }

        $course = $this->Course->read(null, $id);
        if (!empty($this->data)) {
            $this->Course->addLevels($this->data);
            if ($this->Course->save($this->data)) {
                $id = $this->Course->id;
                $path = WWW_ROOT . 'data/' . $id . '/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $this->setFlash(__('The course has been saved', true), 'alert alert-success');
                $this->redirect(array('controller' => 'categories', 'action' => 'view', $this->data['Course']['category_id']));
            } else {
                $this->setFlash(__('The course could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $this->data = $course;
        }
        $this->loadModel('Level');
        $levels = $this->Level->find('all', array('conditions' => array('Level.course_id' => $id)));
        $categories = $this->Course->Category->findCategories();
        $this->set(compact('categories', 'levels'));
        $this->render('admin_add');
    }

    function admin_delete($id = null) {

        if (!$id) {
            $this->setFlash(__('Invalid id for course', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        $course = $this->Course->read(null, $id);
        if ($this->Course->delete($id)) {
            $this->loadModel('CourseUser');
            $this->CourseUser->deleteall(array('CourseUser.course_id' => $id));

            $this->loadModel('Assignment');
            $this->loadModel('Lesson');
            $this->loadModel('Event');
			$this->loadModel('Attendance');
            $this->loadModel('Exam');
            $this->loadModel('Level');
            $this->loadModel('ReportAttendance');
            $this->loadModel('ScheduleDetail');
            $this->loadModel('VirtualClassroom');
            $this->loadModel('Survey');
            $this->loadModel('Section');
            $this->loadModel('Announcement');
			
            $this->Assignment->deleteall(array('Assignment.course_id' => $id), true, true);
            $this->Lesson->deleteall(array('Lesson.course_id' => $id), true, true);
            $this->Event->deleteall(array('Event.course_id' => $id), true, true);
            $this->Attendance->deleteall(array('Attendance.course_id' => $id), true, true);
            $this->Exam->deleteall(array('Exam.course_id' => $id), true, true);
            $this->Level->deleteall(array('Level.course_id' => $id), true, true);
            $this->ReportAttendance->deleteall(array('ReportAttendance.course_id' => $id), true, true);
            $this->ScheduleDetail->deleteall(array('ScheduleDetail.course_id' => $id), true, true);
            $this->VirtualClassroom->deleteall(array('VirtualClassroom.course_id' => $id), true, true);
            $this->Survey->deleteall(array('Survey.course_id' => $id), true, true);
            $this->Section->deleteall(array('Section.course_id' => $id), true, true);
            $this->Announcement->deleteall(array('Announcement.course_id' => $id), true, true);

            $this->setFlash(__('Course deleted', true), 'alert alert-success');
            $this->redirect(array('controller' => 'categories', 'action' => 'view', $course['Course']['category_id']));
        }
        $this->setFlash(__('Course was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Course->deleteall(array('Course.id' => $ids))) {
                $this->setFlash(__('Course deleted alert alert-successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Course can not be deleted', true), 'alert alert-error');
            }
        }
        $this->redirect($this->referer());
    }
  function admin_categ_add_ajax() {
        
        $faculty_id = $this->params['url']['faculty_id'];
        
    // Fill select form field after Ajax request.
         $this->loadModel('Category');
    $category = $this->Category->find('list', array('fields'=>'Category.id,Category.name','conditions' => array('Category.faculty_id'=>$faculty_id)));
   
  
         $this->set('category',$category);
    $this->layout = 'ajax';
     }
  function uploadFile($path) {
  $file = $this->data['Course']['image'];
  if ($file['error'] === UPLOAD_ERR_OK) {
    $id = String::uuid();
    if (move_uploaded_file($file['tmp_name'],$path.DS.$file['name'])) {
   
      return true;
    }
  }
  return false;
}
}