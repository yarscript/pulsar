<?php

return [
    'request' => \Ions\Http\Server\Request::class,
    'response' => \Ions\Http\Server\Response::class,
    'cache' => \Ions\Cache\Cache::class,
    'config' => \Ions\Config\Config::class,
    'session' => \Ions\Session\Session::class,
    'router' => \Ions\Route\Router::class,
    'language' => \Ions\Mvc\Service\Language::class,
    'document' => \Ions\Mvc\Service\Document::class,
    'view' => \Ions\Mvc\View::class,
    'url' => \Ions\Mvc\Service\Url::class,
    'db' => \Ions\Db\Db::class,
    'log' => \Ions\Log\Log::class,
    'image' => \Ions\Mvc\Service\Image::class,
    'user' => \Ions\Mvc\Service\User::class,
    'mail' => \Ions\Mail\Message::class,
    'smtp' => \Ions\Mail\Protocol\Smtp::class
];
