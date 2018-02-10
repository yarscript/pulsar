<?php

namespace Application\Content;

use Ions\Mvc\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        $this->language->load('content/page');

        if ($this->request->hasQuery('id')) {
            $id = (int)$this->request->getQuery('id');
        } else {
            $id = 0;
        }

        $page_info = $this->model('content/page')->getPage($id);

        if ($page_info) {
            $this->document->setTitle($page_info['meta_title']);
            $this->document->setDescription($page_info['meta_description']);
            $this->document->setKeywords($page_info['meta_keyword']);

            $data['description'] = html_entity_decode($page_info['description'], ENT_QUOTES, 'UTF-8');

            $this->model('content/page')->updateViewed($this->request->getQuery('id'));

            $data['column_left'] = $this->controller('column_left');
            $data['column_right'] = $this->controller('column_right');
            $data['footer'] = $this->controller('footer');
            $data['header'] = $this->controller('header');

            $this->response->setContent($this->view('content/page', $data));
        } else {
            $this->language->load('error/not_found');
            $data['heading_title'] = $this->language->get('text_error');

            //$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['footer'] = $this->controller('footer');
            $data['header'] = $this->controller('header');

            $this->response->setContent($this->view('error/not_found', $data));
        }
    }
}
