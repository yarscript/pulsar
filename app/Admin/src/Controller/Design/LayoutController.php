<?php

namespace Admin\Design;

use Ions\Mvc\Controller;

class LayoutController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('design/layout');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('design/layout');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('design/layout')->addLayout($this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('layout', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('design/layout');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('design/layout')->editLayout($this->request->getQuery('id'), $this->request->getPost());

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('layout', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('design/layout');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('design/layout')->deleteLayout($id);
            }

            $this->session->set('success', $this->language->get('text_success'));

            $this->response->redirect($this->url->link('layout', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $data['add'] = $this->url->link('layout/add', 'token=' . $this->session->get('token'));
        $data['delete'] = $this->url->link('layout/delete', 'token=' . $this->session->get('token'));

        $data['layouts'] = [];

        $options = [
            'start' => ($page - 1) * $this->config->get('config_limit_admin'),
            'limit' => $this->config->get('config_limit_admin')
        ];

        $data['layouts'] = $this->model('design/layout')->getLayouts($options);

        $data['breadcrumbs'] = $this->breadcrumbs();

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

        if ($this->request->hasPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        $data['add'] = $this->url->link('layout/add', 'token=' . $this->session->get('token'));
        $data['edit'] = $this->url->link('layout/edit', 'token=' . $this->session->get('token'));
        $data['delete'] = $this->url->link('layout/delete', 'token=' . $this->session->get('token'));

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('design/layout_list', $data));
    }

    protected function getForm()
    {
        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if (!$this->request->hasQuery('id')) {
            $data['text_form'] = $this->language->get('text_add');
            $data['action'] = $this->url->link('layout/add', 'token=' . $this->session->get('token'));
        } else {
            $data['text_form'] = $this->language->get('text_edit');
            $data['action'] = $this->url->link('layout/edit', 'token=' . $this->session->get('token') . '&id=' . $this->request->getQuery('id'));
        }

        $data['cancel'] = $this->url->link('layout', 'token=' . $this->session->get('token'));

        $data['breadcrumbs'] = $this->breadcrumbs();

        if ($this->request->hasQuery('id') && !$this->request->isPost()) {
            $layout_info = $this->model('design/layout')->getLayout($this->request->getQuery('id'));
        }

        if ($this->request->hasPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($layout_info)) {
            $data['name'] = $layout_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->hasPost('layout_route')) {
            $data['layout_routes'] = $this->request->getPost('layout_route');
        } elseif ($this->request->hasQuery('id')) {
            $data['layout_routes'] = $this->model('design/layout')->getLayoutRoutes($this->request->getQuery('id'));
        } else {
            $data['layout_routes'] = [];
        }

        $data['extensions'] = [];

        // Get a list of installed modules
        $extensions = $this->model('setting/extension')->getInstalled('module');

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            $this->language->load('extension/module/' . $code, 'extension');

            $module_data = [];

            $modules = $this->model('setting/module')->getModulesByCode($code);

            foreach ($modules as $module) {
                $module_data[] = [
                    'name' => strip_tags($module['name']),
                    'code' => $code . '.' . $module['id']
                ];
            }

            if ($this->config->offsetExists('module_' . $code . '_status') || $module_data) {
                $data['extensions'][] = [
                    'name' => strip_tags($this->language->get('heading_title')),
                    'code' => $code,
                    'module' => $module_data
                ];
            }
        }

        // Modules layout
        if ($this->request->hasPost('layout_module')) {
            $layout_modules = $this->request->getPost('layout_module');
        } elseif ($this->request->hasQuery('id')) {
            $layout_modules = $this->model('design/layout')->getLayoutModules($this->request->getQuery('id'));
        } else {
            $layout_modules = [];
        }

        $data['layout_modules'] = [];

        // Add all the modules which have multiple settings for each module
        foreach ($layout_modules as $layout_module) {
            $part = explode('.', $layout_module['code']);

            $this->language->load('extension/module/' . $part[0]);

            if (!isset($part[1])) {
                $data['layout_modules'][] = [
                    'name' => strip_tags($this->language->get('heading_title')),
                    'code' => $layout_module['code'],
                    'edit' => $this->url->link('extension/module/' . $part[0], 'token=' . $this->session->get('token')),
                    'position' => $layout_module['position'],
                    'sort_order' => $layout_module['sort_order']
                ];
            } else {
                $module_info = $this->model('setting/module')->getModule($part[1]);

                if ($module_info) {
                    $data['layout_modules'][] = [
                        'name' => strip_tags($module_info['name']),
                        'code' => $layout_module['code'],
                        'edit' => $this->url->link('extension/module/' . $part[0], 'token=' . $this->session->get('token') . '&module_id=' . $part[1]),
                        'position' => $layout_module['position'],
                        'sort_order' => $layout_module['sort_order']
                    ];
                }
            }
        }

//        $data['cancel'] = $this->url->link('user/group', 'token=' . $this->session->get('token'));
//        $data['edit'] = $this->url->link('user/group/edit', 'token=' . $this->session->get('token'));

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('design/layout_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'layout')) {
            $this->error = $this->language->get('error_permission');
        }

        if ((strlen($this->request->getPost('name')) < 3) || (strlen($this->request->getPost('name')) > 64)) {
            $this->error = $this->language->get('error_name');
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'layout')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('selected') as $id) {
            if ($this->config->get('config_layout_id') == $id) {
                $this->error = $this->language->get('error_default');
            }

            $page_total = $this->model('page/page')->getTotalPagesByLayoutId($id);

            if ($page_total) {
                $this->error = sprintf($this->language->get('error_page'), $page_total);
            }

            $category_total = $this->model('page/category')->getTotalCategoriesByLayoutId($id);

            if ($category_total) {
                $this->error = sprintf($this->language->get('error_category'), $category_total);
            }
        }

        return !$this->error;
    }

    protected function breadcrumbs()
    {
        $breadcrumbs = [];

        $breadcrumbs[] = [
            'text' => $this->language->get('text_dashboard'),
            'href' => ''
        ];

        $breadcrumbs[] = [
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('layout', 'token=' . $this->session->get('token'))
        ];

        return $breadcrumbs;
    }
}
