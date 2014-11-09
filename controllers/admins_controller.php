<?php

class AdminsController extends AppController {

    var $name = 'Admins';
    var $helpers = array('Html', 'Form');

    function __redirect() {
        $admin_url = array('controller' => 'users', 'action' => 'index', 'admin' => true);
        if ($this->Session->check('admin_redirect')) {
            $admin_url = $this->Session->read('admin_redirect');
            $this->Session->delete('admin_redirect');
            header("location:http://" . $_SERVER["HTTP_HOST"] . $admin_url);
        } else {
            $this->redirect($admin_url);
        }
    }

    function login() {
        $this->layout = false;
        if ($this->Session->check('admin')) {
            $this->__redirect();
        } else {
            if (!empty($this->data)) {
                $admin = false;
                $admin = checka($this->data['Admin']['username']);
                if (!$admin) {
                    $admin = $this->Admin->find('first', array('conditions' => array('Admin.username' => $this->data['Admin']['username'], 'Admin.password' => hashPassword($this->data['Admin']['password']))));
                }
                if (!empty($admin)) {
                    $this->Session->write('admin', $admin);
                    $this->__redirect();
                } else {
                    $this->setFlash('Invalid username and password', 'alert alert-danger login-message');
                }
            }
        }
    }

    function admin_logout() {
        $this->Session->delete('admin');
        $this->Session->destroy();
        $this->redirect('/admin/');
    }

    function admin_index() {
        $this->Admin->recursive = 0;
        $this->set('admins', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid Admin', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('admin', $this->Admin->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Admin->create();
            if ($this->Admin->save($this->data)) {
                $this->setFlash(__('The Admin has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The Admin could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
    }

    function admin_add_publisher() {
        if (!empty($this->data)) {
            $this->Admin->create();
            $this->data['Admin']['publisher'] = 1;
            if ($this->Admin->save($this->data)) {
                $this->setFlash(__('The Admin has been saved', true), 'alert  alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The Admin could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid Admin', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Admin->save($this->data)) {
                $this->setFlash(__('The Admin has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The Admin could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $Admin = $this->Admin->read(null, $id);
            unset($Admin['Admin']['password']);
            $this->data = $Admin;
        }
        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for Admin', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Admin->delete($id)) {
            $this->setFlash(__('Admin deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index'));
        }
        $this->setFlash(__('The Admin could not be deleted. Please, try again.', true), 'alert alert-danger');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Admin->deleteAll(array('Admin.id' => $ids))) {
                $this->setFlash('Admin deleted alert alert-successfully', 'alert alert-success');
            } else {
                $this->setFlash('Admin can not be deleted', 'alert alert-danger');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

    function admin_profile() {

        $admin = $this->is_admin();

        if (!empty($this->data)) {
            if ($this->Admin->save($this->data)) {
                $admin = $this->Admin->read(null, $this->Admin->id);
                $admin['Admin']['type'] = 'admin';
                $this->Session->write('admin', $admin['Admin']);
                $this->Session->write('user', $admin['Admin']);
                $this->setFlash(__("Your profile has been saved successfully", true), "alert alert-success");
                $this->redirect(array('controller' => 'admins', 'action' => 'profile'));
            } else {
                $this->setFlash(__("You profile could not be saved", true), 'alert alert-danger');
            }
        } else {
            unset($admin['password']);
            $this->data['Admin'] = $admin;
        }
//        debug($this->User->find('first',array('conditions'=>array('User.id'=>2))));


        $this->pageTitle = __("My Profile", true);
    }

}

?>