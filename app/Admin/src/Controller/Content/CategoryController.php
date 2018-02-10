<?php

namespace Admin\Content;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class CategoryController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('content/category');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('content/category');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('content/category')->addCategory($this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('category', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('content/category');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('content/category')->editCategory($this->request->getQuery('id'), $this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('category', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('content/category');

        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('content/category')->deleteCategory($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('category', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        $token = $this->session->get('token');

        if ($this->request->hasPost('selected')) {
            $data['selected'] = (array)$this->request->getPost('selected');
        } else {
            $data['selected'] = [];
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');
            $this->session->delete('success');
        } else {
            $data['success'] = '';
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if ($this->request->hasQuery('page')) {
            $data['page'] = (int)$this->request->getQuery('page');
        } else {
            $data['page'] = 1;
        }

        $data['limit'] = $this->config->get('config_limit');
        $data['total'] = $this->model('content/category')->getTotalCategories();
        $data['categories'] = $this->model('content/category')->getCategories();

        foreach ($data['categories'] as & $category) {
            if (is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $category['image'])) {
                $category['image'] = $this->model('tool/image')->resize($category['image'], 100, 100);
            } else {
                $category['image'] = $this->model('tool/image')->resize('no_image.png', 100, 100);
            }
        }

        $data['add'] = $this->url->link('category/add', 'token=' . $token);
        $data['edit'] = $this->url->link('category/edit', 'token=' . $token);
        $data['delete'] = $this->url->link('category/delete', 'token=' . $token);

        $pagination = new Pagination();
        $pagination->total = $data['total'];
        $pagination->page = $data['page'];
        $pagination->limit = $data['limit'];
        $pagination->url = $this->url->link('category', 'token=' . $token . '&page={page}');

        $data['pagination'] = $pagination->render();
        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('content/category_list', $data));
    }

    protected function getForm()
    {
        $token = $this->session->get('token');

        if ($this->request->hasQuery('id')) {

            $data = $this->model('content/category')->getCategory($this->request->getQuery('id'));
            $data['description'] = $this->model('content/category')->getCategoryDescriptions($this->request->getQuery('id'));
            $data['languages'] = $this->model('localisation/language')->getLanguages();


            $data['text_form'] = $this->language->get('text_edit');
            $data['action'] = $this->url->link('category/edit', 'token=' . $token . '&id=' . $this->request->getQuery('id'));

        } else {

            $data = $this->model('content/category')->getSchema('category');
            $data['path'] = '';
            $description = $this->model('content/category')->getSchema('category_description');

            $languages = $this->model('localisation/language')->getLanguages();

            foreach ($languages as $language) {
                $data['description'][$language['id']] = $description;
            }

            $data['languages'] = $languages;
            $data['text_form'] = $this->language->get('text_add');
            $data['action'] = $this->url->link('category/add', 'token=' . $token);
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if ($this->request->hasPost('image') && is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $this->request->getPost('image'))) {
            $data['thumb'] = $this->model('tool/image')->resize($this->request->getPost('image'), 100, 100);
        } elseif ($data && $data['image'] && is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $data['image'])) {
            $data['thumb'] = $this->model('tool/image')->resize($data['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model('tool/image')->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model('tool/image')->resize('no_image.png', 100, 100);

        if ($this->request->hasPost('seo_url')) {
            $data['seo_url'] = $this->request->getPost('seo_url');
        } elseif ($this->request->hasQuery('id')) {
            $data['seo_url'] = $this->model('content/category')->getCategorySeoUrls($this->request->getQuery('id'));
        } else {
            $data['seo_url'] = [];
        }

        $data['cancel'] = $this->url->link('category', 'token=' . $token);
        $data['autocomplete'] = $this->url->link('category/autocomplete', 'token=' . $token);

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('content/category_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'category')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('description') as $language_id => $value) {
            if ((strlen($value['name']) < 2) || (strlen($value['name']) > 255)) {
                $this->error = $this->language->get('error_name');
            }

            if ((strlen($value['meta_title']) < 3) || (strlen($value['meta_title']) > 255)) {
                $this->error = $this->language->get('error_meta_title');
            }
        }

        return !(bool)$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'category')) {
            $this->error = $this->language->get('error_permission');
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
            'href' => $this->url->link('category', 'token=' . $this->session->get('token'))
        ];

        return $breadcrumbs;
    }

    public function autocompleteAction()
    {
        $json = [];

        if ($this->request->hasQuery('name')) {

            $options = [
                'name' => $this->request->getQuery('name'),
                'sort' => 'name',
                'order' => 'ASC',
                'start' => 0,
                'limit' => 5
            ];

            $results = $this->model('content/category')->getCategories($options);

            foreach ($results as $result) {
                $json[] = [
                    'category_id' => $result['id'],
                    'path' => strip_tags(html_entity_decode($result['path'], ENT_QUOTES, 'UTF-8'))
                ];
            }
        }

        $sort_order = [];

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['path'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->setContent(json_encode($json));
    }
}
