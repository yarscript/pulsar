<?php

namespace Admin\Listener;

use Ions\Event\EventManagerInterface;
use Ions\Event\ListenerInterface;
use Ions\Event\ListenerTrait;
use Ions\Mvc\Action;
use Ions\Log\Handler;

class ErrorListener implements ListenerInterface
{
    use ListenerTrait;

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('bootstrap', [$this, 'onBootstrap'], $priority);
    }

    public function onBootstrap(Action $event)
    {
        $services = $event->getTarget()->getServiceManager();
        $config = $services->get('config');
        $log = $services->get('log');

        if ($config->get('config_error_log')) {
            $log->setFileLogger($config->get('config_error_filename'));
        }

        if ($config->get('config_error_display')) {
            $log->setOutputLogger();
        }

        Handler\Error::register($log);
        Handler\Exception::register($log);
        Handler\Shutdown::register($log);
    }
}
