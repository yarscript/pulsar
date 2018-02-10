<?php

namespace Application\Common;

use Ions\Mvc\Controller;

class LanguageController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/language');

        $data['action'] = $this->url->link('language/language');
        $data['code'] = $this->session->get('language');
        $data['languages'] = [];

        $results = $this->model('localisation/language')->getLanguages();

        foreach ($results as $result) {
            if ($result['status']) {
                $data['languages'][] = [
                    'name' => $result['name'],
                    'code' => $result['code']
                ];
            }
        }

        $data['redirect'] = $this->url->link('home');

        return $this->view('common/language', $data);
    }

    public function languageAction()
    {
        if ($this->request->hasPost('code')) {
            $this->session->set('language', $this->request->getPost('code'));
        }

        if ($this->request->hasPost('redirect')) {
            $this->response->redirect($this->request->getPost('redirect'));
        } else {
            $this->response->redirect($this->url->link('home'));
        }
    }
}
