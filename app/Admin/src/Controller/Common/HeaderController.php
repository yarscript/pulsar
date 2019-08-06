<?php

namespace Admin\Common;

use Ions\Mvc\Controller;

class HeaderController extends Controller
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('common/header');

        $data['title'] = $this->document->getTitle('heading_title');

        $this->document->addStyle('vendor/datatables/media/css/dataTables.bootstrap.css');
        $this->document->addStyle('vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css');
        $this->document->addStyle('vendor/jquery.tagsinput/src/jquery.tagsinput.css');
        $this->document->addStyle('vendor/magnific-popup/dist/magnific-popup.css');
        $this->document->addStyle('vendor/sweetalert/dist/sweetalert.css');
        $this->document->addStyle('vendor/select2/dist/css/select2.css');
        $this->document->addStyle('vendor/summernote/dist/summernote.css');
        $this->document->addStyle('vendor/fontawesome/css/font-awesome.css');

        $data['description'] = $this->document->getDescription();
        $data['keywords'] = $this->document->getKeywords();
        $data['links'] = $this->document->getLinks();
        $data['styles'] = $this->document->getStyles();
        $data['scripts'] = $this->document->getScripts();
        $data['lang'] = $this->language->get('code');
        $data['direction'] = $this->language->get('direction');

        $theme = $this->model('system/setting')->getSetting('theme_default');
        $user = $this->model('user/user')->getUser($this->session->get('user_id'));

        $data['page_classes'] = trim($theme['theme_default_class']);

        $data['theme'] = $theme['theme_default_theme'];
        $data['image'] = $user['image'] ? $this->model('tool/image')->resize($user['image'], 25, 25) : 'img/no_avatar.jpg';;
        $data['profile'] = $this->url->link('user/edit', 'token=' . $this->session->get('token') . '&id=' . $user['id']);
        $data['logout'] = $this->url->link('login/logout');
        $data['front'] = $this->url->base('home');

        // Layout
        $data['sidebar'] = $this->controller('sidebar');
        //END Layout

        return $this->view('common/header', $data);
    }
}
