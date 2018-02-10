<?php

namespace Admin\System;

use Ions\Mvc\Controller;

class BackupController extends Controller
{
    private $error;

    public function indexAction()
    {
        $this->language->load('system/backup');
        $this->document->setTitle($this->language->get('heading_title'));

        if ($this->session->has('error')) {
            $data['error'] = $this->session->get('error');
            $this->session->delete('error');
        } elseif ($this->error) {
            $data['error'] = $this->error;
        } else {
            $data['error'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');
            $this->session->delete('success');
        } else {
            $data['success'] = '';
        }

        $data['restore'] = $this->url->link('backup/restore', 'token=' . $this->session->get('token'));
        $data['backup'] = $this->url->link('backup/backup', 'token=' . $this->session->get('token'));
        $data['cancel'] = $this->url->link('dashboard', 'token=' . $this->session->get('token'));

        $data['tables'] = $this->model('system/backup')->getTables('pulsar');

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('system/backup', $data));
    }

    public function restoreAction()
    {
        $this->language->load('system/backup');

        $error = '';

        if ($this->request->isPost()) {
            if ($this->user->hasPermission('modify', 'backup')) {
                $content = '';

                if ($this->request->getFiles() && is_uploaded_file($this->request->getFiles('import')['tmp_name'])) {
                    $content = file_get_contents($this->request->getFiles('import')['tmp_name']);
                }

                if ($content) {
                    $this->model('system/backup')->restore($content);
                } else {
                    $error = $this->language->get('error_empty');
                }

            } else {
                $error = $this->language->get('error_permission');
            }
        } else {
            $error = $this->language->get('error_export');
        }

        if ($error) {
            $this->session->set('error', $error);
        } else {
            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->response->redirect($this->url->link('backup', 'token=' . $this->session->get('token')));
    }

    public function backupAction()
    {
        $this->language->load('system/backup');

        $error = '';

        if (!$this->request->hasPost('backup')) {
            $error = $this->language->get('error_export');
        } elseif (!$this->user->hasPermission('modify', 'backup')) {
            $error = $this->language->get('error_permission');
        } else {
            $this->response->getHeaders()->addHeaders([
                'Pragma' => 'public',
                'Expires' => '0',
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . $this->config->get('database') . '_' . date('Y-m-d_H-i-s', time()) . '_backup.sql"',
                'Content-Transfer-Encoding' => 'binary'
            ]);

            $this->response->setContent($this->model('system/backup')->backup($this->request->getPost('backup')));
            $this->response->send();
        }

        if ($error) {
            $this->session->set('error', $error);
            $this->response->redirect($this->url->link('backup', 'token=' . $this->session->get('token')));
        }
    }
}
