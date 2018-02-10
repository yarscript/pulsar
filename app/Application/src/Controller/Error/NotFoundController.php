<?php

namespace Application\Error;

use Ions\Mvc\Controller;

class NotFoundController extends Controller
{
    public function indexAction()
    {
        $this->language->load('error/not_found');

        $data['home'] = $this->url->link('home');

        $this->response->setContent($this->view('error/not_found', $data));
    }
}
