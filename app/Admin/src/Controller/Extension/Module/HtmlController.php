<?php
namespace Admin\Extension\Module;

use Ions\Mvc\Controller;

class HtmlController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/module/html');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validate()) {
            if (!$this->request->hasQuery('id')) {
                $this->model('setting/module')->addModule('html', $this->request->getPost());
            } else {
                $this->model('setting/module')->editModule($this->request->getQuery('id'), $this->request->getPost());
            }

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('extension/extension/module', 'token=' . $this->session->get('token'). '&type=module'));
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if (!$this->request->hasQuery('id')) {
            $data['action'] = $this->url->link('extension/module/html', 'token=' . $this->session->get('token'));
        } else {
            $data['action'] = $this->url->link('extension/module/html', 'token=' . $this->session->get('token') . '&id=' . $this->request->getQuery('id'));
        }

        $data['cancel'] = $this->url->link('extension/extension/module', 'token=' . $this->session->get('token'). '&type=module');

        if ($this->request->hasQuery('id') && !$this->request->isPost()) {
            $module_info = $this->model('setting/module')->getModule($this->request->getQuery('id'));
        }

        if ($this->request->hasPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($module_info)) {
            $data['name'] = $module_info['name'];
        } else {
            $data['name'] = '';
        }

        $data['languages'] = $this->model('localisation/language')->getLanguages();

        if ($this->request->hasPost('description')) {
            $data['description'] = $this->request->getPost('description');
        } elseif (!empty($module_info)) {
            $data['description'] = $module_info['description'];
        } else {
            foreach ($data['languages'] as $language) {
                $data['description'][$language['id']] = [
                    'title' => '',
                    'description' => ''
                ];
            }
        }

        if ($this->request->hasPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($module_info)) {
            $data['status'] = $module_info['status'];
        } else {
            $data['status'] = '';
        }

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('extension/module/html', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/html')) {
            $this->error = $this->language->get('error_permission');
        }

        if ((strlen($this->request->getPost('name')) < 3) || (strlen($this->request->getPost('name')) > 64)) {
            $this->error = $this->language->get('error_name');
        }

        return !$this->error;
    }

    public function installAction()
    {

    }

    public function uninstallAction()
    {

    }

    public function install()
    {

    }

    public function uninstall()
    {

    }
}
