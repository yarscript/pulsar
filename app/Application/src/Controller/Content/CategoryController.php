<?php

namespace Application\Content;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        $this->language->load('content/category');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setDescription($this->config->get('config_meta_description'));
        $this->document->setKeywords($this->config->get('config_meta_keyword'));

        if ($this->request->hasQuery('page')) {
            $page = $this->request->getQuery('page');
        } else {
            $page = 1;
        }

        if ($this->request->hasQuery('limit')) {
            $limit = (int)$this->request->getQuery('limit');
        } else {
            $limit = $this->config->get('config_limit');
        }

        if ($this->request->hasQuery('path')) {
            $path = '';

            $parts = explode('_', (string)$this->request->getQuery('path'));

            $category_id = (int)array_pop($parts);

            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = (int)$path_id;
                } else {
                    $path .= '_' . (int)$path_id;
                }
            }
        } else {
            $category_id = 0;
        }

        $category_info = $this->model('content/category')->getCategory($category_id);

        if ($category_info) {
            $this->document->setTitle($category_info['meta_title']);
            $this->document->setDescription($category_info['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);

            $data['heading_title'] = $category_info['name'];

            $data['name'] = $category_info['name'];

            $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $data['image'] = 'img' . $category_info['image'];

            $data['posts'] = [];

            $options = [
                'category_id' => $category_id,
                //'order'              => 'DESC',
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            ];

            $post_total = $this->model('content/post')->getTotalPosts($options);
            $results = $this->model('content/post')->getPosts($options);

            foreach ($results as $id => $result) {
                $data['posts'][] = [
                    'id' => $id,
                    'name' => $result['name'],
                    'description' => substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, 100/*$this->config->get('theme_' . $this->config->get('config_theme') . '_post_description_length')*/) . '..',
                    'href' => $this->url->link('post', 'path=' . $this->request->getQuery('path') . '&id=' . $id),
                    'date' => $result['date'],
                    'author' => $result['author'],
                    'image' => 'img' . $result['image'],
                    'ago' => $result['ago']
                ];
            }

            $data['limits'] = [];

            $pagination = new Pagination();
            $pagination->total = $post_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('category', 'path=' . $this->request->getQuery('path') . '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

            // http://googlewebmastercentral.contentspot.com/2011/09/pagination-with-relnext-and-relprev.html
            if ($page == 1) {
                $this->document->addLink($this->url->link('category', 'path=' . $category_info['id']), 'canonical');
            } else {
                $this->document->addLink($this->url->link('category', 'path=' . $category_info['id'] . '&page=' . $page), 'canonical');
            }

            if ($page > 1) {
                $this->document->addLink($this->url->link('category', 'path=' . $category_info['id'] . (($page - 2) ? '&page=' . ($page - 1) : '')), 'prev');
            }

            if ($limit && ceil($post_total / $limit) > $page) {
                $this->document->addLink($this->url->link('category', 'path=' . $category_info['id'] . '&page=' . ($page + 1)), 'next');
            }

            $data['limit'] = $limit;

            $data['column_left'] = $this->controller('column_left');
            $data['column_right'] = $this->controller('column_right');
            $data['content_top'] = $this->controller('content_top');
            $data['content_bottom'] = $this->controller('content_bottom');
            $data['footer'] = $this->controller('footer');
            $data['header'] = $this->controller('header');

            $this->response->setContent($this->view('content/category', $data));
        } else {
            $this->language->load('error/not_found');
            $data['heading_title'] = $this->language->get('text_error');

            //$this->response->addHeader($this->request->server['SERVER_PROTOCOL'], ' 404 Not Found');

            $data['column_left'] = $this->controller('column_left');
            $data['column_right'] = $this->controller('column_right');
            $data['content_top'] = $this->controller('content_top');
            $data['content_bottom'] = $this->controller('content_bottom');
            $data['footer'] = $this->controller('footer');
            $data['header'] = $this->controller('header');

            $this->response->setContent($this->view('error/not_found', $data));
        }
    }
}
