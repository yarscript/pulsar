<?php

namespace Admin\User;

use Ions\Mvc\Controller;
use Ions\Mvc\Service\Pagination;

class UserController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('user/user');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('user/user');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('user/user')->addUser($this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('user', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('user/user');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('user/user')->editUser($this->request->getQuery('id'), $this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('user', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('user/user');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->model('user/user');

        if ($this->request->isPost() && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('user/user')->deleteUser($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('user', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    public function unlockAction()
    {
        $this->language->load('user/user');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->hasQuery('email') && $this->validateUnlock()) {
            $this->model('user/user')->deleteLoginAttempts($this->request->getQuery('email'));
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('user', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        $token = $this->session->get('token');

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $token)
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('user', 'token=' . $token)
        ];

        if ($this->request->hasQuery('page')) {
            $data['page'] = $this->request->getQuery('page');
        } else {
            $data['page'] = 1;
        }

        $data['total'] = $this->model('user/user')->getTotalUsers();
        $data['limit'] = $this->config->get('config_limit');

        $data['add'] = $this->url->link('user/add', 'token=' . $token);
        $data['edit'] = $this->url->link('user/edit', 'token=' . $token);
        $data['delete'] = $this->url->link('user/delete', 'token=' . $token);

        $options = [
            'start' => ($data['page'] - 1) * $data['limit'],
            'limit' => $data['limit']
        ];

        $results = $this->model('user/user')->getUsers($options);

        $data['users'] = [];

        foreach ($results as $result) {
            $login_info = $this->model('user/user')->getTotalLoginAttempts($result['email']);

            if ($login_info && $login_info['total'] >= $this->config->get('config_login_attempts')) {
                $unlock = $this->url->link('user/unlock', 'token=' . $token . '&email=' . $result['email']);
            } else {
                $unlock = '';
            }

            $data['users'][] = [
                'id' => $result['id'],
                'name' => $result['firstname'] . ' ' . $result['lastname'],
                'username' => $result['username'],
                'email' => $result['email'],
                'group' => $result['user_group'],
                'status' => $result['status'],
                'ip' => $result['ip'],
                'unlock' => $unlock,
                'image' => $this->model('tool/image')->resize($result['image'] ?: 'no_avatar.jpg', 50, 50)
            ];
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->delete('success');
        } else {
            $data['success'] = '';
        }

        if ($this->request->hasPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $pagination = new Pagination();
        $pagination->total = $data['total'];
        $pagination->page = $data['page'];
        $pagination->limit = $data['limit'];
        $pagination->url = $this->url->link('post', 'token=' . $token . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        $data['groups'] = $this->model('user/group')->getUserGroups();

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('user/user_list', $data));
    }

    protected function getForm()
    {
        $token = $this->session->get('token');

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['groups'] = $this->model('user/group')->getUserGroups();

        if (!$this->request->hasQuery('id')) {
            $data['user'] = $this->model('user/user')->getSchema('user');
            $data['action'] = $this->url->link('user/add', 'token=' . $token);
        } else {
            $data['user'] = $this->model('user/user')->getUser((int)$this->request->getQuery('id'));
            $data['action'] = $this->url->link('user/edit', 'token=' . $token . '&id=' . $this->request->getQuery('id'));
        }

        if ($this->request->hasPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } else {
            $data['image'] = $data['user']['image'];
        }

        if ($this->request->hasPost('image') && is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $this->request->getPost('image'))) {
            $data['thumb'] = $this->model('tool/image')->resize($this->request->getPost('image'), 100, 100);
        } elseif (!empty($data['user']) && $data['user']['image'] && is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $data['user']['image'])) {
            $data['thumb'] = $this->model('tool/image')->resize($data['user']['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model('tool/image')->resize('no_avatar.jpg', 100, 100);
        }

        $data['placeholder'] = $this->model('tool/image')->resize('no_avatar.jpg', 100, 100);

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('user/user_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'user')) {
            $this->error = $this->language->get('error_permission');
        }

        $user_info = $this->model('user/user')->getUserByUsername($this->request->getPost('username'));

        if (!$this->request->hasQuery('id')) {
            if ($user_info) {
                $this->error = $this->language->get('error_exists_username');
            }
        } else {
            if ($user_info && ($this->request->getQuery('id') != $user_info['id'])) {
                $this->error = $this->language->get('error_exists_username');
            }
        }

        $length = strlen(trim($this->request->getPost('username')));

        if ($length < 3 || $length > 96) {
            $this->error = $this->language->get('error_username');
        }

        $length = strlen(trim($this->request->getPost('firstname')));

        if ($length < 3 || $length > 32) {
            $this->error = $this->language->get('error_firstname');
        }

        $length = strlen(trim($this->request->getPost('lastname')));

        if ($length < 3 || $length > 32) {
            $this->error = $this->language->get('error_lasttname');
        }

        if ((strlen($this->request->getPost('email')) > 96) || !filter_var($this->request->getPost('email'), FILTER_VALIDATE_EMAIL)) {
            $this->error = $this->language->get('error_email');
        }

        $user_info = $this->model('user/user')->getUserByEmail($this->request->getPost('email'));

        if (!$this->request->hasQuery('id')) {
            if ($user_info) {
                $this->error = $this->language->get('error_exists_email');
            }
        } else {
            if ($user_info && ($this->request->getQuery('id') != $user_info['id'])) {
                $this->error = $this->language->get('error_exists_email');
            }
        }

        if ($this->request->getPost('password') || !$this->request->hasQuery('id')) {
            if ((strlen(html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8')) < 4) || (strlen(html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8')) > 40)) {
                $this->error = $this->language->get('error_password');
            }

            if ($this->request->getPost('password') != $this->request->getPost('confirm')) {
                $this->error = $this->language->get('error_confirm');
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'user')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('selected') as $user_id) {
            if ($this->user->getId() == $user_id) {
                $this->error = $this->language->get('error_user');
            }
        }

        return !$this->error;
    }

    protected function validateUnlock()
    {
        if (!$this->user->hasPermission('modify', 'user')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function autocompleteAction()
    {
        $json = [];

        $name = $email = '';

        if ($this->request->hasQuery('name')) {
            $name = $this->request->getQuery('name');
        }

        if ($this->request->hasQuery('email')) {
            $email = $this->request->getQuery('email');
        }

        if ($name || $email) {

            $options = [
                'name' => $name,
                'email' => $email,
                'start' => 0,
                'limit' => 5
            ];

            $results = $this->model('user/user')->getUsers($options);

            foreach ($results as $result) {
                $json[] = [
                    'id' => $result['id'],
                    'group_id' => $result['group_id'],
                    'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'group' => $result['group'],
                    'firstname' => $result['firstname'],
                    'lastname' => $result['lastname'],
                    'email' => $result['email']
                ];
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->setContent(json_encode($json));
    }
}
