<?php

uses('L10n');

class AppController extends Controller {

    var $helpers = array('Html', 'Form', 'Javascript', 'Fck', 'Text', 'Session');
    var $components = array('Session', 'Cookie');
    var $config = '';
    var $pageTitle;

    function beforeFilter() {
      $this->Session->check('user');
        $this->disableCache();
        $lang = $this->_setLanguage();
        $config = $this->__load_config();
        $timezone = $this->_setDefaultTimezone();
        
        $this->set('config', $config);
        
        $this->lang = $lang;
        $prefix = (!isset($this->params['prefix'])) ? '' : $this->params['prefix'];

        
    }

    function beforeRender() {
        parent::beforeRender();
        $this->__change_title();
        $prefix = (!isset($this->params['prefix'])) ? '' : $this->params['prefix'];

        if ($prefix != 'admin') {
            
        }
      
        
		$class_nums = array('One','Two','Three','four','Five','Six','Seven');	 	
	    $this->set(compact('class_nums'));
    }

    function setFlash($message, $class = 'fail', $key = 'flash') {
        $this->Session->setFlash(__($message, true), 'default', array('class' => $class), $key);
    }

    function is_admin() {
        if ($this->Session->check('admin')) {
            return $this->Session->read('admin');
        } else {
            $this->Session->write('admin_redirect', $_SERVER["REQUEST_URI"]);
            return false;
        }
    }

    function is_user() {
        if ($this->Session->check('user')) {
            return $this->Session->read('user');
        } else {
            $this->Session->write('user_redirect', $_SERVER["REQUEST_URI"]);
            return false;
        }
    }

    function __has_report_perm()
    {
        $user = $this->Session->read('user');
        if (!empty($user))
        {
            $this->loadModel('CourseUser');
            $teacher_courses = $this->CourseUser->find('all',array('conditions' => 
                    'CourseUser.user_type In (select groups.id from groups where groups.permissions LIKE "%19%")'.
                        ' And CourseUser.user_id=' . $user['id']));
            $student_courses = $this->CourseUser->find('all',array('conditions' => 
                    'CourseUser.user_type In (select groups.id from groups where groups.permissions LIKE "%18%")'.
                        ' And CourseUser.user_id=' . $user['id']));
           
            if($this->is_admin()){
                 return 1;
            }
            if(!empty($teacher_courses))
            {
                return 2;
            }
            elseif($student_courses){
                return 2;
            }
            else 
            {
                return 0;
            }
        }
        return 0;
    }
    
    function is_student() {
        $user = $this->Session->read('user');
        if (!empty($user) && $user['User']['group_id'] == 2) {

            return $user;
        } else {
            $this->Session->write('user_redirect', $_SERVER["REQUEST_URI"]);
            $this->redirect('/');
            die();
        }
    }

    function is_teacher() {
        $user = $this->Session->read('user');
        if (!empty($user) && $user['group_id'] == 1) {
            return $user;
        } else {
            $this->Session->write('user_redirect', $_SERVER["REQUEST_URI"]);
            $this->redirect('/');
            die();
        }
    }

    function _setLanguage() {
        $lang = 'ar';
        $dir = 'rtl';
        if (isset($this->params['language'])) {
            $lang = $this->params['language'];
            $this->Session->write('Config.language', $this->params['language']);
            if ($lang != 'ar') {
                $dir = 'ltr';
           }
//
//            $this->L10n = new L10n();
//            $this->L10n->get($this->params['language']);
        $lang = Configure::read('Config.language');
        }
//        $this->Session->write('Config.language', $lang);
        $this->set('lang', $lang);
       $this->set('dir', $dir);
//        return $lang;
    }

    function set_language($lang = false) {
        $this->L10n = new L10n();
        $this->L10n->get($lang);
        Configure::write('Config.language', $lang);
        $this->Session->write('Config.language', $lang);
        $this->redirect($this->referer());
    }

    function admin_set_language($lang = false) {
        $this->L10n = new L10n();
        $this->L10n->get($lang);
        Configure::write('Config.language', $lang);
        $this->Session->write('Config.language', $lang);
        $this->redirect($this->referer());
    }

    function admin_delete_field($id, $field) {
        $model = Inflector::classify($this->name);
        $this->$model->id = $id;
        $basename = $this->$model->find('first', array('callbacks' => false));

        if (!empty($basename)) {
            $this->$model->deleteFile($field, $id, $basename[$model][$field]);
        }
        //$this->$model->create();
        $data = array($model => array('id' => $id, $field => ''));

        if ($this->$model->save($data, array('callbacks' => false))) {
//            debug($data);exit;
            $this->setFlash("The {$field} has been deleted successfully", 'alert alert-success');
            $this->redirect(array('action' => 'edit', $id));
        }
    }

    function delete_field($id, $field, $row = false) {
        $model = Inflector::classify($this->name);
        $this->$model->id = $id;
        $basename = $this->$model->find('first', array('callbacks' => false));

        if (!empty($basename)) {
            $this->$model->deleteFile($field, $id, $basename[$model][$field]);
        }
        //$this->$model->create();
        if ($row) {
            if ($this->$model->delete($id)) {
                $this->setFlash("The Row has been deleted successfully", 'alert alert-success');
                $this->redirect($this->referer());
            }
        } else {
            $data = array($model => array('id' => $id, $field => ''));

            if ($this->$model->save($data, array('callbacks' => false))) {
//            debug($data);exit;
                $this->setFlash("The {$field} has been deleted successfully", 'alert alert-success');
                $this->redirect($this->referer());
            }
        }
    }

    function get_user_info($course_id) {
        if ($this->is_admin()) {
            return $this->get_course($course_id);
        }
        $user = $this->is_user();
        if (!$user) {
            $this->redirect('/');
        }
        $this->loadModel('CourseUser');
        $course_user = $this->CourseUser->find('first', array('conditions' => array('CourseUser.user_id' => $user['id'], 'CourseUser.course_id' => $course_id)));
        $this->loadModel("Section");
        $course_user['User']["Sectios"] = $this->Section->find("list", array("fields" => array("Section.course_id", "Section.id"), "conditions" => array(" concat(',',Section.students,',') like '%,{$user['id']},%' ")));
        $this->set('cuser', $course_user);
//      debug($course_user);
        return $course_user;
    }
    

    function get_course($id) {
        $this->loadModel('Course');
        $this->Course->recursive = -1;
        $course_user = $this->Course->read(null, $id);
        $this->set('cuser', $course_user);
        return $course_user;
    }

    function get_current_course($course_id) {
        $this->loadModel('Course');
        $course = $this->Course->find('first', array('conditions' => array('Course.id' => $course_id)));
        $this->set('ccourse', $course);
        $this->set('cuser', $course);
        return $course;
    }

    function __change_title($title = false) {

        $prefix = empty($this->params['prefix']) ? '' : $this->params['prefix'];
        if (strtolower($prefix) == 'admin') {

            $prefix = empty($this->params['prefix']) ? false : $this->params['prefix'];
            $action = $this->params['action'];
            if ($prefix) {
                $titleArr[] = Inflector::humanize($this->params['prefix']);
                $action = substr($action, strlen("{$prefix}_"));
            }
            //$titleArr[] = $this->titleAlias;
            if (strtolower($action) != 'index') {
                $titleArr[] = Inflector::humanize($action);
            }
        } else {
            $titleArr = array($this->config['site_name']);
            $titleArr[] = $this->pageTitle;
        }

        $this->set('title_for_layout', implode(' - ', $titleArr));

        if ($this->params['action'] == 'home') {
            $this->set('title_for_layout', $this->config['site_name']);
        }
    }

    function __load_config() {
        $this->loadModel('Configuration');
        $configurations = $this->Configuration->read(null, 1);
        $this->config = $configurations['Configuration'];
//        debug($this->config);
        return $this->config;
    }

    function get_snippets($key = null) {
        $this->loadModel('Snippet');
        $snippet = $this->Snippet->find('first', array('conditions' => array('Snippet.key' => $key)));
        return $snippet['Snippet']['content'];
    }

//    function _is_user() {
//        $data = false;
//        if (!$this->Session->check('Teacher') && !$this->Session->check('Student')) {
//            $this->redirect('/login/');
//        } 
////        return $data;
//    }
    function _setDefaultTimezone() {
        if (!empty($this->config['timezone'])) {
            date_default_timezone_set($this->config['timezone']);
        }
    }

}

?>