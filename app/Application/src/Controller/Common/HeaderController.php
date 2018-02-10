<?php

namespace Application\Common;

use Ions\Mvc\Controller;

class HeaderController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/header');

        // Analytics
        $data['analytics'] = [];

        $analytics = $this->model('setting/extension')->getExtensions('analytics');

        foreach ($analytics as $analytic) {
            if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
                $data['analytics'][] = $this->controller('extension/analytics/' . $analytic['code']);
            }
        }

        $this->document->addStyle('vendor/fontawesome/css/font-awesome.css');
        $this->document->addStyle('vendor/bootstrap/dist/css/bootstrap.css');
        $this->document->addScript('vendor/jquery.appear.bas2k/jquery.appear.js');

        $this->document->addScript('js/app.js');

        $data['base'] = '/';
        $data['meta_title'] = $this->document->getTitle();
        $data['meta_description'] = $this->document->getDescription();
        $data['meta_keywords'] = $this->document->getKeywords();
        $data['links'] = $this->document->getLinks();
        $data['styles'] = $this->document->getStyles();
        $data['scripts'] = $this->document->getScripts('header');
        $data['lang'] = $this->language->get('code');
        $data['direction'] = $this->language->get('direction');

        $data['name'] = $this->config->get('config_name');

        $data['home'] = $this->url->link('home');

        $theme = $this->model('system/setting')->getSetting('theme_default');

        $data['page_classes'] = trim($theme['theme_default_class']);

        $data['theme'] = $theme['theme_default_theme'];

        $data['language'] = $this->controller('lang');
        $data['search'] = $this->controller('search');

        $data['pages'] = [];

        $options = [
            'top' => true
        ];

        $pages = $this->model('content/page')->getPages($options);

        // Home
        $data['pages'][] = [
            'name' => $this->language->get('text_home'),
            'href' => $this->url->link('home'),
            'children' => [],
            'active' => ''
        ];

        // Blog
        $data['pages'][] = [
            'name' => $this->language->get('text_blog'),
            'href' => $this->url->link('blog'),
            'children' => [],
            'active' => ''
        ];

        // Pages
        foreach ($pages as $page) {
            $data['pages'][] = [
                'name' => $page['name'],
                'href' => $this->url->link('content/page', 'id=' . $page['id']),
                'children' => [],
                'active' => '',
            ];
        }

        return $this->view('common/header', $data);
    }
}
