<?php
namespace Admin\Extension\Extension;

use Ions\Mvc\Controller;

class ModuleController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/extension/module');

        $this->getList();
    }

    public function installAction()
    {
        $this->language->load('extension/extension/module');

        if ($this->validate()) {
            $this->model('setting/extension')->install('module', $this->request->getQuery('extension'));

            $this->model('user/group')->addPermission($this->user->getGroupId(), 'access', 'admin/extension/module/' . $this->request->getQuery('extension'));
            $this->model('user/group')->addPermission($this->user->getGroupId(), 'modify', 'admin/extension/module/' . $this->request->getQuery('extension'));

            // Call install method if it exsits
            $this->controller('extension/module/' . $this->request->getQuery('extension'), 'install');

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    public function uninstallAction()
    {
        $this->language->load('extension/extension/module');

        if ($this->validate()) {
            $this->model('setting/extension')->uninstall('module', $this->request->getQuery('extension'));

            $this->model('setting/module')->deleteModulesByCode($this->request->getQuery('extension'));

            // Call uninstall method if it exsits
            $this->controller('extension/module/' . $this->request->getQuery('extension'), 'uninstall');

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('extension/extension/module');

        if ($this->validate()) {
            $this->language->load('extension/module' . '/' . $this->request->getQuery('extension'));

            $this->model('setting/module')->addModule($this->request->getQuery('extension'), $this->language->get('heading_title'));

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    public function deleteAction()
    {
        $this->language->load('extension/extension/module');

        if ($this->request->hasQuery('id') && $this->validate()) {
            $this->model('setting/module')->deleteModule($this->request->getQuery('id'));

            $this->session->set('success', $this->language->get('text_success'));
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

        $extensions = $this->model('setting/extension')->getInstalled('module');

        foreach ($extensions as $key => $value) {
            if (!is_file('app/' . $this->app->getName() . '/src/Controller/Extension/Module/' . ucfirst($value) . 'Controller.php')) {
                $this->model('setting/extension')->uninstall('module', $value);

                unset($extensions[$key]);

                $this->model('setting/module')->deleteModulesByCode($value);
            }
        }

        $data['extensions'] = [];

        // Compatibility code for old extension folders
        $files = glob('app/' . $this->app->getName() . '/src/Controller/Extension/Module/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = strtolower(basename($file, 'Controller.php'));

                $this->language->load('extension/module/' . $extension);

                $module_data = [];

                $modules = $this->model('setting/module')->getModulesByCode($extension);

                foreach ($modules as $module) {
                    if ($module['setting']) {
                        $setting_info = json_decode($module['setting'], true);
                    } else {
                        $setting_info = [];
                    }

                    $module_data[] = [
                        'id' => $module['id'],
                        'name' => $module['name'],
                        'status' => isset($setting_info['status']) ? $setting_info['status'] : 0,
                        'edit' => $this->url->link('extension/module/' . $extension, 'token=' . $this->session->get('token') . '&id=' . $module['id']),
                        'delete' => $this->url->link('extension/extension/module/delete', 'token=' . $this->session->get('token') . '&id=' . $module['id'])
                    ];
                }

                $data['extensions'][] = [
                    'name' => $this->language->get('heading_title'),
                    'status' => $this->config->get('module_' . $extension . '_status'),
                    'module' => $module_data,
                    'install' => $this->url->link('extension/extension/module/install', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'uninstall' => $this->url->link('extension/extension/module/uninstall', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'installed' => in_array($extension, $extensions, true),
                    'edit' => $this->url->link('extension/module/' . $extension, 'token=' . $this->session->get('token'))
                ];
            }
        }

        $sort_order = [];

        foreach ($data['extensions'] as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $data['extensions']);

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('extension/extension/module', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/extension/module')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
