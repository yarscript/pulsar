<?php

namespace Application\Content;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class SearchController extends Controller
{
    public function indexAction()
    {
        $this->language->load('content/search');

        if (isset($this->request->get['search'])) {
            $search = $this->request->get['search'];
        } else {
            $search = '';
        }

        if (isset($this->request->get['tag'])) {
            $tag = $this->request->get['tag'];
        } elseif (isset($this->request->get['search'])) {
            $tag = $this->request->get['search'];
        } else {
            $tag = '';
        }

        if (isset($this->request->get['description'])) {
            $description = $this->request->get['description'];
        } else {
            $description = '';
        }

        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        } else {
            $category_id = 0;
        }

        if (isset($this->request->get['sub_category'])) {
            $sub_category = $this->request->get['sub_category'];
        } else {
            $sub_category = '';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = (int)$this->request->get['limit'];
        } else {
            $limit = $this->config->get('theme_' . $this->config->get('config_theme') . '_post_limit');
        }

        if (isset($this->request->get['search'])) {
            $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['search']);
        } elseif (isset($this->request->get['tag'])) {
            $this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->language->get('heading_tag') . $this->request->get['tag']);
        } else {
            $this->document->setTitle($this->language->get('heading_title'));
        }

        if (isset($this->request->get['search'])) {
            $data['heading_title'] = $this->language->get('heading_title') . ' - ' . $this->request->get['search'];
        } else {
            $data['heading_title'] = $this->language->get('heading_title');
        }

        // 3 Level Category Search
        $data['categories'] = [];

        $categories_1 = $this->model('content/category')->getCategories(0);

        foreach ($categories_1 as $category_1) {
            $level_2_data = [];

            $categories_2 = $this->model('content/category')->getCategories($category_1['id']);

            foreach ($categories_2 as $category_2) {
                $level_3_data = [];

                $categories_3 = $this->model('content/category')->getCategories($category_2['id']);

                foreach ($categories_3 as $category_3) {
                    $level_3_data[] = [
                        'id' => $category_3['id'],
                        'name' => $category_3['name'],
                    ];
                }

                $level_2_data[] = [
                    'id' => $category_2['id'],
                    'name' => $category_2['name'],
                    'children' => $level_3_data
                ];
            }

            $data['categories'][] = [
                'id' => $category_1['id'],
                'name' => $category_1['name'],
                'children' => $level_2_data
            ];
        }

        $data['posts'] = [];

        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $filter_data = [
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            ];

            $post_total = $this->model('content/post')->getTotalPosts($filter_data);

            $results = $this->model('content/post')->getPosts($filter_data);

            foreach ($results as $result) {
                $data['posts'][] = [
                    'id' => $result['id'],
                    'name' => $result['name'],
                    'description' => substr(trim(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_post_description_length')) . '..',
                    'href' => $this->url->link('post', 'id=' . $result['id'])
                ];
            }

            $data['limits'] = [];

            $limits = array_unique([$this->config->get('theme_' . $this->config->get('config_theme') . '_post_limit'), 25, 50, 75, 100]);

            sort($limits);

            foreach ($limits as $value) {
                $data['limits'][] = [
                    'text' => $value,
                    'value' => $value,
                    'href' => $this->url->link('search' . '&limit=' . $value)
                ];
            }

            $pagination = new Pagination();
            $pagination->total = $post_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->url = $this->url->link('search', '&page={page}');

            $data['pagination'] = $pagination->render();

            $data['results'] = $pagination->renderResult($this->language->get('text_pagination'));

            if ($this->request->hasQuery('search') && $this->config->get('config_user_search')) {

                if ($this->user->isLogged()) {
                    $user_id = $this->user->getId();
                } else {
                    $user_id = 0;
                }

                if (isset($this->request->server['REMOTE_ADDR'])) {
                    $ip = $this->request->server['REMOTE_ADDR'];
                } else {
                    $ip = '';
                }

                $search_data = [
                    'keyword' => $search,
                    'category_id' => $category_id,
                    'sub_category' => $sub_category,
                    'description' => $description,
                    'posts' => $post_total,
                    'user_id' => $user_id,
                    'ip' => $ip
                ];

                $this->model('account/search')->addSearch($search_data);
            }
        }

        $data['search'] = $search;
        $data['description'] = $description;
        $data['category_id'] = $category_id;
        $data['sub_category'] = $sub_category;

        $data['limit'] = $limit;

        $data['column_left'] = $this->controller('column_left');
        $data['column_right'] = $this->controller('column_right');
        $data['content_top'] = $this->controller('content_top');
        $data['content_bottom'] = $this->controller('content_bottom');
        $data['footer'] = $this->controller('footer');
        $data['header'] = $this->controller('header');

        $this->response->setContent($this->view('content/search', $data));
    }
}
