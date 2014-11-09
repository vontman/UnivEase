<?php

class CommentsController extends AppController {

    var $name = 'Comments';

    /**
     * @var Comment */
    var $Comment;

    function index($post_id = false) {
        $post = $this->Comment->Post->read(null, $post_id);
        $this->get_user_info($post['Post']['course_id']);
        $this->Comment->recursive = 0;
        $this->set('post', $post);
        $this->set('comments', $this->paginate('Comment', array('Comment.post_id' => $post_id)));
    }

    function admin_index($post_id = false) {
        $post = $this->Comment->Post->read(null, $post_id);
        $this->get_current_course($post['Post']['course_id']);
        $this->Comment->recursive = 0;
        $this->set('post', $post);
        $this->set('comments', $this->paginate('Comment', array('Comment.post_id' => $post_id)));
    }

    function approve($id) {
        $comment = $this->Comment->read(null, $id);
        $update = $this->Comment->updateAll(array('Comment.approved' => 1), array('Comment.id' => $id));
        if ($update) {
            $this->setFlash(__('The comment has approved successfully', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $comment['Post']['id']));
        }
    }

    function admin_approve($id) {
        $comment = $this->Comment->read(null, $id);
        $update = $this->Comment->updateAll(array('Comment.approved' => 1), array('Comment.id' => $id));
        if ($update) {
            $this->setFlash(__('The comment has approved successfully', true), 'alert alert-success');
            $this->redirect(array('action' => 'index', $comment['Post']['id']));
        }
    }

    function view($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid comment', true));
            $this->redirect(array('action' => 'index'));
        }
        $this->set('comment', $this->Comment->read(null, $id));
    }

    function add() {
        if (!empty($this->data)) {
            $post = $this->Comment->Post->read(null, $this->data['Comment']['post_id']);
            $user = $this->get_user_info($post['Post']['course_id']);
            if (!empty($this->data['Comment']['content'])) {
                if ($post['Post']['user_id'] == $user['User']['id']) {
                    $this->data['Comment']['approved'] = 1;
                }
                $this->Comment->create();
                if ($this->Comment->save($this->data, false)) {
                    $this->setFlash(__('The comment has been saved', true), 'alert alert-success');
                    $this->redirect(array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], $post['Post']['permalink']));
                }
            } else {
                $this->setFlash(__('The comment could not be saved. Please, try again.', true), 'alert alert-danger');
                $this->redirect(array('controller' => 'posts', 'action' => 'view',$post['Post']['id'], $post['Post']['permalink']));
            }
        }
    }

    function admin_add() {
        if (!empty($this->data)) {
            $post = $this->Comment->Post->read(null, $this->data['Comment']['post_id']);
            $course=$this->get_current_course($post['Post']['course_id']);
            if (!empty($this->data['Comment']['content'])) {
                $this->Comment->create();
                $this->data['Comment']['approved'] = 1;
                if ($this->Comment->save($this->data, false)) {
                    $this->setFlash(__('The comment has been saved', true), 'alert alert-success');
                    $this->redirect(array('controller' => 'posts', 'action' => 'view', $post['Post']['id'], $post['Post']['permalink']));
                }
            } else {
                $this->setFlash(__('The comment could not be saved. Please, try again.', true), 'alert alert-danger');
                $this->redirect(array('controller' => 'posts', 'action' => 'view',$post['Post']['id'], $post['Post']['permalink']));
            }
        }
    }

    function edit($id = null) {
        if (!$id && empty($this->data)) {
            $this->setFlash(__('Invalid comment', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        $comment = $this->Comment->read(null, $id);
        $user = $this->get_user_info($comment['Post']['course_id']);
        if (!empty($this->data)) {
            if ($this->Comment->save($this->data)) {
                $this->setFlash(__('The comment has been saved', true), 'alert alert-success');
                $this->redirect(array('action' => 'index', $comment['Post']['id']));
            } else {
                $this->setFlash(__('The comment could not be saved. Please, try again.', true), 'alert alert-danger');
            }
        }
        if (empty($this->data)) {
            $this->data = $comment;
        }
        $this->set('comment', $comment);
        $this->render('add');
    }

    function delete($id = null) {
        if (!$id) {
            $this->setFlash(__('Invalid id for comment', true), 'fail');
            $this->redirect(array('action' => 'index'));
        }
        $comment = $this->Comment->read(null, $id);
        if ($this->Comment->delete($id)) {
            $this->setFlash(__('Comment deleted', true), 'success');
            $this->redirect(array('action' => 'index', $comment['Comment']['post_id']));
        }
        $this->setFlash(__('Comment was not deleted', true), 'fail');
        $this->redirect(array('action' => 'index'));
    }

    function do_operation() {
        $ids = $this->params['form']['chk'];
        $operation = $this->params['form']['operation'];
        if ($operation == 'delete') {
            if ($this->Comment->deleteAll(array('Comment.id' => $ids))) {
                $this->setFlash(__('Comment deleted successfully', true), 'success');
            } else {
                $this->setFlash(__('Comment can not be deleted', true), 'fail');
            }
        }
        $this->redirect(array('action' => 'index'));
    }

}
