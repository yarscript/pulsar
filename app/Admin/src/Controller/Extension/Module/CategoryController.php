<?php
namespace Admin\Extension\Module;

use Ions\Mvc\Controller;

class CategoryController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/module/category');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validate()) {
            $this->model('system/setting')->editSetting('module_category', $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('extension/extension/module', 'token=' . $this->session->get('token'). '&type=module'));
        }

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['action'] = $this->url->link('extension/module/category', 'token=' . $this->session->get('token'));

        $data['cancel'] = $this->url->link('extension/extension/module', 'token=' . $this->session->get('token'). '&type=module');

        if ($this->request->getPost('module_category_status')) {
            $data['module_category_status'] = $this->request->getPost('module_category_status');
        } else {
            $data['module_category_status'] = $this->config->get('module_category_status');
        }

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('extension/module/category', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/category')) {
            $this->error = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}
