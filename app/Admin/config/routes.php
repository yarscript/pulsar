<?php

return [
    '' => [
        'route' => '/admin',
        'defaults' => [
            'controller' => 'dashboard',
            'action' => 'index',
            'ignore' => true
        ],
    ],
    'login' => [
        'route' => '/admin/login',
        'defaults' => [
            'controller' => 'login',
            'action' => 'index',
            'ignore' => true
        ],
    ],
    'dashboard' => [
        'route' => '/admin/dashboard',
        'defaults' => [
            'controller' => \Admin\Common\DashboardController::class,
            'action' => 'index',
            'ignore' => true
        ],
    ],
    'error-not-found' => [
        'route' => 'error-not-found',
        'defaults' => [
            'controller' => \Admin\Error\NotFoundController::class,
            'action' => 'index',
            'ignore' => true
        ],
    ],
    'error-permission' => [
        'route' => '/admin/error/permission',
        'defaults' => [
            'controller' => \Admin\Error\PermissionController::class,
            'action' => 'index',
            'ignore' => true
        ],
    ],
    'filemanager' => [
        'route' => '/admin/filemanager[/:action]',
        'defaults' => [
            'controller' => \Admin\Common\FilemanagerController::class,
            'action' => 'index'
        ],
    ],
    'setting' => [
        'route' => '/admin/setting[/:action]',
        'defaults' => [
            'controller' => \Admin\System\SettingController::class,
            'action' => 'index'
        ],
    ],
    'log' => [
        'route' => '/admin/log[/:action]',
        'defaults' => [
            'controller' => \Admin\System\LogController::class,
            'action' => 'index'
        ],
    ],
    'backup' => [
        'route' => '/admin/backup[/:action]',
        'defaults' => [
            'controller' => \Admin\System\BackupController::class,
            'action' => 'index'
        ],
    ],
    'user' => [
        'route' => '/admin/user[/:action]',
        'defaults' => [
            'controller' => \Admin\User\UserController::class,
            'action' => 'index'
        ],
    ],
    'user-group' => [
        'route' => '/admin/user-group[/:action]',
        'defaults' => [
            'controller' => \Admin\User\GroupController::class,
            'action' => 'index'
        ],
    ],
    'category' => [
        'route' => '/admin/category[/:action]',
        'defaults' => [
            'controller' => \Admin\Content\CategoryController::class,
            'action' => 'index'
        ],
    ],
    'page' => [
        'route' => '/admin/page[/:action]',
        'defaults' => [
            'controller' => \Admin\Content\PageController::class,
            'action' => 'index'
        ],
    ],
    'post' => [
        'route' => '/admin/post[/:action]',
        'defaults' => [
            'controller' => \Admin\Content\PostController::class,
            'action' => 'index'
        ],
    ],
    'layout' => [
        'route' => '/admin/layout[/:action]',
        'defaults' => [
            'controller' => \Admin\Design\LayoutController::class,
            'action' => 'index'
        ],
    ],
    'seo' => [
        'route' => '/admin/seo[/:action]',
        'defaults' => [
            'controller' => \Admin\Design\SeoController::class,
            'action' => 'index'
        ],
    ],
    'language' => [
        'route' => '/admin/language[/:action]',
        'defaults' => [
            'controller' => \Admin\Localisation\LanguageController::class,
            'action' => 'index'
        ],
    ],
    'online' => [
        'route' => '/admin/online[/:action]',
        'defaults' => [
            'controller' => \Admin\Report\OnlineController::class,
            'action' => 'index'
        ],
    ],
    'extension/extension/module' => [
        'route' => '/admin/extension/extension/module[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\ModuleController::class,
            'action' => 'index'
        ],
    ],
    'extension/extension/analytics' => [
        'route' => '/admin/extension/extension/analytics[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\AnalyticsController::class,
            'action' => 'index'
        ],
    ],
    'extension/extension/dashboard' => [
        'route' => '/admin/extension/extension/dashboard[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\DashboardController::class,
            'action' => 'index'
        ],
    ],
    'extension/extension/menu' => [
        'route' => '/admin/extension/extension/menu[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\MenuController::class,
            'action' => 'index'
        ],
    ],
    'extension/extension/report' => [
        'route' => '/admin/extension/extension/report[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\ReportController::class,
            'action' => 'index'
        ],
    ],
    'extension/extension/theme' => [
        'route' => '/admin/extension/extension/theme[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\ThemeController::class,
            'action' => 'index'
        ],
    ],
    'extension/analytics/google' => [
        'route' => '/admin/extension/analytics/google[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Analytics\GoogleController::class,
            'action' => 'index'
        ],
    ],
    'extension/dashboard/online' => [
        'route' => '/admin/extension/dashboard/online[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Dashboard\OnlineController::class,
            'action' => 'index'
        ],
    ],
    'extension/theme/default' => [
        'route' => '/admin/extension/theme/default[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Theme\DefaultController::class,
            'action' => 'index'
        ],
    ],
    'extension/module/banner' => [
        'route' => '/admin/extension/module/banner[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Module\BannerController::class,
            'action' => 'index'
        ],
    ],
    'extension/module/category' => [
        'route' => '/admin/extension/module/category[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Module\CategoryController::class,
            'action' => 'index'
        ],
    ],
    'extension/module/html' => [
        'route' => '/admin/extension/module/html[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Module\HtmlController::class,
            'action' => 'index'
        ],
    ],
    'extension/module/slideshow' => [
        'route' => '/admin/extension/module/slideshow[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Module\SlideshowController::class,
            'action' => 'index'
        ],
    ],
    'extension/menu/menu' => [
        'route' => '/admin/extension/menu/menu[/:action]',
        'defaults' => [
            'controller' => \Admin\Extension\Extension\MenuController::class,
            'action' => 'index'
        ],
    ],
    'banner' => [
        'route' => '/admin/banner[/:action]',
        'defaults' => [
            'controller' => \Admin\Design\BannerController::class,
            'action' => 'index'
        ],
    ]
];
