<?php

namespace Admin\Error;

use Ions\Mvc\Controller;

class NotFoundController extends Controller
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('error/not_found');

        if($this->session->has('token')){
            $data['dashboard'] = $this->url->link('common/dashboard', 'token=' . $this->session->get('token'));
        } else {
            $data['dashboard'] = $this->url->link('common/dashboard');
        }

        $this->response->setStatusCode(404);
        $this->response->setContent($this->view('error/not_found', $data));
    }

    public function notFoundAction()
    {
        $data = [];

        $this->language->load('error/not_found');

        if($this->session->has('token')){
            $data['dashboard'] = $this->url->link('common/dashboard', 'token=' . $this->session->get('token'));
        } else {
            $data['dashboard'] = $this->url->link('common/dashboard');
        }

        $this->response->setStatusCode(404);
        $this->response->setContent($this->view('error/not_found', $data));
    }
}
