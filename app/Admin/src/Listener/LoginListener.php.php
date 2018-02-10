<?php

namespace Admin\Listener;

use Ions\Event\EventManagerInterface;
use Ions\Event\ListenerInterface;
use Ions\Event\ListenerTrait;
use Ions\Mvc\Action;
use Ions\Route\RouteMatch;

class LoginListener implements ListenerInterface
{
    use ListenerTrait;

    public function attach(EventManagerInterface $events, $priority = -90)
    {
        $this->listeners[] = $events->attach('route', [$this, 'onRoute']);
    }

    public function onRoute(Action $event)
    {
        $services = $event->getTarget()->getServiceManager();
        $request = $services->get('request');
        $matches = $event->getRouteMatch();
        $session = $services->get('session');

        if (!$matches instanceof RouteMatch || $matches->getRouteName() === 'error-not-found') {
            return null;
        }

        if ($session->has('token') && $request->hasQuery('token') && $services->get('user')->isLogged() && ($request->getQuery('token') === $session->get('token'))) {
            return null;
        }

        $matches->setRouteName('login');
        $matches->setParam('controller', 'login');
        $matches->setParam('action', 'index');
        return $matches;
    }
}
