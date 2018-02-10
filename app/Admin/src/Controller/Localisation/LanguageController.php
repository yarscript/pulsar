<?php

namespace Admin\Localisation;

use Ions\Mvc\Controller;

class LanguageController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('localisation/language');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('localisation/language');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('localisation/language')->addLanguage($this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('language', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('localisation/language');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('localisation/language')->editLanguage($this->request->getQuery('id'), $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('language', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('localisation/language');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('localisation/language')->deleteLanguage($id);
            }

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('language', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        $data['languages'] = $this->model('localisation/language')->getLanguages();

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->delete('success');
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $this->session->get('token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => ''
        ];

        $data['add'] = $this->url->link('language/add', 'token=' . $this->session->get('token'));
        $data['edit'] = $this->url->link('language/edit', 'token=' . $this->session->get('token'));
        $data['delete'] = $this->url->link('language/delete', 'token=' . $this->session->get('token'));

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('localisation/language_list', $data));
    }

    protected function getForm()
    {
        if ($this->request->hasQuery('id')) {
            $data = $this->model('localisation/language')->getLanguage($this->request->getQuery('id'));
        } else {
            $data = $this->model('localisation/language')->getSchema('language');
        }

        if (isset($this->error)) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['languages'] = [];

        $folders = glob($this->language->getDirectory() . '/*', GLOB_ONLYDIR);

        foreach ($folders as $folder) {
            $data['languages'][] = basename($folder);
        }

        if (!$this->request->hasQuery('id')) {
            $data['action'] = $this->url->link('language/add', 'token=' . $this->session->get('token'));
        } else {
            $data['action'] = $this->url->link('language/edit', 'token=' . $this->session->get('token') . '&id=' . $this->request->getQuery('id'));
        }


        $data['cancel'] = $this->url->link('language', 'token=' . $this->session->get('token'));

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('localisation/language_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'language')) {
            $this->error = $this->language->get('error_permission');
        }

        if ((strlen($this->request->getPost('name')) < 3) || (strlen($this->request->getPost('name')) > 32)) {
            $this->error = $this->language->get('error_name');
        }

        if (strlen($this->request->getPost('code')) < 2) {
            $this->error = $this->language->get('error_code');
        }

        if (!$this->request->hasPost('locale')) {
            $this->error = $this->language->get('error_locale');
        }

        $language_info = $this->model('localisation/language')->getLanguageByCode($this->request->getPost('code'));

        if (!$this->request->hasQuery('language_id')) {
            if ($language_info) {
                $this->error = $this->language->get('error_exists');
            }
        } else {
            if ($language_info && ($this->request->getQuery('language_id') != $language_info['language_id'])) {
                $this->error = $this->language->get('error_exists');
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'language')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('selected') as $language_id) {
            $language_info = $this->model('localisation/language')->getLanguage($language_id);

            if ($language_info) {
                if ($this->config->get('config_language') == $language_info['code']) {
                    $this->error = $this->language->get('error_default');
                }

                if ($this->config->get('config_admin_language') == $language_info['code']) {
                    $this->error = $this->language->get('error_admin');
                }
            }

            $order_total = $this->model('sale/order')->getTotalOrdersByLanguageId($language_id);

            if ($order_total) {
                $this->error = sprintf($this->language->get('error_order'), $order_total);
            }
        }

        return !$this->error;
    }
}
