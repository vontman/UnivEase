<?php

class PermissionsController extends AppController {

    var $name = 'Permissions';

    /**
     * @var Permission */
    var $Permission;

    function admin_index() {
        $this->Permission->recursive = 0;
        $this->set('permissions', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid permission', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('permission', $this->Permission->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Permission->create();
            if ($this->Permission->save($this->data)) {
                $this->setFlash(__('The permission has been saved', true), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The permission could not be saved. Please, try again.', true), 'fail');
            }
        }
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid permission', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Permission->save($this->data)) {
                $this->setFlash(__('The permission has been saved', true), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The permission could not be saved. Please, try again.', true), 'fail');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Permission->read(null, $id);
        }
        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for permission', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Permission->delete($id)) {
            $this->setFlash(__('Permission deleted', true), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->setFlash(__('Permission was not deleted', true), 'fail');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Permission->deleteAll(array('Permission.id' => $ids))) {
                $this->setFlash(__('Permission deleted successfully', true), 'success');
            } else {
                $this->setFlash(__('Permission can not be deleted', true), 'fail');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}
