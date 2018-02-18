<?php

namespace Application\Common;

use Ions\Mvc\Controller;

class MenuController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/menu');

        $data['categories'] = [];

        $categories = $this->model('content/category')->getCategories(0);


        if ($this->request->hasQuery('path')) {
            $parts = explode('_', (string)$this->request->getQuery('path'));

            $category_id = (int)array_shift($parts);
            $child_id = (int)array_shift($parts);
        } else {
            $category_id = 0;
            $child_id = 0;
        }

        foreach ($categories as $category) {
            if ($category['top']) {
                // Level 2
                $children_data = [];

                $children = $this->model('content/category')->getCategories($category['id']);

                foreach ($children as $child) {
                    $children_data[] = [
                        'name' => $child['name'],
                        'href' => $this->url->link('category', 'path=' . $category['id'] . '_' . $child['id']),
                        'active' => $child_id == $child['id'] ? 'active' : ''
                    ];
                }

                // Level 1
                $data['categories'][] = [
                    'name' => $category['name'],
                    'children' => $children_data,
                    'href' => $this->url->link('category', 'path=' . $category['id']),
                    'active' => $category_id == $category['id'] ? 'active' : ''
                ];
            }
        }

        return $this->view('common/menu', $data);
    }
}
