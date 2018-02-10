<?php

return [
    'error-not-found' => \Admin\Error\NotFoundController::class,
    'error-permission' => \Admin\Error\PermissionController::class,
    'dashboard' => \Admin\Common\DashboardController::class,
    'login' => \Admin\Common\LoginController::class,
    'header' => \Admin\Common\HeaderController::class,
    'footer' => \Admin\Common\FooterController::class,
    'sidebar' => \Admin\Common\SidebarController::class,
    'extension/dashboard/online' => \Admin\Extension\Dashboard\OnlineController::class,
    'extension/module/slideshow' => \Admin\Extension\Module\SlideshowController::class,
    'extension/module/html' => \Admin\Extension\Module\HtmlController::class,
    'extension/theme/default' => \Admin\Extension\Theme\DefaultController::class,
    'extension/analytics/google' => \Admin\Extension\Analytics\GoogleController::class,
];
