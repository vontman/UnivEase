<?php

class UsersController extends AppController {

    var $name = 'Users';

    /**
     * @var User */
    var $User;
    var $components = array('Email');

    function __redirect() {
        $user = $this->Session->read('user');

        if (empty($user)) {
            $admin_url = array('controller' => 'users', 'action' => 'dashboard', 'admin' => true, 'prefix' => 'admin');
//            if ($this->Session->check('admin_redirect')) {
//                $admin_url = $this->Session->read('admin_redirect');
//                $this->Session->delete('admin_redirect');
//                header("location:http://" . $_SERVER["HTTP_HOST"] . $admin_url);
//            } else {
            $this->redirect($admin_url);
//            }
        } else {
            $admin_url = array('controller' => 'users', 'action' => 'dashboard');
            if ($this->Session->check('user_redirect')) {
                $admin_url = $this->Session->read('user_redirect');
                $this->Session->delete('user_redirect');
                header("location:http://" . $_SERVER["HTTP_HOST"] . $admin_url);
            } else {
                $this->redirect($admin_url);
            }
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
                    $user = $this->User->find('first', array('conditions' => array('User.username' => $this->data['User']['username'], 'User.password' => hashPassword($this->data['User']['password']))));
                }
                if (!empty($user['User']['id'])) {
                    if (!isset($user['User']['user_type']) && $user['User']['approved']) {
                        $this->Session->write('user', $user['User']);
                        $this->__redirect();
                    } else {
                        $this->setFlash('Your account needed to be approve', 'alert alert-error login-message');
                    }
                } else {
                    $this->setFlash('Invalid username and password', 'alert alert-error login-message');
                }
            }
        }
    }

    function logout() {
        $this->Session->delete('user');
        $this->Session->delete('admin');
//            $this->Session->destroy();
        $this->redirect('/');
    }

    function profile() {

        if (!$this->is_user()) {
            $this->redirect('/login');
        }

        $user = $this->is_user();

        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $user = $this->User->read(null, $this->User->id);

                $this->Session->write('user', $user['User']);
                $this->setFlash(__("Your profile has been saved successfully", true), "alert alert-success");
                $this->redirect(array('controller' => 'users', 'action' => 'profile'));
            } else {
                $this->setFlash(__("You profile could not be saved", true), 'alert alert-error');
            }
        } else {

            $this->data['User'] = $user;
        }
//        debug($this->User->find('first',array('conditions'=>array('User.id'=>2))));


        $this->pageTitle = __("My Profile", true);
    }

    function admin_index() {
        $this->User->recursive = 0;
        $conditions = array();
        $users = $this->paginate('User', $conditions);
        $this->set('users', $users);
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid user', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    function admin_add($group_id = false) {
        if (!empty($this->data)) {
            $this->User->create();
            if ($this->User->save($this->data)) {
                $this->setFlash(__('The user has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The user could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid user', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->User->save($this->data)) {
                $this->setFlash(__('The user has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The user could not be saved. Please, try again.', true), 'alert alert-error');
            }
        }
        if (empty($this->data)) {
            $user = $this->User->read(null, $id);
            unset($user['User']['password']);
            $this->data = $user;
        }
        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for user', true), 'alert alert-error');
            $this->redirect(array('action' => 'index'));
        }

        $this->loadModel('Section');
        $this->loadModel('CourseUser');
        $this->CourseUser->deleteAll(array('CourseUser.user_id' => $id));
        $sections = $this->Section->find('all', array('conditions' => array(" concat(',',Section.students,',') like '%,{$id},%' ",)));
        if (!empty($sections)) {
            foreach ($sections as $section) {
                if (!empty($section['Section']['students'])) {

                    foreach ($section['Section']['students'] as $key => $student) {
                        if ($student == $id) {
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

        $user = $this->User->read(null, $id);
        if ($this->User->delete($id)) {
            $this->setFlash(__('User deleted', true), 'alert alert-success');
            $this->redirect($this->referer());
        }
        $this->setFlash(__('User was not deleted', true), 'alert alert-error');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        $user = $this->User->read(null, $ids[0]);
        if ($operation == 'delete') {
            if ($this->User->deleteAll(array('User.id' => $ids))) {
                $this->setFlash(__('User deleted alert alert-successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('User can not be deleted', true), 'alert alert-error');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_import() {
        if (!empty($this->data)) {
            $file_name = $this->data['User']['file']["name"];
            $pos = strrpos($file_name, '.');
            $extension = "";
            if ($pos !== false) {
                $extension = low(substr($file_name, $pos + 1));
            }
            if (low($extension) == "csv" && $this->data['User']['file']['error'] == UPLOAD_ERR_OK) {
                App::import('Vendor', 'csv-class', array('file' => 'csv-class.php'));
                $file = $this->data['User']['file']['tmp_name'];
                $delimiter = empty($this->data['User']['delimiter']) ? "," : $this->data['User']['delimiter'];
                $csv = new File_CSV_DataSource;
                $csv->settings(array('delimiter' => $delimiter));
                $csv->load($file);
                $data_array = $csv->getrawArray();
                debug($data_array);
                die;

                $count = 0;
                $failed = 0;
                $failedCode = array();

                set_time_limit(0);
                ini_set('memory_limit', '128M');
                $Errors = array();
                $counter = 0;
                foreach ($data_array as $line) {
//                    if ($counter == 0 && !$this->User->CSV_titles($line)) {
//                        $this->setFlash("There is an error in the schema", 'alert alert-error');
//                        break;
//                    }
//                    if ($counter > 0) {
                    $result = $this->User->validate_imported_user($line);
                    if (empty($result['errors'])) {
                        $user = $result['data']['User'];
                        $this->User->create();
//                            Configure::write('debug', 2);
                        if ($this->User->save(array('User' => $user), array('callbacks' => false))) {
                            ++$count;
                        } else {
                            ++$failed;
                            $failedCode[] = array('errors' => (empty($this->User->validationErrors) ? array('Unknown Error') : $this->User->validationErrors), 'record_num' => $counter);
                        }
                    } else {
                        ++$failed;

                        $failedCode[] = array('errors' => $result['errors'], 'record_num' => $counter);
                    }
//                    }
                    $counter++;
                }

                $processed = true;
                $this->set(compact('count', 'Errors', 'failed', 'failedCode', 'processed'));
                fclose($fh);
            } else {
                $this->setFlash(__('Error uploading file', true), 'alert alert-error');
            }
            $this->data = array();
        }
    }

    function get_students($level_id) {
        Configure::write('debug', 0);
        $this->layout = $this->autoRender = false;
        $subcategories = $this->User->find('all', array('conditions' => array('User.level_id' => $level_id), 'fields' => array('id', 'name'), 'recursive' => -1));

        $submenus['submenus'] = $subcategories;
        echo

        json_encode($submenus);
    }

    function get_students_by_course($course_id) {
//        Configure::write('debug', 0);
        $this->layout = $this->autoRender = false;
        $subcategories = $this->User->getStudentsByCourse($course_id, 'all');
        $submenus['submenus'] = $subcategories;

        echo json_encode($submenus);
    }

    function get_all_students_by_course($course_id, $sections = false) {
//        Configure::write('debug', 0);
        $this->layout = $this->autoRender = false;
        $subcategories = $this->User->getStudentsByCourse($course_id, 'all', $sections);
        $submenus['submenus'] = $subcategories;

        echo json_encode($submenus);
    }

    function dashboard() {
        $user = $this->is_user();
        if (!$user) {
            $this->redirect('/login');
        }

        $this->loadModel('CourseUser');
        $this->loadModel('Course');
        $this->CourseUser->recursive = 0;

        $courses = $this->CourseUser->find('all', array('conditions' => array('CourseUser.user_id' => $user['id'])));

        if (!empty($courses)) {

            foreach ($courses as $key => $course) {
                if ((!isset($course['Group']['allowed_permissions'][7]) && $course['Course']['active'] == 1) || isset($course['Group']['allowed_permissions'][7])) {
                    $find_course = $this->Course->find('first', array('conditions' => array('Course.id' => $course['CourseUser']['course_id'])));
                    $courses[$key]['Course'] = $find_course['Course'];
                } else {
                    unset($courses[$key]);
                }
            }
        }

        $this->set('courses', $courses);
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

            if ($this->User->save($this->data)) {
                $id = $this->User->getLastInsertID();
                if ($this->config['user_activation'] == 1) {
                    $user = $this->User->read(null, $id);
                    $this->set('user_data', $user['User']);
                    $this->Email->to = $user['User']['email'];
                    $name = $user['User']['name'];
                    $subject = "{$this->config['site_name']}: " . __('Confirm your account', true) . " " . $name;
                    $this->Email->sendAs = 'html';
                    $this->Email->layout = 'contact';
                    $this->Email->template = 'register';
                    $this->Email->from = $this->config['site_name'] . '<' . $this->config['admin_send_mail_from'] . '>';
                    $this->Email->subject = $subject;
                    $this->Email->send();
                    $this->setFlash('A message has been sent to confirm your registration', 'alert alert-success', 'register');
                } else {
                    $this->setFlash(__('You have been registered successfully, we sould waiting for approving', true), 'alert alert-success', 'register');
                }
               
            } else {
                $this->setFlash(__('The user could not be saved. Please, try again.', true), 'alert alert-error', 'register');
            }
        }
        
    }

    function confirm($confirm_code = false) {

        if (!$confirm_code) {
            $this->setFlash('Invalid security code', 'alert alert-error');
            $this->redirect('/');
        }

        $seeds = explode('-', base64_decode($confirm_code));
        $id = $seeds[0];
        $email = $seeds[1];
        $user = $this->User->read(null, $id);
        if ($user['User']['email'] != $email) {
            $this->setFlash('Invalid security code', 'alert alert-error', 'register');
            $this->redirect('/');
        } else {
            $this->User->create();
            $this->User->id = $id;
            if ($this->User->saveField('approved', '1')) {
                $this->setFlash('Your account has been actived successfully', 'alert alert-success');
                $this->redirect('/');
            }
        }
    }

    function forget_password() {
        $this->layout = false;
        if (!empty($this->data)) {
            $user = $this->User->Forget($this->data);

            if (!empty($user)) {
                $this->set('user_data', $user);
                $this->Email->to = $user['User']['email'];
                $name = $user['User']['name'];
                $subject = "{$this->config['site_name']}: reset your password " . $name;
                $this->Email->sendAs = 'html';
                $this->Email->layout = 'contact';
                $this->Email->template = 'reset';
                $this->Email->from = $this->config['site_name'] . '<' . $this->config['admin_send_mail_from'] . '>';
                $this->Email->subject = $subject;
                $this->Email->send();
                $this->setFlash('A message has been sent to confirm reset your passowrd', 'alert alert-success', 'forget');

                $this->data = array();

                $this->redirect("/");
            } else {
                $this->setFlash(__('Could not reset your password', true), 'alert alert-error', 'forget');
            }
        }

        $this->render('login');
    }

    function reset_password($hash_data) {
        $this->layout = false;
        if (!$hash_data) {
            $this->setFlash(__('Wrong Data', true));
            $this->redirect('/');
        } else {

            $seeds = base64_decode($hash_data);
            $parts = explode('#', $seeds);
            $email = $parts[0];

            $user = $this->User->find('first', array('conditions' => array('User.email' => $email)));
            $type = false;
            if (empty($user)) {
                $this->loadModel('Admin');
                $admin = $this->Admin->find('first', array('conditions' => array('Admin.email' => $email)));
                if (!empty($admin)) {
                    $user['User'] = $admin['Admin'];
                    $type = 'admin';
                }
            }
            $new_passowrd = substr(md5(rand()), 0, 6);
            if (!empty($user)) {
                $this->set('new_passowrd', $new_passowrd);
                $this->set('user_data', $user);
                if ($type == 'admin') {
                    $this->Admin->updateAll(array('Admin.password' => '\'' . hashPassword($new_passowrd) . '\''), array('Admin.id' => $user['User']['id']));
                } else {
                    $this->User->updateAll(array('User.password' => '\'' . hashPassword($new_passowrd) . '\''), array('User.id' => $user['User']['id']));
                }

                $this->Email->to = $user['User']['email'];
                $name = $user['User']['name'];
                $subject = "{$this->config['site_name']}: New password " . $name;
                $this->Email->sendAs = 'html';
                $this->Email->layout = 'contact';
                $this->Email->template = 'newpassword';
                $this->Email->from = $this->config['site_name'] . '<' . $this->config['admin_send_mail_from'] . '>';
                $this->Email->subject = $subject;
                $this->data = array();

                if ($this->Email->send()) {
                    $this->setFlash(__("Your new password has been sent to your email address", true), "alert alert-success", 'forget');
                    $this->redirect('/#toforget');
                } else {
                    $this->setFlash(__("Failed to send your new password. Please try again", true), "alert alert-error", 'forget');
                }
            } else {
                $this->setFlash(__('Wrong Data', true));
                $this->redirect('/');
            }
        }
    }

    function admin_confirm($id) {
        if (!$id) {
            $this->setFlash(__('Invalid id for User', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        $this->User->id = $id;
        if ($this->User->saveField('approved', '1')) {
            $user = $this->User->read(null, $id);
            $user_data = $user['User'];
            $this->set('user_data', $user_data);
            $this->Email->to = $user['User']['email'];
            $subject = "{$this->config['site_name']}:" . __('Your account has been confirmed', true);
            $this->Email->sendAs = 'html';
            $this->Email->layout = 'contact';
            $this->Email->template = 'approve';
            $this->Email->from = $this->config['site_name'] . '<' . $this->config['admin_send_mail_from'] . '>';
            $this->Email->subject = $subject;
            $this->Email->send();

            $this->setFlash('The User has confirmed successfully', 'alert alert-success');
            $this->redirect(array('action' => 'index'));
        }
    }

}

