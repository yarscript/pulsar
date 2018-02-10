<?php

namespace Application\Extension\Module;

use Ions\Mvc\Controller;

class CategoryController extends Controller
{
    public function processAction()
    {
        $this->language->load('extension/module/category');

        if (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
        } else {
            $parts = [];
        }

        if (isset($parts[0])) {
            $data['category_id'] = $parts[0];
        } else {
            $data['category_id'] = 0;
        }

        if (isset($parts[1])) {
            $data['child_id'] = $parts[1];
        } else {
            $data['child_id'] = 0;
        }

        $data['categories'] = [];

        $categories = $this->model('content/category')->getCategories(0);

        foreach ($categories as $category) {
            $children_data = [];

            if ($category['id'] == $data['id']) {
                $children = $this->model('content/category')->getCategories($category['id']);

                foreach($children as $child) {
                    $options = [
                        'category_id' => $child['id'],
                        'sub_category' => true
                    ];

                    $children_data[] = [
                        'id' => $child['id'],
                        'name' => $child['name'] . ($this->config->get('config_post_count') ? ' (' . $this->model('content/post')->getTotalPosts($options) . ')' : ''),
                        'href' => $this->url->link('category', 'language=' . $this->config->get('config_language') . '&path=' . $category['id'] . '_' . $child['id'])
                    ];
                }
            }

            $options = [
                'category_id'  => $category['id'],
                'sub_category' => true
            ];

            $data['categories'][] = [
                'id' => $category['id'],
                'name'        => $category['name'] . ($this->config->get('config_post_count') ? ' (' . $this->model('content/post')->getTotalPosts($options) . ')' : ''),
                'children'    => $children_data,
                'href'        => $this->url->link('category', 'language=' . $this->config->get('config_language') . '&path=' . $category['id'])
            ];
        }

        return $this->view('extension/module/category', $data);
    }
}
