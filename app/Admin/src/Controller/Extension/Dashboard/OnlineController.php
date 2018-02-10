<?php
namespace Admin\Extension\Dashboard;

use Ions\Mvc\Controller;

class OnlineController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/dashboard/online');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validate()) {
            $this->model('system/setting')->editSetting('dashboard_online', $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('extension/extension/dashboard', 'token=' . $this->session->get('token'). '&type=dashboard'));
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
            'href' => $this->url->link('extension/extension/dashboard', 'token=' . $this->session->get('token'). '&type=dashboard')
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' =>''
        ];

        $data['action'] = $this->url->link('extension/dashboard/online', 'token=' . $this->session->get('token'));

        $data['cancel'] = $this->url->link('extension/extension/dashboard', 'token=' . $this->session->get('token'). '&type=dashboard');

        if ($this->request->hasPost('dashboard_online_width')) {
            $data['dashboard_online_width'] = $this->request->getPost('dashboard_online_width');
        } else {
            $data['dashboard_online_width'] = $this->config->get('dashboard_online_width');
        }

        $data['columns'] = [];

        for ($i = 3; $i <= 12; $i++) {
            $data['columns'][] = $i;
        }

        if ($this->request->hasPost('dashboard_online_status')) {
            $data['dashboard_online_status'] = $this->request->getPost('dashboard_online_status');
        } else {
            $data['dashboard_online_status'] = $this->config->get('dashboard_online_status');
        }

        if ($this->request->hasPost('dashboard_online_sort_order')) {
            $data['dashboard_online_sort_order'] = $this->request->getPost('dashboard_online_sort_order');
        } else {
            $data['dashboard_online_sort_order'] = $this->config->get('dashboard_online_sort_order');
        }

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('extension/dashboard/online_form', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/dashboard/online')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }

    public function dashboardAction()
    {
        $this->language->load('extension/dashboard/online');

        // Users Online
        $online_total = $this->model('extension/dashboard/online.model')->getTotalOnline();

        if ($online_total > 1000000000000) {
            $data['total'] = round($online_total / 1000000000000, 1) . 'T';
        } elseif ($online_total > 1000000000) {
            $data['total'] = round($online_total / 1000000000, 1) . 'B';
        } elseif ($online_total > 1000000) {
            $data['total'] = round($online_total / 1000000, 1) . 'M';
        } elseif ($online_total > 1000) {
            $data['total'] = round($online_total / 1000, 1) . 'K';
        } else {
            $data['total'] = $online_total;
        }

        $data['online'] = $this->url->link('report/online', 'token=' . $this->session->get('token'));

        return $this->view('extension/dashboard/online_info', $data);
    }

    public function installAction()
    {
    }

    public function uninstallAction()
    {
    }
}
