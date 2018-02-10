<?php
namespace Admin\Extension\Module;

use Ions\Mvc\Controller;

class SlideshowController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('extension/module/slideshow');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validate()) {
            if (!$this->request->hasQuery('id')) {
                $this->model('setting/module')->addModule('slideshow', $this->request->getPost());
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
            $data['action'] = $this->url->link('extension/module/slideshow', 'token=' . $this->session->get('token'));
        } else {
            $data['action'] = $this->url->link('extension/module/slideshow', 'token=' . $this->session->get('token') . '&id=' . $this->request->getQuery('id'));
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

        if ($this->request->hasPost('banner_id')) {
            $data['banner_id'] = $this->request->getPost('banner_id');
        } elseif (!empty($module_info)) {
            $data['banner_id'] = $module_info['banner_id'];
        } else {
            $data['banner_id'] = '';
        }

        $data['banners'] = $this->model('design/banner')->getBanners();

        if ($this->request->hasPost('width')) {
            $data['width'] = $this->request->getPost('width');
        } elseif (!empty($module_info)) {
            $data['width'] = $module_info['width'];
        } else {
            $data['width'] = '';
        }

        if ($this->request->hasPost('height')) {
            $data['height'] = $this->request->getPost('height');
        } elseif (!empty($module_info)) {
            $data['height'] = $module_info['height'];
        } else {
            $data['height'] = '';
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

        $this->response->setContent($this->view('extension/module/slideshow', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'extension/module/slideshow')) {
            $this->error = $this->language->get('error_permission');
        }

        if ((strlen($this->request->getPost('name')) < 3) || (strlen($this->request->getPost('name')) > 64)) {
            $this->error = $this->language->get('error_name');
        }

        if (!$this->request->hasPost('width')) {
            $this->error = $this->language->get('error_width');
        }

        if (!$this->request->hasPost('height')) {
            $this->error = $this->language->get('error_height');
        }

        return !$this->error;
    }
}
