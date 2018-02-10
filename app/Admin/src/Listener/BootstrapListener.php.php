<?php

namespace Admin\Listener;

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

        // Settings
        $query = $db->query('SELECT * FROM `setting`');

        foreach ($query->rows as $setting) {
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

        // Language
        $query = $db->query('SELECT * FROM `language` WHERE code = ' . $db->escape($config->get('config_admin_language')));

        if ($query->count) {
            $config->offsetSet('config_language_id', $query->row['id']);
        }

        $language = $services->get('language');
        $language->setLanguage($config->get('config_admin_language'));
        $language->setDirectory('app/' .$services->get('app')->getName() . '/language');
        $language->load();


        // Compression
        $response = $services->get('response');
        $response->setCompression($config->get('config_compression'));
    }
}
