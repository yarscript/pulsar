<?php
/**
 * Ions Framework (http://ionscript.com/)
 *
 * @link      http://github.com/ionscript/ionscript for the canonical source repository
 * @copyright Copyright (c) 2017 Ions Technologies UA Inc. (http://www.ionscript.com)
 * @license   http://github.com/ionscript/ionscript/LICENSE.md GPL-3.0+ License
 * @author    Serge Shportko (ionscript.inc@gmail.com)
 */

namespace Application\Common;

use Ions\Mvc\Controller;


class ContentBottomController extends Controller
{
    public function indexAction()
    {
        if ($this->request->hasQuery('route')) {
            $route = (string)$this->request->getQuery('route');
        } else {
            $route = '/';
        }

        $layout_id = 0;

        if (!$layout_id) {
            $layout_id = $this->model('design/layout')->getLayout($route);
        }

        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }

        $data['modules'] = [];

        $modules = $this->model('design/layout')->getLayoutModules($layout_id, 'content_bottom');

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

        return $this->view('common/content_bottom', $data);
    }
}
