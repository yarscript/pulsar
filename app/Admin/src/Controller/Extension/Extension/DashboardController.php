<?php

namespace Admin\Extension\Extension;

use Ions\Mvc\Controller;

class DashboardController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/extension/dashboard');

        $this->getList();
    }

    public function installAction()
    {
        $this->language->load('extension/extension/dashboard');

        if ($this->validate()) {
            $this->model('setting/extension')->install('dashboard', $this->request->getQuery('extension'));

            $this->model('user/group')->addPermission($this->user->getGroupId(), 'access', 'admin/extension/dashboard/' . $this->request->getQuery('extension'));
            $this->model('user/group')->addPermission($this->user->getGroupId(), 'modify', 'admin/extension/dashboard/' . $this->request->getQuery('extension'));

            // Call install method if it exsits
            $this->controller('extension/dashboard/' . $this->request->getQuery('extension'), [], 'install');

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('extension/extension/dashboard', 'token=' . $this->session->get('token')));

        }

        $this->getList();
    }

    public function uninstallAction()
    {
        $this->language->load('extension/extension/dashboard');

        if ($this->validate()) {
            $this->model('setting/extension')->uninstall('dashboard', $this->request->getQuery('extension'));

            // Call uninstall method if it exsits
            $this->controller('extension/dashboard/' . $this->request->getQuery('extension'), [], 'uninstall');

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('extension/extension/dashboard', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
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

        $data['breadcrumbs'] = [];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $this->session->get('token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => ''
        ];

        $data['heading_title'] = $this->language->get('heading_title');

        $extensions = $this->model('setting/extension')->getInstalled('dashboard');

        foreach ($extensions as $key => $value) {
            if (!is_file('app/' . $this->app->getName() . '/src/Controller/Extension/Dashboard/' . ucfirst($value) . 'Controller.php')) {
                $this->model('setting/extension')->uninstall('dashboard', $value);

                unset($extensions[$key]);
            }
        }

        $data['extensions'] = [];

        // Compatibility code for old extension folders
        $files = glob('app/' . $this->app->getName() . '/src/Controller/Extension/Dashboard/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = strtolower(basename($file, 'Controller.php'));

                // Compatibility code for old extension folders
                $this->language->load('extension/dashboard/' . $extension);

                $data['extensions'][] = [
                    'name' => $this->language->get('heading_title'),
                    'width' => $this->config->get('dashboard_' . $extension . '_width'),
                    'status' => $this->config->get('dashboard_' . $extension . '_status'),
                    'sort_order' => $this->config->get('dashboard_' . $extension . '_sort_order'),
                    'install' => $this->url->link('extension/extension/dashboard/install', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'uninstall' => $this->url->link('extension/extension/dashboard/uninstall', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'installed' => in_array($extension, $extensions, true),
                    'edit' => $this->url->link('extension/dashboard/' . $extension, 'token=' . $this->session->get('token'))
                ];
            }
        }

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('extension/extension/dashboard', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/extension/dashboard')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
