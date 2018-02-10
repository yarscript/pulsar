<?php

namespace Admin\System;

use Ions\Mvc\Controller;

class SettingController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('system/setting');
        $this->document->setTitle($this->language->get('heading_title'));

        $token = $this->session->get('token');

        if ($this->request->isPost() && $this->validate()) {
            $this->model('system/setting')->editSetting('config', $this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('setting', 'token=' . $token));
        }

        $data = $this->model('system/setting')->getSetting('config');

        $data['languages'] = $this->model('localisation/language')->getLanguages();
        $data['user_groups'] = $this->model('user/group')->getUserGroups();

        $data['heading_title'] = $this->language->get('heading_title');

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

        $data['action'] = $this->url->link('setting', 'token=' . $token);
        $data['dashboard'] = $this->url->link('dashboard', 'token=' . $token);

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('system/setting', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'setting')) {
            $this->error = $this->language->get('error_permission');
        }

        if (!$this->request->hasPost('config_meta_title')) {
            $this->error = $this->language->get('error_meta_title');
        }

        if (!$this->request->hasPost('config_name')) {
            $this->error = $this->language->get('error_name');
        }

        if ((strlen($this->request->getPost('config_email')) > 96) || !filter_var($this->request->getPost('config_email'), FILTER_VALIDATE_EMAIL)) {
            $this->error = $this->language->get('error_email');
        }

        if ($this->request->hasPost('config_customer_group_display') && !in_array($this->request->getPost('config_customer_group_id'), $this->request->getPost('config_customer_group_display'))) {
            $this->error = $this->language->get('error_customer_group_display');
        }

        if (!$this->request->hasPost('config_limit')) {
            $this->error = $this->language->get('error_limit');
        }

        if (!$this->request->hasPost('config_error_filename')) {
            $this->error = $this->language->get('error_log_required');
        } elseif (preg_match('/\.\.[\/\\\]?/', $this->request->getPost('config_error_filename'))) {
            $this->error = $this->language->get('error_log_invalid');
        } elseif (substr($this->request->getPost('config_error_filename'), strrpos($this->request->getPost('config_error_filename'), '.')) != '.log') {
            $this->error = $this->language->get('error_log_extension');
        }

//        if ((strlen($this->request->getPost('config_encryption')) < 32) || (strlen($this->request->getPost('config_encryption')) > 1024)) {
//            $this->error = $this->language->get('error_encryption');
//        }

        return !$this->error;
    }
}
