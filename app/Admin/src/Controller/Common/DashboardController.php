<?php

namespace Admin\Common;

use Ions\Mvc\Controller;

class DashboardController extends Controller
{
    public function indexAction()
    {
        $data = [];

        $this->language->load('common/dashboard');
        $this->document->setTitle($this->language->get('heading_title'));

        // Dashboard Extensions
        $dashboards = [];

        // Get a list of installed modules
        $extensions = $this->model('setting/extension')->getInstalled('dashboard');

        // Add all the modules which have multiple settings for each module
        foreach ($extensions as $code) {
            if ($this->config->get('dashboard_' . $code . '_status') && $this->user->hasPermission('access', 'extension/dashboard/' . $code)) {
                $output = $this->controller('extension/dashboard/' . $code , [], 'dashboard');

                if ($output) {
                    $dashboards[] = [
                        'code'       => $code,
                        'width'      => $this->config->get('dashboard_' . $code . '_width'),
                        'sort_order' => $this->config->get('dashboard_' . $code . '_sort_order'),
                        'output'     => $output
                    ];
                }
            }
        }

        $sort_order = [];

        foreach ($dashboards as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $dashboards);

        $data['dashboards'] = $dashboards;

        // Layout
        $data['header'] = $this->controller('header');
        $data['footer'] = $this->controller('footer');
        // END Layout

        $this->response->setContent($this->view('common/dashboard', $data));
    }
}
