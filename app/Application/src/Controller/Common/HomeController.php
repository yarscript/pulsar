<?php

namespace Application\Common;

use Ions\Mvc\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/home');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setDescription($this->config->get('config_meta_description'));
        $this->document->setKeywords($this->config->get('config_meta_keyword'));


        $data['name'] = $this->config->get('config_name');

        $data['home'] = $this->url->link('home');

        // Layout
        $data['column_left'] = $this->controller('column_left');
        $data['column_right'] = $this->controller('column_right');
        $data['content_top'] = $this->controller('content_top');
        $data['content_bottom'] = $this->controller('content_bottom');
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('common/home', $data));
    }
}
