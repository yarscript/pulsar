<?php

namespace Admin\Error;

use Ions\Mvc\Controller;

class PermissionController extends Controller
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('error/permission');

        $data['dashboard'] = $this->url->link('common/dashboard', 'token=' . $this->session->get('token'));

        $this->response->setStatusCode(401);
        $this->response->setContent($this->view('error/permission', $data));
    }
}
