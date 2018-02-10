<?php

namespace Application\Common;

use Ions\Mvc\Controller;


class FooterController extends Controller
{
    public function indexAction()
    {
        $this->language->load('common/footer');

        // Whos Online
        if ($this->config->get('config_user_online')) {
            if ($this->request->hasServer('REMOTE_ADDR')) {
                $ip = $this->request->getServer('REMOTE_ADDR');
            } else {
                $ip = '';
            }

            if ($this->request->hasServer('HTTP_HOST') && $this->request->hasServer('REQUEST_URI')) {
                $url = ($this->request->hasServer('HTTPS') ? 'https://' : 'http://') . $this->request->getServer('HTTP_HOST') . $this->request->getServer('REQUEST_URI');
            } else {
                $url = '';
            }

            if ($this->request->hasServer('HTTP_REFERER')) {
                $referer = $this->request->getServer('HTTP_REFERER');
            } else {
                $referer = '';
            }

            $this->model('tool/online')->addOnline($ip, $this->user->getId(), $url, $referer);
        }

        $data['text_copyright'] = sprintf($this->language->get('text_copyright'), $this->config->get('config_name'));
        $data['scripts'] = $this->document->getScripts('footer');

        $data['pages'] = [];

        $options = [
            'bottom' => true
        ];

        $pages = $this->model('content/page')->getPages($options);

        // Company
        $company = [
            [
                'name' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home'),
                'children' => [],
                'active' => 'active',
            ]
        ];

        foreach ($pages as $page) {
            $company[] = [
                'name' => $page['name'],
                'href' => $this->url->link('content/page', 'id=' . $page['id']),
                'children' => [],
                'active' => '',
            ];
        }

        $data['pages'][] = [
            'name' => $this->language->get('text_company'),
            'href' => '',
            'children' => $company,
            'active' => '',
        ];

        return $this->view('common/footer', $data);
    }
}
