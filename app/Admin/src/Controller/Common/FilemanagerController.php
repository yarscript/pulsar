<?php

namespace Admin\Common;

use Ions\Mvc\Service\Pagination;
use Ions\Mvc\Controller;

class FilemanagerController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/filemanager');

        if ($this->request->hasQuery('filter_name')) {
            $filter_name = str_replace('*', '', $this->request->getQuery('filter_name'));
        } else {
            $filter_name = null;
        }

        if ($this->request->hasQuery('directory')) {
            $directory = $this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR. str_replace('*', '', $this->request->getQuery('directory'));
        } else {
            $directory = $this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data';
        }

        if ($this->request->hasQuery('page')) {
            $page = $this->request->getQuery('page');
        } else {
            $page = 1;
        }

        $directories = [];
        $files = [];

        $data['images'] = [];

        $directory = realpath($directory . DIRECTORY_SEPARATOR . $filter_name);

        if ($directory) {
            $directories = glob($directory . DIRECTORY_SEPARATOR . $filter_name . '*', GLOB_ONLYDIR);

            if (!$directories) {
                $directories = [];
            }

            $files = glob($directory . DIRECTORY_SEPARATOR . $filter_name . '*.{jpg,jpeg,png,gif,JPG,JPEG,PNG,GIF}', GLOB_BRACE);

            if (!$files) {
                $files = [];
            }
        }

        $images = array_merge($directories, $files);
        $image_total = count($images);
        $images = array_splice($images, ($page - 1) * 16, 16);

        foreach ($images as $image) {
            $name = str_split(basename($image), 14);

            if (is_dir($image)) {
                $url = '';

                if ($this->request->hasQuery('target')) {
                    $url .= '&target=' . $this->request->getQuery('target');
                }
                if ($this->request->hasQuery('thumb')) {
                    $url .= '&thumb=' . $this->request->getQuery('thumb');
                }

                $data['images'][] = [
                    'thumb' => '',
                    'name' => implode(' ', $name),
                    'type' => 'directory',
                    'path' => substr($image, strlen($this->image->getDirectory())),
                    'href' => $this->url->link('filemanager', 'token=' . $this->session->get('token') . '&directory=' . urlencode(substr($image, strlen($this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data'))) . $url, true)
                ];
            } elseif (is_file($image)) {
                $data['images'][] = [
                    'thumb' => $this->model('tool/image')->resize(substr($image, strlen($this->image->getDirectory())), 100, 100),
                    'name' => implode(' ', $name),
                    'type' => 'image',
                    'path' => substr($image, strlen($this->image->getDirectory())),
                    'href' => $this->url->base('img' . substr($image, strlen($this->image->getDirectory())))
                ];
            }
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_no_results'] = $this->language->get('text_no_results');
        $data['text_confirm'] = $this->language->get('text_confirm');

        $data['entry_search'] = $this->language->get('entry_search');
        $data['entry_folder'] = $this->language->get('entry_folder');

        $data['token'] = $this->session->get('token');

        if ($this->request->hasQuery('directory')) {
            $data['directory'] = urlencode($this->request->getQuery('directory'));
        } else {
            $data['directory'] = '';
        }

        if ($this->request->hasQuery('filter_name')) {
            $data['filter_name'] = $this->request->getQuery('filter_name');
        } else {
            $data['filter_name'] = '';
        }

        if ($this->request->hasQuery('target')) {
            $data['target'] = $this->request->getQuery('target');
        } else {
            $data['target'] = '';
        }

        if ($this->request->hasQuery('thumb')) {
            $data['thumb'] = $this->request->getQuery('thumb');
        } else {
            $data['thumb'] = '';
        }

        // Parent
        $url = '';

        if ($this->request->hasQuery('directory')) {
            $pos = strrpos($this->request->getQuery('directory'), DIRECTORY_SEPARATOR);

            if ($pos) {
                $url .= '&directory=' . urlencode(substr($this->request->getQuery('directory'), 0, $pos));
            }
        }

        if ($this->request->hasQuery('target')) {
            $url .= '&target=' . $this->request->getQuery('target');
        }

        if ($this->request->hasQuery('thumb')) {
            $url .= '&thumb=' . $this->request->getQuery('thumb');
        }

        $data['parent'] = $this->url->link('filemanager', 'token=' . $this->session->get('token') . $url);

        // Refresh
        $url = '';

        if ($this->request->hasQuery('directory')) {
            $url .= '&directory=' . urlencode($this->request->getQuery('directory'));
        }

        if ($this->request->hasQuery('target')) {
            $url .= '&target=' . $this->request->getQuery('target');
        }

        if ($this->request->hasQuery('thumb')) {
            $url .= '&thumb=' . $this->request->getQuery('thumb');
        }

        $data['refresh'] = $this->url->link('filemanager', 'token=' . $this->session->get('token') . $url);

        $url = '';

        if ($this->request->hasQuery('directory')) {
            $url .= '&directory=' . urlencode(html_entity_decode($this->request->getQuery('directory'), ENT_QUOTES, 'UTF-8'));
        }

        if ($this->request->hasQuery('target')) {
            $url .= '&target=' . $this->request->getQuery('target');
        }

        if ($this->request->hasQuery('thumb')) {
            $url .= '&thumb=' . $this->request->getQuery('thumb');
        }

        $pagination = new Pagination();
        $pagination->total = $image_total;
        $pagination->page = $page;
        $pagination->limit = 16;
        $pagination->url = $this->url->link('filemanager', 'token=' . $this->session->get('token') . $url . '&page={page}');

        $data['pagination'] = $pagination->render();


        $this->response->setContent($this->view('common/filemanager', $data));
    }

    public function uploadAction()
    {
        $this->language->load('common/filemanager');

        $json = [];

        if (!$this->user->hasPermission('modify', 'filemanager')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if ($this->request->hasQuery('directory')) {
            $directory = $this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $this->request->getQuery('directory');
        } else {
            $directory = $this->image->getDirectory() . DIRECTORY_SEPARATOR .  'data';
        }

        if (!is_dir($directory)) {
            $json['error'] = $this->language->get('error_directory');
        }

        if (!$json) {
            $files = [];

            if ($this->request->hasFiles('file')) {
                $files = $this->request->getFiles('file');
            }

            foreach ($files as $file) {
                if (is_file($file['tmp_name'])) {
                    $filename = basename(html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8'));

                    $length = strlen($filename);

                    if ($length < 3 || $length > 255) {
                        $json['error'] = $this->language->get('error_filename');
                    }

                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        $json['error'] = $this->language->get('error_upload_' . $file['error']);
                    }
                } else {
                    $json['error'] = $this->language->get('error_upload');
                }

                if (!$json) {
                    move_uploaded_file($file['tmp_name'], $directory . DIRECTORY_SEPARATOR . $filename);
                }
            }
        }

        if (!$json) {
            $json['success'] = $this->language->get('text_uploaded');
        }

        $this->response->setContent(json_encode($json));
    }

    public function folderAction()
    {
        $this->language->load('common/filemanager');

        $json = [];

        if (!$this->user->hasPermission('modify', 'filemanager')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if ($this->request->hasQuery('directory')) {
            $directory = $this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $this->request->getQuery('directory');
        } else {
            $directory = $this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data';
        }

        if (!is_dir($directory)) {
            $json['error'] = $this->language->get('error_directory');
        }

        if ($this->request->isPost()) {
            $folder = basename(html_entity_decode($this->request->getPost('folder'), ENT_QUOTES, 'UTF-8'));

            $length = strlen($folder);

            if ($length < 3 || $length > 128) {
                $json['error'] = $this->language->get('error_folder');
            }

            $dir = $directory . DIRECTORY_SEPARATOR . $folder;

            if (is_dir($dir)) {
                $json['error'] = $this->language->get('error_exists');
            }
        }

        if (!isset($json['error'])) {
            mkdir($dir, 0777);
            chmod($dir, 0777);

            @touch($dir . DIRECTORY_SEPARATOR . 'index.html');

            $json['success'] = $this->language->get('text_directory');
        }

        $this->response->setContent(json_encode($json));
    }

    public function deleteAction()
    {
        $this->language->load('common/filemanager');

        $json = [];

        if (!$this->user->hasPermission('modify', 'filemanager')) {
            $json['error'] = $this->language->get('error_permission');
        }

        if ($this->request->hasPost('path')) {
            $paths = $this->request->getPost('path');
        } else {
            $paths = [];
        }

        foreach ($paths as $path) {
            if ($path === $this->image->getDirectory() . DIRECTORY_SEPARATOR . 'data') {
                $json['error'] = $this->language->get('error_delete');

                break;
            }
        }

        if (!$json) {
            foreach ($paths as $path) {
                $path = $this->image->getDirectory() . $path;

                if (is_file($path)) {
                    unlink($path);
                } elseif (is_dir($path)) {
                    $files = [];

                    $path = [$path . '*'];

                    while (count($path) !== 0) {
                        $next = array_shift($path);

                        foreach (glob($next) as $file) {
                            if (is_dir($file)) {
                                $path[] = $file . DIRECTORY_SEPARATOR . '*';
                            }
                            $files[] = $file;
                        }
                    }

                    rsort($files);

                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        } elseif (is_dir($file)) {
                            rmdir($file);
                        }
                    }
                }
            }

            $json['success'] = $this->language->get('text_delete');
        }

        $this->response->setContent(json_encode($json));
    }
}
