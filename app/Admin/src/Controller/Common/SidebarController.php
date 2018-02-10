<?php

namespace Admin\Common;

use Ions\Mvc\Controller;

class SidebarController extends Controller
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('common/sidebar');

        $token = $this->session->get('token');

        // Menu
        $data['menus'][] = [
            'id' => 'menu-dashboard',
            'icon' => 'fa fa-dashboard',
            'name' => $this->language->get('text_dashboard'),
            'href' => $this->url->link('dashboard', 'token=' . $token),
            'children' => []
        ];

//        $data['menus'][] = [
//            'id' => '',
//            'name' => $this->language->get('text_application')
//        ];

        // Pages
        $pages = [
            [
                'name' => $this->language->get('text_page'),
                'href' => $this->url->link('page', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_add'),
                'href' => $this->url->link('page/add', 'token=' . $token),
                'children' => []
            ]
        ];

        $data['menus'][] = [
            'id' => 'menu-pages',
            'icon' => 'fa fa-files-o',
            'name' => $this->language->get('text_pages'),
            'href' => '',
            'children' => $pages
        ];

        // Posts
        $posts = [
            [
                'name' => $this->language->get('text_post'),
                'href' => $this->url->link('post', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_add'),
                'href' => $this->url->link('post/add', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_category'),
                'href' => $this->url->link('category', 'token=' . $token),
                'children' => []
            ],
        ];

        $data['menus'][] = [
            'id' => 'menu-posts',
            'icon' => 'fa fa-cubes',
            'name' => $this->language->get('text_posts'),
            'href' => '',
            'children' => $posts
        ];

        // Design
        $design = [
            [
                'name' => $this->language->get('text_layout'),
                'href' => $this->url->link('layout', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_banner'),
                'href' => $this->url->link('banner', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_seo'),
                'href' => $this->url->link('seo', 'token=' . $token),
                'children' => []
            ],
        ];

        $data['menus'][] = [
            'id' => 'menu-design',
            'icon' => 'fa fa-desktop',
            'name' => $this->language->get('text_design'),
            'href' => '',
            'children' => $design
        ];

        // Extension
        $extension = [
            [
                'name' => $this->language->get('text_dashboard'),
                'href' => $this->url->link('extension/extension/dashboard', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_theme'),
                'href' => $this->url->link('extension/extension/theme', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_module'),
                'href' => $this->url->link('extension/extension/module', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_analytics'),
                'href' => $this->url->link('extension/extension/analytics', 'token=' . $token),
                'children' => []
            ],
        ];

        $data['menus'][] = [
            'id' => 'menu-extension',
            'icon' => 'fa fa-puzzle-piece',
            'name' => $this->language->get('text_extension'),
            'href' => '',
            'children' => $extension
        ];

        // Localisation
        $localisation = [
            [
                'name' => $this->language->get('text_language'),
                'href' => $this->url->link('language', 'token=' . $token),
                'children' => []
            ]
        ];

        $data['menus'][] = [
            'id' => 'menu-localisation',
            'icon' => 'fa fa-flag',
            'name' => $this->language->get('text_localisation'),
            'href' => '',
            'children' => $localisation
        ];

        // System
        $system = [
            [
                'name' => $this->language->get('text_setting'),
                'href' => $this->url->link('setting', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_backup'),
                'href' => $this->url->link('backup', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_log'),
                'href' => $this->url->link('log', 'token=' . $token),
                'children' => []
            ],
        ];

        $data['menus'][] = [
            'id' => 'menu-system',
            'icon' => 'fa fa-gear',
            'name' => $this->language->get('text_system'),
            'href' => '',
            'children' => $system
        ];

        // User
        $user = [
            [
                'name' => $this->language->get('text_user'),
                'href' => $this->url->link('user', 'token=' . $token),
                'children' => []
            ],
            [
                'name' => $this->language->get('text_user_group'),
                'href' => $this->url->link('user-group', 'token=' . $token),
                'children' => []
            ],
        ];

        $data['menus'][] = [
            'id' => 'menu-user',
            'icon' => 'fa fa-user',
            'name' => $this->language->get('text_user'),
            'href' => '',
            'children' => $user
        ];

        // Report
        $report = [
            [
                'name' => $this->language->get('text_online'),
                'href' => $this->url->link('online', 'token=' . $token),
                'children' => []
            ]
        ];

        $data['menus'][] = [
            'id' => 'menu-report',
            'icon' => 'fa fa-bar-chart',
            'name' => $this->language->get('text_report'),
            'href' => '',
            'children' => $report
        ];

        $data['dashboard'] = $this->url->link('dashboard', 'token=' . $token);

        return $this->view('common/sidebar', $data);
    }
}
