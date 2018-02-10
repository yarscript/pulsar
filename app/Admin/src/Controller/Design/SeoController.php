<?php

namespace Admin\Design;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class SeoController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('design/seo');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('design/seo');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('design/seo')->addSeoUrl($this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('seo', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('design/seo');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('design/seo')->editSeoUrl($this->request->getQuery('id'), $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('seo', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('design/seo');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('design/seo')->deleteSeoUrl($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('seo', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        if ($this->request->hasQuery('page')) {
            $page = $this->request->getQuery('page');
        } else {
            $page = 1;
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['add'] = $this->url->link('seo/add', 'token=' . $this->session->get('token'));
        $data['edit'] = $this->url->link('seo/edit', 'token=' . $this->session->get('token'));
        $data['delete'] = $this->url->link('seo/delete', 'token=' . $this->session->get('token'));

        $data['seos'] = [];

        $options = [
            'start' => ($page - 1) * $this->config->get('config_limit'),
            'limit' => $this->config->get('config_limit')
        ];

        $data['total']  = $this->model('design/seo')->getTotalSeoUrls($options);

        $results = $this->model('design/seo')->getSeoUrls($options);

        foreach ($results as $result) {
            $data['seos'][] = [
                'id' => $result['id'],
                'query' => $result['query'],
                'keyword' => $result['keyword'],
                'push' => $result['push'],
                'language' => $result['language'],
                'edit' => $this->url->link('seo/edit', 'token=' . $this->session->get('token') . '&id=' . $result['id'])
            ];
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
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
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_limit');
        $pagination->url = $this->url->link('seo', 'token=' . $this->session->get('token') . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        $data['languages'] = $this->model('localisation/language')->getLanguages();

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('design/seo_list', $data));
    }

    protected function getForm()
    {
        $data['text_form'] = !$this->request->hasQuery('id') ? $this->language->get('text_add') : $this->language->get('text_edit');

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if (!$this->request->hasQuery('id')) {
            $data['action'] = $this->url->link('seo/add', 'token=' . $this->session->get('token'));
        } else {
            $data['action'] = $this->url->link('seo/edit', 'token=' . $this->session->get('token') . '&id=' . $this->request->getQuery('id'));
        }

        $data['cancel'] = $this->url->link('seo', 'token=' . $this->session->get('token'));

        if ($this->request->hasQuery('id') && !$this->request->isPost()) {
            $seo_info = $this->model('design/seo')->getSeoUrl($this->request->getQuery('id'));
        }

        if ($this->request->hasPost('query')) {
            $data['query'] = $this->request->getPost('query');
        } elseif (!empty($seo_info)) {
            $data['query'] = $seo_info['query'];
        } else {
            $data['query'] = '';
        }

        if ($this->request->hasPost('keyword')) {
            $data['keyword'] = $this->request->getPost('keyword');
        } elseif (!empty($seo_info)) {
            $data['keyword'] = $seo_info['keyword'];
        } else {
            $data['keyword'] = '';
        }

        if ($this->request->hasPost('push')) {
            $data['push'] = $this->request->getPost('push');
        } elseif (!empty($seo_info)) {
            $data['push'] = $seo_info['push'];
        } else {
            $data['push'] = '';
        }

        $data['languages'] = $this->model('localisation/language')->getLanguages();

        if ($this->request->hasPost('language_id')) {
            $data['language_id'] = $this->request->getPost('language_id');
        } elseif (!empty($seo_info)) {
            $data['language_id'] = $seo_info['language_id'];
        } else {
            $data['language_id'] = '';
        }

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('design/seo_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'seo')) {
            $this->error = $this->language->get('error_permission');
        }

        if (!$this->request->getPost('query')) {
            $this->error = $this->language->get('error_query');
        }

        if (!$this->request->getPost('keyword')) {
            $this->error = $this->language->get('error_keyword');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'seo')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    protected function breadcrumbs()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => ''
        ];

        $breadcrumbs[] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('seo', 'token=' . $this->session->get('token'))
        ];

        return $breadcrumbs;
    }
}
