<?php
namespace Admin\Extension\Extension;

use Ions\Mvc\Controller;

class MenuController extends Controller
{
    private $error = [];

    public function index()
    {
        $this->language->load('extension/extension/menu');

        $this->getList();
    }

    public function installAction()
    {
        $this->language->load('extension/extension/report');

        if ($this->validate()) {
            $this->model('setting/extension')->install('menu', $this->request->getQuery('extension'));

            $this->model('user/group')->addPermission($this->user->getGroupId(), 'access', 'extension/menu/' . $this->request->getQuery('extension'));
            $this->model('user/group')->addPermission($this->user->getGroupId(), 'modify', 'extension/menu/' . $this->request->getQuery('extension'));

            $this->controller('extension/menu/' . $this->request->getQuery('extension') . '/install');

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    public function uninstallAction()
    {
        $this->language->load('extension/extension/report');

        if ($this->validate()) {
            $this->model('setting/extension')->uninstall('menu', $this->request->getQuery('extension'));

            // Call uninstall method if it exsits
            $this->load->controller('extension/menu/' . $this->request->getQuery('extension') . '/uninstall');

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->getList();
    }

    protected function getList()
    {
        $data['text_layout'] = sprintf($this->language->get('text_layout'), $this->url->link('layout', 'token=' . $this->session->get('token')));

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

        $extensions = $this->model('setting/extension')->getInstalled('menu');

        foreach ($extensions as $key => $value) {
            if (!is_file('app/' . $this->app->getName() . '/src/Controller/Extension/Menu/' . $value . '.php') && !is_file($this->app->getDirectory() . '/controller/menu/' . $value . '.php')) {
                $this->model('setting/extension')->uninstall('menu', $value);

                unset($extensions[$key]);
            }
        }

        $data['extensions'] = [];

        // Compatibility code for old extension folders
        $files = glob('app/' . $this->app->getName() . '/src/Controller/Extension/Menu/*.php');

        if ($files) {
            foreach ($files as $file) {
                $extension = strtolower(basename($file, 'Controller.php'));

                $this->language->load('extension/menu/' . $extension, 'extension');

                $data['extensions'][] = [
                    'name' => $this->language->get('extension')->get('heading_title'),
                    'status' => $this->config->get('menu_' . $extension . '_status') ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
                    'install' => $this->url->link('extension/extension/menu/install', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'uninstall' => $this->url->link('extension/extension/menu/uninstall', 'token=' . $this->session->get('token') . '&extension=' . $extension),
                    'installed' => in_array($extension, $extensions, true),
                    'edit' => $this->url->link('extension/menu/' . $extension, 'token=' . $this->session->get('token'))
                ];
            }
        }

        $sort_order = [];

        foreach ($data['extensions'] as $key => $value) {
            $sort_order[$key] = $value['name'];
        }

        array_multisort($sort_order, SORT_ASC, $data['extensions']);

        $this->response->setContent($this->view('extension/extension/menu', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/extension/menu')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
