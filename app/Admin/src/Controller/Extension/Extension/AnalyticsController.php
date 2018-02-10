<?php

namespace Admin\Extension\Extension;

use Ions\Mvc\Controller;

class AnalyticsController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/extension/analytics');

        $this->getList();
    }

    public function installAction()
    {
        $this->language->load('extension/extension/analytics');

        if ($this->validate()) {
            $this->model('setting/extension')->install('analytics', $this->request->getQuery('extension'));

            $this->model('user/group')->addPermission($this->user->getGroupId(), 'access', 'admin/extension/analytics/' . $this->request->getQuery('extension'));
            $this->model('user/group')->addPermission($this->user->getGroupId(), 'modify', 'admin/extension/analytics/' . $this->request->getQuery('extension'));

            // Call install method if it exsits
            $this->controller('extension/analytics/' . $this->request->getQuery('extension'), [], 'install');

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('extension/extension/analytics', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    public function uninstallAction()
    {
        $this->language->load('extension/extension/analytics');

        if ($this->validate()) {
            $this->model('setting/extension')->uninstall('analytics', $this->request->getQuery('extension'));

            // Call uninstall method if it exsits
            $this->controller('extension/analytics/' . $this->request->getQuery('extension'), [], 'uninstall');

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('extension/extension/analytics', 'token=' . $this->session->get('token')));

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
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->get('token'))
        ];

        $data['breadcrumbs'][] = [
            'text' => $this->language->get('heading_title'),
            'href' => ''
        ];

        $data['heading_title'] = $this->language->get('heading_title');

        $extensions = $this->model('setting/extension')->getInstalled('analytics');

        foreach ($extensions as $key => $value) {
            if (!is_file('app/' . $this->app->getName() . '/src/Controller/Extension/Analytics/' . ucfirst($value) . 'Controller.php')) {
                $this->model('setting/extension')->uninstall('module', $value);

                unset($extensions[$key]);

                $this->model('setting/module')->deleteModulesByCode($value);
            }
        }

        $data['extensions'] = [];

        // Compatibility code for old extension folders
        $files = glob('app/' . $this->app->getName() . '/src/Controller/Extension/Analytics/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = strtolower(basename($file, 'Controller.php'));

                // Compatibility code for old extension folders
                $this->language->load('extension/analytics/' . $extension);

                $data['extensions'][] = [
                    'name' => $this->language->get('heading_title'),
                    'install' => $this->url->link('extension/extension/analytics/install', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'uninstall' => $this->url->link('extension/extension/analytics/uninstall', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'installed' => in_array($extension, $extensions, true),
                    'edit'   => $this->url->link('extension/analytics/' . $extension, 'token=' . $this->session->get('token')),
                    'status' => $this->config->get('analytics_' . $extension . '_status')
                ];
            }
        }

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('extension/extension/analytics', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/extension/analytics')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
