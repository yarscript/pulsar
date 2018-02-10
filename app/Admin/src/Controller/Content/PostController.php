<?php

namespace Admin\Content;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class PostController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('content/post');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('content/post');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $data = $this->request->getPost();
            $data['user_id'] = $this->user->getId();
            $this->model('content/post')->addPost($data);
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('post', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('content/post');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $data = $this->request->getPost();
            $data['user_id'] = $this->user->getId();
            $this->model('content/post')->editPost($this->request->getQuery('id'), $data);
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('post', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('content/post');

        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('content/post')->deletePost($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('post', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        $token = $this->session->get('token');

        $data['heading_title'] = $this->language->get('heading_title');

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

        $data['posts'] = $this->model('content/post')->getPosts();
        $data['total'] = $this->model('content/post')->getTotalPosts();
        $data['limit'] = $this->config->get('config_limit');

        $data['add'] = $this->url->link('post/add', 'token=' . $token);
        $data['edit'] = $this->url->link('post/edit', 'token=' . $token);
        $data['delete'] = $this->url->link('post/delete', 'token=' . $token);

        foreach ($data['posts'] as & $post) {
            if (is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $post['image'])) {
                $post['image'] = $this->model('tool/image')->resize($post['image'], 100, 100);
            } else {
                $post['image'] = $this->model('tool/image')->resize('no_image.png', 100, 100);
            }
        }

        $pagination = new Pagination();
        $pagination->total = $data['total'];
        $pagination->page = $data['page'];
        $pagination->limit = $data['limit'];
        $pagination->url = $this->url->link('post', 'token=' . $token . '&page={page}');

        $data['pagination'] = $pagination->render();
        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('content/post_list', $data));
    }

    protected function getForm()
    {
        $token = $this->session->get('token');
        $data['categories'] = [];

        if ($this->request->hasPost('related')) {
            $posts = $this->request->getPost('related');
        } elseif ($this->request->hasQuery('id')) {
            $posts = $this->model('content/post')->getPostRelated($this->request->getQuery('id'));
        } else {
            $posts = [];
        }

        $data['relateds'] = [];

        foreach ($posts as $id) {
            $related_info = $this->model('content/post')->getPost($id);

            if ($related_info) {
                $data['relateds'][] = [
                    'id' => $related_info['id'],
                    'name'       => $related_info['name']
                ];
            }
        }

        if ($this->request->hasQuery('id')) {
            $data['post'] = $this->model('content/post')->getPost($this->request->getQuery('id'));
            $data['description'] = $this->model('content/post')->getPostDescriptions($this->request->getQuery('id'));
            $data['languages'] = $this->model('localisation/language')->getLanguages();

            // Categories
            $categories = $this->model('content/post')->getPostCategories($this->request->getQuery('id'));

            foreach ($categories as $category_id) {
                $category_info = $this->model('content/category')->getCategory($category_id);

                if ($category_info) {
                    $data['categories'][] = [
                        'category_id' => $category_info['category_id'],
                        'name' => $category_info['path'] ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
                    ];
                }
            }

            $data['text_form'] = $this->language->get('text_edit');
            $data['action'] = $this->url->link('post/edit', 'token=' . $token . '&id=' . $this->request->getQuery('id'));

        } else {

            $data['post'] = $this->model('content/post')->getSchema('post');
            $description = $this->model('content/post')->getSchema('post_description');

            $languages = $this->model('localisation/language')->getLanguages();

            foreach ($languages as $language) {
                $data['description'][$language['id']] = $description;
            }

            $data['languages'] = $languages;
            $data['text_form'] = $this->language->get('text_add');
            $data['action'] = $this->url->link('post/add', 'token=' . $token);
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if ($this->request->hasPost('image')) {
            $data['image'] = $this->request->getPost('image');
        } else {
            $data['image'] = $data['post']['image'];
        }

        if ($this->request->hasPost('image') && is_file($this->image->getDirectory() . '/' . $this->request->getPost('image'))) {
            $data['thumb'] = $this->model('tool/image')->resize($this->request->getPost('image'), 100, 100);
        } elseif (!empty($data['post']) && $data['post']['image'] && is_file($this->image->getDirectory() . '/' . $data['post']['image'])) {
            $data['thumb'] = $this->model('tool/image')->resize($data['post']['image'], 100, 100);
        } else {
            $data['thumb'] = $this->model('tool/image')->resize('no_image.png', 100, 100);
        }

        $data['placeholder'] = $this->model('tool/image')->resize('no_image.png', 100, 100);

        if ($this->request->hasPost('seo_url')) {
            $data['seo_url'] = $this->request->getPost('seo_url');
        } elseif ($this->request->hasQuery('id')) {
            $data['seo_url'] = $this->model('content/post')->getPostSeoUrls($this->request->getQuery('id'));
        } else {
            $data['seo_url'] = [];
        }

        $data['cancel'] = $this->url->link('post', 'token=' . $token);
        $data['category_autocomplete'] = $this->url->link('category/autocomplete', 'token=' . $token);
        $data['autocomplete'] = $this->url->link('post/autocomplete', 'token=' . $token);

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('content/post_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'post')) {
            $this->error = $this->language->get('error_permission');
        }

        foreach ($this->request->getPost('description') as $language_id => $value) {
            $len = strlen($value['name']);

            if ($len < 3 || $len > 255) {
                $this->error = $this->language->get('error_name');
            }

            $len = strlen($value['meta_title']);

            if ($len < 3 || $len > 255) {
                $this->error = $this->language->get('error_meta_title');
            }
        }

        return !(bool)$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'post')) {
            $this->error = $this->language->get('error_permission');
        }

        return !(bool)$this->error;
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
            'href' => $this->url->link('post', 'token=' . $this->session->get('token'))
        ];

        return $breadcrumbs;
    }

    public function autocompleteAction() {
        $json = [];

        if ($this->request->hasQuery('name')) {

            if (isset($this->request->get['limit'])) {
                $limit = $this->request->get['limit'];
            } else {
                $limit = 5;
            }

            $options = [
                'name'  => $this->request->getQuery('name'),
                'start'        => 0,
                'limit'        => $limit
            ];

            $results = $this->model('content/post')->getPosts($options);

            foreach ($results as $result) {
                $json[] = [
                    'id' => $result['id'],
                    'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                ];
            }
        }

        //$this->response->addHeader('Content-Type: application/json');
        $this->response->setContent(json_encode($json));
    }
}
