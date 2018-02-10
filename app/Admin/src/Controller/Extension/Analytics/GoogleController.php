<?php

namespace Admin\Extension\Analytics;

use Ions\Mvc\Controller;

class GoogleController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/analytics/google');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validate()) {
            $this->model('system/setting')->editSetting('analytics_google', $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('extension/extension/analytics', 'token=' . $this->session->get('token') . '&type=analytics'));
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $this->session->get('token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_extension'),
            'href' => $this->url->link('extension/extension/analytics', 'token=' . $this->session->get('token') . '&type=analytics')
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/analytics/google', 'token=' . $this->session->get('token'))
        ];

        $data['action'] = $this->url->link('extension/analytics/google', 'token=' . $this->session->get('token'));
        $data['cancel'] = $this->url->link('extension/extension/analytics', 'token=' . $this->session->get('token') . '&type=analytics');

        if ($this->request->hasPost('analytics_google_code')) {
            $data['code'] = $this->request->getPost('analytics_google_code');
        } else {
            $data['code'] = $this->config->get('analytics_google_code');
        }

        if ($this->request->hasPost('analytics_google_status')) {
            $data['status'] = $this->request->getPost('analytics_google_status');
        } else {
            $data['status'] = $this->config->get('analytics_google_status');
        }

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('extension/analytics/google', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/analytics/google')) {
            $this->error = $this->language->get('error_permission');
        }

        if (!$this->request->hasPost('analytics_google_code')) {
            $this->error = $this->language->get('error_code');
        }

        return !$this->error;
    }

    public function installAction()
    {
    }

    public function uninstallAction()
    {
    }
}
