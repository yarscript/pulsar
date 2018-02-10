<?php

namespace Application\Extension\Module;

use Ions\Mvc\Controller;

class HtmlController extends Controller
{
    public function processAction($setting)
    {
        if (isset($setting['description'][$this->config->get('config_language_id')])) {
            $data['heading_title'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
            $data['html'] = html_entity_decode($setting['description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');

            return $this->view('extension/module/html', $data);
        }
    }
}
