<?php

namespace Application\Listener;

use Ions\Event\EventManagerInterface;
use Ions\Event\ListenerInterface;
use Ions\Event\ListenerTrait;
use Ions\Mvc\Action;
use Ions\Session\Handler\Db;

class BootstrapListener implements ListenerInterface
{
    use ListenerTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('bootstrap', [$this, 'onBootstrap']);
    }

    public function onBootstrap(Action $event)
    {
        $services = $event->getTarget()->getServiceManager();
        $db = $services->get('db');
        $config = $services->get('config');
        $request = $services->get('request');

        // Settings
        $query = $db->query('SELECT * FROM `setting`');

        foreach ((array)$query->rows as $setting) {
            if (!$setting['serialized']) {
                $config->offsetSet($setting['key'], $setting['value']);
            } else {
                $config->offsetSet($setting['key'], json_decode($setting['value'], true));
            }
        }

        // Session
        $session = $services->get('session');
        $session->registerSaveHandler(new Db($db));
        $session->start();

        // Theme
        $config->offsetSet('template_cache', $config->get('developer_theme'));

        // Language
        $language = $services->get('language');
        $code = '';

        $query = $db->query('SELECT * FROM `language` ORDER BY sort_order, name');
        $languages = $query->rows;

        if ($session->has('language')) {
            $code = $session->get('language');
        }

        $lng = [];

        foreach ($languages as $value) {
            $lng[$value['code']] = $value;
        }

        $languages = $lng;

        if (!array_key_exists($code, $languages) && $request->hasCookie('language')) {
            $code = $request->getCookie('language');
        }

        // Language Detection
        if (!array_key_exists($code, $languages) && $request->hasServer('HTTP_ACCEPT_LANGUAGE')) {
            $detect = '';
            $browser_languages = explode(',', $request->getServer('HTTP_ACCEPT_LANGUAGE'));

            // Try using local to detect the language
            foreach ($browser_languages as $browser_language) {
                foreach ($languages as $key => $value) {
                    if ($value['status']) {
                        $locale = explode(',', $value['locale']);

                        if (in_array($browser_language, $locale, true)) {
                            $detect = $key;
                            break 2;
                        }
                    }
                }
            }

            if (!$detect) {
                // Try using language folder to detect the language
                foreach ($browser_languages as $browser_language) {
                    if (array_key_exists(strtolower($browser_language), $languages)) {
                        $detect = strtolower($browser_language);

                        break;
                    }
                }
            }

            $code = $detect ? $detect : '';
        }

        if (!array_key_exists($code, $languages)) {
            $code = $config->get('config_language');
        }

        if (!$session->has('language') || $session->get('language') !== $code) {
            $session->set('language', $code);
        }

        if (!$request->hasCookie('language') || $request->getCookie('language') !== $code) {
            setcookie('language', $code, time() + 60 * 60 * 24 * 30, '/', $request->getServer('HTTP_HOST')); // TODO: fix time to datetime
        }

        $language->setLanguage($code);
        $language->setDirectory('app/' . $services->get('app')->getName() . '/language');
        $language->load($code);

        $config->offsetSet('config_language_id', $languages[$code]['id']);

        // Compression
        $response = $services->get('response');
        $response->setCompression($config->get('config_compression'));
    }
}
