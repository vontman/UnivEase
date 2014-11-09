<?php

class CategoriesController extends AppController {

    var $name = 'Categories';
    var $helpers = array('Html', 'Form');

    function admin_index() {
        $this->Category->recursive = 1;
        $this->paginate = array('order' => 'Category.id asc');

        $this->set('categories', $this->paginate('Category'));
    }

    function admin_view($id = null) {
        $this->loadModel('Course');
        $category = $this->Category->read(null, $id);
        $categories = $this->paginate('Category', array('Category.parent_id' => $id));
        $this->set('categories', $categories);
        $courses = $this->Course->find('all', array('conditions' => array('Course.category_id' => $id)));
        $this->set('courses', $courses);
        $this->set('category', $category);
    }

    function admin_add($parent_id = false) {
        if (!empty($this->data)) {
            $this->Category->create();
            
            if ($this->Category->save($this->data)) {
                $id = $this->Category->getInsertID();
                $path = WWW_ROOT . 'data/' . $id . '/';
                if (!is_dir($path)) {
                    mkdir($path, 0777);
                }
                $this->setFlash(__('The Category has been saved', true), 'alert alert-success');
                
            } else {
                $this->setFlash(__('The Category could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->loadModel('Faculty');
             
            $faculties=$this->Faculty->find('list',array('fields'=>'Faculty.id,Faculty.name'));
            $this->set('faculties', $faculties);
        }
         $this->loadModel('Faculty');
             
            $faculties=$this->Faculty->find('list',array('fields'=>'Faculty.id,Faculty.name'));
            $this->set('faculties', $faculties);
        
        
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid Category', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Category->save($this->data)) {
                $this->setFlash(__('The Category has been saved', true), 'alert alert-success');
                if ($this->data['Category']['parent_id'] == '') {
                    $this->redirect(array('controller' => 'users', 'action' => 'dashboard'));
                } else {
                    $this->redirect(array('controller' => 'categories', 'action' => 'view', $this->data['Category']['parent_id']));
                }
            } else {
                $this->setFlash(__('The Category could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Category->read(null, $id);
        }
        $categories = $this->Category->findCategories();
        $this->set('parents', $categories);
        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for Category', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Category->delete($id)) {
            $this->setFlash(__('Category deleted', true), 'alert alert-success');
            $this->redirect($this->referer());
        }
        $this->setFlash(__('The Category could not be deleted. Please, try again.', true), 'alert alert-danger');
        $this->redirect($this->referer());
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Category->deleteAll(array('Category.id' => $ids))) {
                $this->setFlash('Category deleted successfully', 'alert alert-success');
            } else {
                $this->setFlash('Category can not be deleted', 'alert alert-danger');
            }
        }
        $this->redirect($this->referer());
    }

    function admin_get_submenus($category_id) {
        Configure::write('debug', 0);
        $this->layout = $this->autoRender = false;
        $subcategories = $this->Category->find('all', array('conditions' => array('Category.parent_id' => $category_id, '(Category.subcategory_id is null or  Category.subcategory_id=0)'), 'fields' => array('id', 'ar_title')));
        $submenus['submenus'] = $subcategories;
        echo json_encode($submenus);
    }

}

?>