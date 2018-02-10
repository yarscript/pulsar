<?php

namespace Admin\Common;

use Ions\Mvc\Controller;

class FooterController extends Controller
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('common/footer');

        $data['text_version'] = sprintf($this->language->get('text_version'), \Admin\App::VERSION);

        $data['scripts'] = $this->document->getScripts('footer');

        return $this->view('common/footer', $data);
    }
}
