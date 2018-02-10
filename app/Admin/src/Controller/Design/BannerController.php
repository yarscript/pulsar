<?php

namespace Admin\Design;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class BannerController extends Controller
{
    private $error = [];

    public function indexAction()
    {
        $this->language->load('design/banner');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->getList();
    }

    public function addAction()
    {
        $this->language->load('design/banner');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('design/banner')->addBanner($this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('banner', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function editAction()
    {
        $this->language->load('design/banner');

        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->request->isPost() && $this->validateForm()) {
            $this->model('design/banner')->editBanner($this->request->getQuery('id'), $this->request->getPost());
            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('banner', 'token=' . $this->session->get('token')));
        }

        $this->getForm();
    }

    public function deleteAction()
    {
        $this->language->load('design/banner');

        if ($this->request->hasPost('selected') && $this->validateDelete()) {
            foreach ($this->request->getPost('selected') as $id) {
                $this->model('design/banner')->deleteBanner($id);
            }

            $this->session->set('success', $this->language->get('text_success'));
            $this->response->redirect($this->url->link('banner', 'token=' . $this->session->get('token')));
        }

        $this->getList();
    }

    protected function getList()
    {
        $token = $this->session->get('token');

        if ($this->request->hasQuery('page')) {
            $data['page'] = $this->request->getQuery('page');
        } else {
            $data['page'] = 1;
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        $data['add'] = $this->url->link('banner/add', 'token=' . $token);
        $data['edit'] = $this->url->link('banner/edit', 'token=' . $token);
        $data['delete'] = $this->url->link('banner/delete', 'token=' . $token);

        $data['banners'] = [];

        $data['limit'] = $this->config->get('config_limit');

        $options = [
            'start' => ($data['page'] - 1) * $data['limit'],
            'limit' => $data['limit']
        ];

        $data['banners'] = $this->model('design/banner')->getBanners($options);
        $data['total']  = $this->model('design/banner')->getTotalBanners();

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

        $pagination = new Pagination();
        $pagination->total = $data['total'];
        $pagination->page = $data['page'];
        $pagination->limit = $data['limit'];
        $pagination->url = $this->url->link('banner', 'token=' . $token . '&page={page}');

        $data['pagination'] = $pagination->render();
        $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('design/banner_list', $data));
    }

    protected function getForm()
    {
        $token = $this->session->get('token');

        $data['text_form'] = !$this->request->hasQuery('id') ? $this->language->get('text_add') : $this->language->get('text_edit');

        if ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        $data['breadcrumbs'] = $this->breadcrumbs();

        if (!$this->request->hasQuery('id')) {
            $data['text_form'] = $this->language->get('text_add');
            $data['action'] = $this->url->link('banner/add', 'token=' . $token);
        } else {
            $data['text_form'] = $this->language->get('text_edit');
            $data['action'] = $this->url->link('banner/edit', 'token=' . $token . '&id=' . $this->request->getQuery('id'));
        }

        $data['cancel'] = $this->url->link('banner', 'token=' . $token);

        if ($this->request->hasQuery('id') && !$this->request->isPost()) {
            $banner_info = $this->model('design/banner')->getBanner($this->request->getQuery('id'));
        }

        if ($this->request->hasPost('name')) {
            $data['name'] = $this->request->getPost('name');
        } elseif (!empty($banner_info)) {
            $data['name'] = $banner_info['name'];
        } else {
            $data['name'] = '';
        }

        if ($this->request->hasPost('status')) {
            $data['status'] = $this->request->getPost('status');
        } elseif (!empty($banner_info)) {
            $data['status'] = $banner_info['status'];
        } else {
            $data['status'] = true;
        }

        $data['languages'] = $this->model('localisation/language')->getLanguages();

        $data['images'] = $images = [];

        if ($this->request->hasPost('image')) {
            $images = $this->request->getPost('image');
        } elseif ($this->request->hasQuery('id')) {
            $images = $this->model('design/banner')->getBannerImages($this->request->getQuery('id'));
        }

        foreach ($images as $key => $value) {
            foreach ($value as $banner_image) {
                if (is_file($this->image->getDirectory() . DIRECTORY_SEPARATOR . $banner_image['image'])) {
                    $image = $banner_image['image'];
                    $thumb = $banner_image['image'];
                } else {
                    $image = '';
                    $thumb = 'no_image.png';
                }

                //$this->model('tool/image')->resize('no_image.png', 100, 100);

                $data['images'][$key][] = [
                    'title' => $banner_image['title'],
                    'link' => $banner_image['link'],
                    'image' => $image,
                    'thumb' => $this->model('tool/image')->resize($thumb, 100, 100),
                    'sort_order' => $banner_image['sort_order']
                ];
            }
        }

        $data['placeholder'] = $this->model('tool/image')->resize('no_image.png', 100, 100);

        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');

        $this->response->setContent($this->view('design/banner_form', $data));
    }

    protected function validateForm()
    {
        if (!$this->user->hasPermission('modify', 'banner')) {
            $this->error = $this->language->get('error_permission');
        }

        $length = strlen($this->request->getPost('name'));

        if ($length < 3 || $length > 64) {
            $this->error = $this->language->get('error_name');
        }

        if ($this->request->hasPost('image')) {
            foreach ($this->request->getPost('image') as $language_id => $value) {
                foreach ($value as $id => $image) {
                    $length = strlen($image['title']);
                    if ($length < 2 || $length > 64) {
                        $this->error = $this->language->get('error_title');
                    }
                }
            }
        }

        return !$this->error;
    }

    protected function validateDelete()
    {
        if (!$this->user->hasPermission('modify', 'banner')) {
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
            'href' => $this->url->link('banner', 'token=' . $this->session->get('token'))
        ];

        return $breadcrumbs;
    }
}
