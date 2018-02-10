<?php

namespace Admin\Error;

use Ions\Mvc\Action;

class ServerErrorController extends Action
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('error/server_error');

        if(isset($this->session->get('token'))){
            $data['dashboard'] = $this->url->link('common/dashboard', 'token=' . $this->session->get('token'));
        } else {
            $data['dashboard'] = $this->url->link('common/dashboard');
        }

        $this->response->setStatusCode(500);
        $this->response->setContent($this->view('error/server_error', $data));
    }
}
