<?php

class PostsController extends AppController {

    var $name = 'Posts';

    /**
     * @var Post */
    var $Post;

    function index($course_id = false) {
        $user = $this->get_user_info($course_id);
        $this->Post->recursive = 0;
        $conditions = array();
        if (!in_array(10, array_keys($user['Group']['allowed_permissions']))) {
            $conditions[] = array('Post.publish_date <=' => date('Y-m-d H:i:s'), 'Post.cut_off >=' => date('Y-m-d H:i:s'));
        }
        $conditions[] = array('Post.course_id' => $user['CourseUser']['course_id'], 'Post.level' => $_GET['level']);
        $this->set('posts', $this->paginate('Post', $conditions));
    }

    function view($id = false, $permalink = false) {

        if (!$id) {
            $this->setFlash(__('Invalid post', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->loadModel('Comment');
        $post = $this->Post->find('first', array('conditions' => array('Post.id' => $id)));
        $user = $this->get_user_info($post['Post']['course_id']);
        $comments = $this->Comment->find('all', array('conditions' => array('Comment.post_id' => $id, 'Comment.approved' => 1)));

        $this->set('post', $post);
        $this->set('comments', $comments);
    }

    function add($course_id = false) {
        $user = $this->get_user_info($course_id);
        if (!empty($this->data)) {
            $this->data['Post']['user_id'] = $user['User']['id'];
            $this->data['Post']['course_id'] = $course_id;
            $this->data['Post']['level'] = $_GET['level'];
            $this->Post->create();
            if ($this->Post->save($this->data)) {
                $this->setFlash(__('The post has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $course_id, '?' => array('level' => $_GET['level'])));
            } else {
                $this->setFlash(__('The post could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        $this->set('course_id', $course_id);
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid post', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $post = $this->Post->read(null, $id);
        $user = $this->get_user_info($post['Post']['course_id']);
        if (!empty($this->data)) {
            if ($this->Post->save($this->data)) {
                $this->setFlash(__('The post has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $post['Post']['course_id'], '?' => array('level' => $post['Post']['level'])));
            } else {
                $this->setFlash(__('The post could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->data = $post;
        }
        $courses = $this->Post->Course->find('list');
        $this->set(compact('courses'));
        $this->render('add');
    }

    function delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for post', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        $post = $this->Post->read(null, $id);
        if ($this->Post->delete($id)) {
            $this->setFlash(__('Post deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $post['Post']['course_id'], '?' => array('level' => $post['Post']['level'])));
        }
        $this->setFlash(__('Post was not deleted', true), 'alert alert-danger');
        $this->redirect(array('action' => 'index'));
    }

    function do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Post->deleteAll(array('Post.id' => $ids))) {
                $this->setFlash(__('Post deleted successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Post can not be deleted', true), 'alert alert-danger');
            }
        }
        $this->redirect($this->referer());
    }

    function admin_index($course_id) {
        $course = $this->get_current_course($course_id);
        $this->Post->recursive = 0;
        $conditions = array();
        $conditions[] = array('Post.course_id' => $course_id, 'Post.level' => $_GET['level']);
        $this->set('posts', $this->paginate('Post', $conditions));
    }

    function admin_view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid post', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->loadModel('Comment');
        $post = $this->Post->find('first', array('conditions' => array('Post.id' => $id)));
        $course = $this->get_current_course($post['Post']['course_id']);
        $comments = $this->Comment->find('all', array('conditions' => array('Comment.post_id' => $id, 'Comment.approved' => 1)));

        $this->set('post', $post);
        $this->set('comments', $comments);
    }

    function admin_add($course_id = false) {
        $course = $this->get_current_course($course_id);
        if (!empty($this->data)) {
            $this->data['Post']['user_id'] = $user['User']['id'];
            $this->data['Post']['course_id'] = $course_id;
            $this->data['Post']['level'] = $_GET['level'];
            $this->Post->create();
            if ($this->Post->save($this->data)) {
                $this->setFlash(__('The post has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $course_id, '?' => array('level' => $_GET['level'])));
            } else {
                $this->setFlash(__('The post could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        $this->set('course_id', $course_id);
    }

    function admin_edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid post', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if (!empty($this->data)) {
            if ($this->Post->save($this->data)) {
                $this->setFlash(__('The post has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->setFlash(__('The post could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->data = $this->Post->read(null, $id);
        }
        $courses = $this->Post->Course->find('list');
        $this->set(compact('courses'));
        $this->render('admin_add');
    }

    function admin_delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for post', true), 'alert alert-danger');
            $this->redirect(array('action' => 'index'));
        }
        if ($this->Post->delete($id)) {
            $this->setFlash(__('Post deleted', true), 'alert alert-success');
            $this->redirect(array('action' => 'index'));
        }
        $this->setFlash(__('Post was not deleted', true), 'alert alert-danger');
        $this->redirect(array('action' => 'index'));
    }

    function admin_do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Post->deleteAll(array('Post.id' => $ids))) {
                $this->setFlash(__('Post deleted successfully', true), 'alert alert-success');
            } else {
                $this->setFlash(__('Post can not be deleted', true), 'alert alert-danger');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}
