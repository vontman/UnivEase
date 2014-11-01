<?php

class ConfigurationsController extends AppController {

    var $name = 'Configurations';

    /**
     * @var Configuration
     */
    var $Configuration;
    var $helpers = array('Html', 'Form', 'timezone');

    function admin_index() {
        $this->Configuration->recursive = 0;
        $this->set('configurations', $this->paginate());
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid Configuration', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('configuration', $this->Configuration->read(null, $id));
    }

    function admin_add() {
        if (!empty($this->data)) {
            $this->Configuration->create();
            if ($this->Configuration->save($this->data)) {
                $this->setFlash(__('The Configuration has been saved', true), 'success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The Configuration could not be saved. Please, try again.', true), 'fail');
            }
        }
    }

    function admin_edit($id = 1) {
        if (!empty($this->data)) {
            if ($this->Configuration->save($this->data)) {
                $this->setFlash(__('The Configuration has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'edit'));
            } else {
                $this->setFlash(__('The Configuration could not be saved. Please, try again.', true), 'fail');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Configuration->read(null, $id);
        }
        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for Configuration', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Configuration->delete($id)) {
            $this->setFlash(__('Configuration deleted', true), 'success');
            $this->redirect(array('action' => 'index'));
        }
        $this->setFlash(__('The Configuration could not be deleted. Please, try again.', true), 'fail');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Configuration->deleteAll(array('Configuration.id' => $ids))) {
                $this->setFlash('Configuration deleted successfully', 'success');
            } else {
                $this->setFlash('Configuration can not be deleted', 'fail');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}

?>