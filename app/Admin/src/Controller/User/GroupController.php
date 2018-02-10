<?php

namespace Admin\User;

use Ions\Mvc\Controller;
use Ions\Mvc\Service\Pagination;

class GroupController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('user/group');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('user/group');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('user/group')->addUserGroup($this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('user-group', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('user/group');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('user/group')->editUserGroup($this->request->getQuery('id'), $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('user-group', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('user/group')->deleteUserGroup($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('user-group', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    protected function getList()
    {
        $token = $this->session->get('token');

        $data['groups'] = $this->model('user/group')->getUserGroups();

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

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $token)
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => ''
        ];

        $data['add'] = $this->url->link('user-group/add', 'token=' . $token);
        $data['edit'] = $this->url->link('user-group/edit', 'token=' . $token);
        $data['delete'] = $this->url->link('user-group/delete', 'token=' . $token);

        if ($this->request->hasQuery('page')) {
            $data['page'] = (int)$this->request->getQuery('page');
        } else {
            $data['page'] = 1;
        }

        $data['total'] = $this->model('user/group')->getTotalUserGroups();
        $data['limit'] = $this->config->get('config_limit');

        $pagination = new Pagination();
        $pagination->total = $data['total'];
        $pagination->page = $data['page'];
        $pagination->limit = $data['limit'];
        $pagination->url = $this->url->link('post', 'token=' . $token . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('user/group_list', $data));
    }

    protected function getForm()
    {
        $token = $this->session->get('token');

        $data['heading_title'] = $this->language->get('heading_title');

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if ($this->request->hasQuery('id')) {
            $group_info = $this->model('user/group')->getUserGroup($this->request->getQuery('id'));
            $data['action'] = $this->url->link('user-group/edit', 'token=' . $token . '&id=' . $this->request->getQuery('id'));
        } else {
            $group_info = [];
            $data['action'] = $this->url->link('user-group/add', 'token=' . $token);
        }

        $data['cancel'] = $this->url->link('user-group', 'token=' . $token);

        $data['languages'] = $this->model('localisation/language')->getLanguages();


        if ($this->request->hasPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif ($this->request->hasQuery('id')) {
            $data['description'] = $this->model('user/group')->getUserGroupDescriptions($this->request->getQuery('id'));
        } else {

            $description = $this->model('user/group')->getSchema('user_group_description');

            foreach ($data['languages'] as $language) {
                $data['description'][$language['id']] = $description;
            }
        }

        if ($this->request->hasPost('approval')) {
            $data['approval'] = $this->request->getPost('approval');
        } elseif (!empty($group_info)) {
            $data['approval'] = $group_info['approval'];
        } else {
            $data['approval'] = '';
        }

        $data['permissions'] = [];

        foreach ($this->router->getRoutes() as $name => $route) {
            $defaults = $route->getDefaults();
            if (empty($defaults['ignore'])) {
                $data['permissions'][] = $name;
            }
        }

        if ($this->request->hasPost('permission')) {
            $permission = $this->request->getPost('permission');
        } elseif (!empty($group_info)) {
            $permission = $group_info['permission'];
        } else {
            $permission = [];
        }

        if (isset($permission['access'])) {
            $data['access'] = $permission['access'];
        } elseif (isset($group_info['permission']['access'])) {
            $data['access'] = $group_info['permission']['access'];
        } else {
            $data['access'] = [];
        }

        if (isset($permission['modify'])) {
            $data['modify'] = $permission['modify'];
        } elseif (isset($group_info['permission']['modify'])) {
            $data['modify'] = $group_info['permission']['modify'];
        } else {
            $data['modify'] = [];
        }

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('user/group_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'user-group')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ((array)$this->request->getPost('description') as $language_id => $value) {
            $len = strlen($value['name']);

            if ($len < 3 || $len > 64) {
                $this->error = $this->language->get('error_name');
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'user-group')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('selected') as $group_id) {
            $user_total = $this->model('user/user')->getTotalUsersByGroupId($group_id);

            if ($user_total) {
                $this->error = sprintf($this->language->get('error_group'), $user_total);
            }
        }

        return !$this->error;
    }
}
