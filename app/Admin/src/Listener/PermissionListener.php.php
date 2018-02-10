<?php

namespace Admin\Listener;

use Ions\Route\RouteMatch;
use Ions\Event\EventManagerInterface;
use Ions\Event\ListenerInterface;
use Ions\Event\ListenerTrait;
use Ions\Mvc\Action;

class PermissionListener implements ListenerInterface
{
    use ListenerTrait;

    public function attach(EventManagerInterface $events, $priority = -90)
    {
        $this->listeners[] = $events->attach('route', [$this, 'onRoute'], $priority);
    }

    public function onRoute(Action $event)
    {
        $services = $event->getTarget()->getServiceManager();
        $matches = $event->getRouteMatch();

        if (!$matches instanceof RouteMatch) {
            return null;
        }

        $route = $matches->getRouteName();
        $ignore = $matches->getParam('ignore', false);
        $user = $services->get('user');

        if ($ignore || $route === 'login' || $user->hasPermission('access', $route)) {
            return null;
        }


        $matches->setRouteName('error-permission');
        $matches->setParam('controller', 'error-permission');
        $matches->setParam('action', 'index');

        return $matches;
    }
}
