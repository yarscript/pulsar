<?php

namespace Admin\Content;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class PageController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('content/page');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('content/page');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {

            $data = $this->request->getPost();

            $this->model('content/page')->addPage($data);

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('page', 'token=' . $this->session->get('token')));

        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('content/page');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('content/page')->editPage($this->request->getQuery('id'), $this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('page', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('content/page');

        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('content/page')->deletePage($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('page', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        if ($this->request->hasPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
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

        if ($this->request->hasQuery('page')) {
            $data['page'] = (int)$this->request->getQuery('page');
        } else {
            $data['page'] = 1;
        }

        $data['pages'] = $this->model('content/page')->getPages();
        $data['total'] =  $this->model('content/page')->getTotalPages();

        $data['add'] = $this->url->link('page/add', 'token=' . $this->session->get('token'));
        $data['edit'] = $this->url->link('page/edit', 'token=' . $this->session->get('token'));
        $data['delete'] = $this->url->link('page/delete', 'token=' . $this->session->get('token'));

        $data['breadcrumbs'] = $this->breadcrumbs();

        $pagination = new Pagination();
        $pagination->total = $data['total'];
        $pagination->page = $data['page'];
        $pagination->limit = $this->config->get('config_limit');
        $pagination->url = $this->url->link('page', 'token=' . $this->session->get('token') . '&page={page}');

        $data['pagination'] = $pagination->render();

        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('content/page_list', $data));
    }

    protected function getForm()
    {
        if ($this->request->hasQuery('id')) {
            $data = $this->model('content/page')->getPage($this->request->getQuery('id'));
            $data['description'] = $this->model('content/page')->getPageDescriptions($this->request->getQuery('id'));
            $data['languages'] = $this->model('localisation/language')->getLanguages();
            $data['text_form'] = $this->language->get('text_edit');
            $data['action'] = $this->url->link('page/edit', 'token=' . $this->session->get('token') . '&id=' . $this->request->getQuery('id'));
        } else {
            $data = $this->model('content/page')->getSchema('page');
            $description = $this->model('content/page')->getSchema('page_description');
            $languages = $this->model('localisation/language')->getLanguages();

            foreach ($languages as $language) {
                $data['description'][$language['id']] = $description;
            }

            $data['languages'] = $languages;
            $data['text_form'] = $this->language->get('text_add');
            $data['action'] = $this->url->link('page/add', 'token=' . $this->session->get('token'));
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['cancel'] = $this->url->link('page', 'token=' . $this->session->get('token'));

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('content/page_form', $data));
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
            'href' => $this->url->link('page', 'token=' . $this->session->get('token'))
        ];

        return $breadcrumbs;
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'page')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('description') as $value) {
            if ((strlen($value['name']) < 3) || (strlen($value['name']) > 255)) {
                $this->error = $this->language->get('error_name');
            }

            if ((strlen($value['meta_title']) < 3) || (strlen($value['meta_title']) > 255)) {
                $this->error = $this->language->get('error_meta_title');
            }
        }

        return !(bool)$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'page')) {
            $this->error = $this->language->get('error_permission');
        }

        return !(bool)$this->error;
    }
}
