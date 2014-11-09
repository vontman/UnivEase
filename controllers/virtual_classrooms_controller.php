<?php

class VirtualClassroomsController extends AppController {

    var $name = 'VirtualClassrooms';

    /**
     * @var VirtualClassroom */
    var $VirtualClassroom;

    function admin_index($course_id) {
        $this->VirtualClassroom->recursive = 0;
        $user = $this->get_current_course($course_id);
        $conditions = array('VirtualClassroom.course_id' => $course_id, 'VirtualClassroom.level_id' => $_GET['level']);
        $this->set('virtualClassrooms', $this->paginate('VirtualClassroom', $conditions));
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid virtual classroom', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('virtualClassroom', $this->VirtualClassroom->read(null, $id));
    }

    function admin_add($course_id) {
        $user = $this->get_current_course($course_id);
        if (!empty($this->data)) {
            $this->data['VirtualClassroom']['level_id'] = $_GET['level'];
            $this->data['VirtualClassroom']['course_id'] = $course_id;
            $this->VirtualClassroom->create();
            if ($this->VirtualClassroom->save($this->data)) {
                $this->setFlash(__('The virtual classroom has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $this->data['VirtualClassroom']['course_id'], '?' => array('level' => $this->data['VirtualClassroom']['level_id'])));
            } else {
                $this->setFlash(__('The virtual classroom could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        $this->set('course_id', $course_id);
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid virtual classroom', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $classroom = $this->VirtualClassroom->read(null, $id);
        $user = $this->get_current_course($classroom['VirtualClassroom']['course_id']);
        if (!empty($this->data)) {
            if ($this->VirtualClassroom->save($this->data)) {
                $this->setFlash(__('The virtual classroom has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $classroom['VirtualClassroom']['course_id'], '?' => array('level' => $classroom['VirtualClassroom']['level_id'])));
            } else {
                $this->setFlash(__('The virtual classroom could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->data = $classroom;
        }

        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for virtual classroom', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $classroom = $this->VirtualClassroom->read(null, $id);
        if ($this->VirtualClassroom->delete($id)) {
            $this->setFlash(__('Virtual classroom deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $classroom['VirtualClassroom']['course_id'], '?' => array('level' => $classroom['VirtualClassroom']['level_id'])));
        }
        $this->setFlash(__('Virtual classroom was not deleted', true), 'alert alert-danger');
        $this->redirect(array('action' => 'index', $classroom['VirtualClassroom']['course_id'], '?' => array('level' => $classroom['VirtualClassroom']['level_id'])));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->VirtualClassroom->deleteAll(array('VirtualClassroom.id' => $ids))) {
                $this->setFlash(__('Virtual classroom deleted successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Virtual classroom can not be deleted', true), 'alert alert-danger');
            }
        }
        $this->redirect($this->referer());
    }

    function index($course_id = false) {
        $this->VirtualClassroom->recursive = 0;
        $user = $this->get_user_info($course_id);
        $conditions = array('VirtualClassroom.course_id' => $course_id, 'VirtualClassroom.level_id' => $_GET['level']);
        $this->set('virtualClassrooms', $this->paginate('VirtualClassroom', $conditions));
    }

    function view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid virtual classroom', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('virtualClassroom', $this->VirtualClassroom->read(null, $id));
    }

    function add($course_id) {
        $user = $this->get_user_info($course_id);
        if (!empty($this->data)) {
            $this->data['VirtualClassroom']['level_id'] = $_GET['level'];
            $this->data['VirtualClassroom']['course_id'] = $course_id;
            $this->VirtualClassroom->create();
            if ($this->VirtualClassroom->save($this->data)) {
                $this->setFlash(__('The virtual classroom has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $this->data['VirtualClassroom']['course_id'], '?' => array('level' => $this->data['VirtualClassroom']['level_id'])));
            } else {
                $this->setFlash(__('The virtual classroom could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        $this->set('course_id', $course_id);
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid virtual classroom', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $classroom = $this->VirtualClassroom->read(null, $id);
        $user = $this->get_user_info($classroom['VirtualClassroom']['course_id']);
        if (!empty($this->data)) {
            if ($this->VirtualClassroom->save($this->data)) {
                $this->setFlash(__('The virtual classroom has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $classroom['VirtualClassroom']['course_id'], '?' => array('level' => $classroom['VirtualClassroom']['level_id'])));
            } else {
                $this->setFlash(__('The virtual classroom could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->data = $classroom;
        }

        $this->render('add');
    }

    function delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for virtual classroom', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $classroom = $this->VirtualClassroom->read(null, $id);
        if ($this->VirtualClassroom->delete($id)) {
            $this->setFlash(__('Virtual classroom deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $classroom['VirtualClassroom']['course_id'], '?' => array('level' => $classroom['VirtualClassroom']['level_id'])));
        }
        $this->setFlash(__('Virtual classroom was not deleted', true), 'alert alert-danger');
        $this->redirect(array('action' => 'index', $classroom['VirtualClassroom']['course_id'], '?' => array('level' => $classroom['VirtualClassroom']['level_id'])));
    }

    function do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->VirtualClassroom->deleteAll(array('VirtualClassroom.id' => $ids))) {
                $this->setFlash(__('Virtual classroom deleted successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Virtual classroom can not be deleted', true), 'alert alert-danger');
            }
        }
        $this->redirect($this->referer());
    }

}
