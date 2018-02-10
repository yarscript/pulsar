<?php

namespace Application\Extension\Module;

use Ions\Mvc\Controller;

class SlideshowController extends Controller
{
    public function processAction($setting)
    {
        static $module = 0;

        $this->document->addStyle('vendor/swiper/dist/css/swiper.css');
        $this->document->addStyle('css/swiper.css');
        $this->document->addScript('vendor/swiper/dist/js/swiper.js');

        $data['banners'] = [];

        $results = $this->model('design/banner')->getBanner($setting['banner_id']);

        foreach ($results as $result) {
            if (is_file($this->image->getDirectory() .'/'. $result['image'])) {
                $data['banners'][] = [
                    'title' => $result['title'],
                    'link' => $result['link'],
                    'image' => $this->model('tool/image')->resize($result['image'], $setting['width'], $setting['height'])
                ];
            }
        }

        $data['module'] = $module++;

        return $this->view('extension/module/slideshow', $data);
    }
}
