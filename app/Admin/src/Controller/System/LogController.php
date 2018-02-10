<?php

namespace Admin\System;

use Ions\Mvc\Controller;

class LogController extends Controller
{
    public function indexAction()
    {
        $this->language->load('system/log');

        $this->document->setTitle($this->language->get('heading_title'));

        $token = $this->session->get('token');

        if ($this->session->has('error')) {
            $data['error'] = $this->session->get('error');

            $this->session->delete('error');
        } else {
            $data['error'] = '';
        }

        if ($this->session->has('success')) {
            $data['success'] = $this->session->get('success');

            $this->session->delete('success');
        } else {
            $data['success'] = '';
        }

        $data['log'] = '';

        $file = $this->log->getOption('path') . DIRECTORY_SEPARATOR . $this->config->get('config_error_filename');

        if (file_exists($file)) {
            $size = filesize($file);

            if ($size >= 5242880) {
                $suffix = array(
                    'B',
                    'KB',
                    'MB',
                    'GB',
                    'TB',
                    'PB',
                    'EB',
                    'ZB',
                    'YB'
                );

                $i = 0;

                while (($size / 1024) > 1) {
                    $size /= 1024;
                    $i++;
                }

                $data['error_'] = sprintf($this->language->get('error_warning'), basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i] . 'B');
            } else {
                $data['log'] = file_get_contents($file, FILE_USE_INCLUDE_PATH, null);
            }
        }

        $data['download'] = $this->url->link('log/download', 'token=' . $token);
        $data['clear'] = $this->url->link('log/clear', 'token=' . $token);
        $data['cancel'] = $this->url->link('dashboard', 'token=' . $token);

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('system/log', $data));
    }

    public function downloadAction()
    {
        $this->language->load('system/log');

        $token = $this->session->get('token');

        $file = $this->log->getOption('path') . DIRECTORY_SEPARATOR . $this->config->get('config_error_filename');

        if (file_exists($file) && filesize($file) > 0) {
            $this->response->getHeaders()->addHeaders([
                'Pragma' => 'public',
                'Expires' => '0',
                'Content-Description' => 'File Transfer',
                'Content-Type' => 'application/octet-stream',
                'Content-Disposition' => 'attachment; filename="' . date('Y-m-d_H-i-s', time()) . '_' . $this->config->get('config_error_filename') . '"',
                'Content-Transfer-Encoding' => 'binary'
            ]);

            $this->response->setContent(file_get_contents($file, FILE_USE_INCLUDE_PATH, null));
            $this->response->send();
        } else {
            $this->session->set('error', sprintf($this->language->get('error_warning'), basename($file), '0B'));
            $this->response->redirect($this->url->link('log', 'token=' . $token));
        }
    }

    public function clearAction()
    {
        $this->language->load('system/log');

        $token = $this->session->get('token');

        if (!$this->user->hasPermission('modify', 'log')) {
            $this->response->redirect($this->url->link('error/permission', 'token=' . $token));
        } else {
            $file = $this->log->getOption('path') . DIRECTORY_SEPARATOR . $this->config->get('config_error_filename');

            $handle = fopen($file, 'wb+');

            fclose($handle);

            $this->session->set('success', $this->language->get('text_success'));
        }

        $this->response->redirect($this->url->link('log', 'token=' . $token));
    }
}
