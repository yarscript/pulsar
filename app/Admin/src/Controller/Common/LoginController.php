<?php

namespace Admin\Common;

use Admin\App;
use Ions\Mvc\Controller;

class LoginController extends Controller
{
    private $error;

    public function indexAction()
    {
        $data = [];

        $this->language->load('common/login');

        if (($this->request->hasQuery('token') && $this->session->has('token')) && ($this->request->hasQuery('token') === $this->session->get('token'))) {
            $this->response->redirect($this->url->link('dashboard', 'token=' . $this->session->get('token')));
        }

        if ($this->request->isPost()) {
            if ($this->validate()) {
                $this->session->set('token', $this->token());
                $this->response->redirect($this->url->link('dashboard', 'token=' . $this->session->get('token')));
            }
        } else {
            if (($this->session->has('token') && !$this->request->hasQuery('token')) || ($this->request->hasQuery('token') && ($this->session->has('token') && ($this->request->getQuery('token') != $this->session->get('token'))))) {
                $this->error = $this->language->get('error_token');
                $this->user->logout();
            }
        }

        $data['error'] = $this->error;

        $this->language->load('common/footer');
        $data['text_version'] = sprintf($this->language->get('text_version'), App::VERSION);

        if ($this->request->hasPost('username')) {
            $data['username'] = $this->request->getPost('username');
        } else {
            $data['username'] = '';
        }

        if ($this->request->hasPost('password')) {
            $data['password'] = $this->request->getPost('password');
        } else {
            $data['password'] = '';
        }

        $this->response->setContent($this->view('common/login', $data));
    }

    protected function validate()
    {
        if (!$this->request->hasPost('username') || !$this->request->hasPost('password') || !$this->user->login($this->request->getPost('username'), null, html_entity_decode($this->request->getPost('password'), ENT_QUOTES, 'UTF-8'))) {
            $this->error = $this->language->get('error_login');
        } else {
            if(strlen($this->request->getPost('username')) < 3 || strlen($this->request->getPost('password')) < 4) {
                $this->error = $this->language->get('error_login');
            }
        }

        return !$this->error;
    }

    protected function token($length = 32)
    {
        $string = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($string) - 1;
        $token = '';

        for ($i = 0; $i < $length; $i++) {
            $token .= $string[mt_rand(0, $max)];
        }

        return $token;
    }

    public function logout()
    {
        $this->user->logout();
        $this->session->delete('token');
        $this->response->redirect($this->url->link('login'));
    }
}
