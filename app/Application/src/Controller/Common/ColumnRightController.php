<?php

namespace Application\Common;

use Ions\Mvc\Controller;


class ColumnRightController extends Controller
{
    public function indexAction()
    {
        if ($this->request->hasQuery('route')) {
            $route = (string)$this->request->getQuery('route');
        } else {
            $route = 'common/home';
        }

        $layout_id = 0;

        if (!$layout_id) {
            $layout_id = $this->model('design/layout')->getLayout($route);
        }

        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }

        $data['modules'] = [];

        $modules = $this->model('design/layout')->getLayoutModules($layout_id, 'column_right');

        foreach ($modules as $module) {
            $part = explode('.', $module['code']);

            if (isset($part[0]) && $this->config->get('module_' . $part[0] . '_status')) {
                $module_data = $this->controller('extension/module/' . $part[0]);

                if ($module_data) {
                    $data['modules'][] = $module_data;
                }
            }

            if (isset($part[1])) {
                $setting_info = $this->model('setting/module')->getModule($part[1]);

                if ($setting_info && $setting_info['status']) {
                    $output = $this->controller('extension/module/' . $part[0], $setting_info, 'process');

                    if ($output) {
                        $data['modules'][] = $output;
                    }
                }
            }
        }

        return $this->view('common/column_right', $data);
    }
}
