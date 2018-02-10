<?php

namespace Application\Common;

use Ions\Mvc\Controller;

class MenuController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/menu');

        $data['categories'] = [];

        $categories = $this->model('site/category')->getCategories(0);

        foreach ($categories as $category) {
            if ($category['top']) {
                // Level 2
                $children_data = [];

                $children = $this->model('site/category')->getCategories($category['id']);

                foreach ($children as $child) {
                    $filter_data = [
                        'filter_category_id' => $child['category_id'],
                        'filter_sub_category' => true
                    ];

                    $children_data[] = [
                        'name' => $child['name'] . ($this->config->get('config_page_count') ? ' (' . $this->model('site/page')->getTotalPages($filter_data) . ')' : ''),
                        'href' => $this->url->link('product/category', 'path=' . $category['id'] . '_' . $child['category_id'])
                    ];
                }

                // Level 1
                $data['categories'][] = [
                    'name' => $category['name'],
                    'children' => $children_data,
                    'column' => $category['column'] ? $category['column'] : 1,
                    'href' => $this->url->link('site/category', 'path=' . $category['id'])
                ];
            }
        }

        return $this->view('common/menu', $data);
    }
}
