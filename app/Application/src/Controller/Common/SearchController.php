<?php

namespace Application\Common;

use Ions\Mvc\Controller;

class SearchController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/search');

        $data['text_search'] = $this->language->get('text_search');

        if ($this->request->hasQuery('search')) {
            $data['search'] = $this->request->getQuery('search');
        } else {
            $data['search'] = '';
        }

        return $this->view('common/search', $data);
    }
}
