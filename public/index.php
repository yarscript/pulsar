<?php

use Ions\Mvc\Application as App;

chdir(dirname(__DIR__));

include __DIR__ . '/../system/vendor/autoload.php';

if (!class_exists(App::class)) {
    throw new RuntimeException(
        "Unable to load application.\n"
        . "- Run `composer install` or`composer dump-autoload`.\n"
    );
}

$appConfig = require __DIR__ . '/../system/config/config.php';

App::init($appConfig)->run();
