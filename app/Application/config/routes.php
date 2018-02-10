<?php

return [
    'app' => [
        'route' => '/',
        'defaults' => [
            'controller' => 'home',
            'action' => 'index',
        ],
    ],
    'home' => [
        'route' => '/home',
        'defaults' => [
            'controller' => 'home',
            'action' => 'index',
        ],
    ],
    'error-not-found' => [
        'route' => '/error/not-found',
        'defaults' => [
            'controller' => \Application\Error\NotFoundController::class,
            'action' => 'index',
        ],
    ],
    'extension/analytics/google' => [
        'route' => '/extension/analytics/google',
        'defaults' => [
            'controller' => \Application\Extension\Analytics\GoogleController::class,
            'action' => 'index'
        ],
    ],
    'page' => [
        'route' => '/content/page[/:action]',
        'defaults' => [
            'controller' => \Application\Content\PageController::class,
            'action' => 'index'
        ],
    ],
    'language' => [
        'route' => '/language[/:action]',
        'defaults' => [
            'controller' => \Application\Common\LanguageController::class,
            'action' => 'index'
        ],
    ],
    'category' => [
        'route' => '/category[/:action]',
        'defaults' => [
            'controller' => \Application\Content\CategoryController::class,
            'action' => 'index'
        ],
    ],
    'post' => [
        'route' => '/post[/:action]',
        'defaults' => [
            'controller' => \Application\Content\PostController::class,
            'action' => 'index'
        ],
    ],
];
