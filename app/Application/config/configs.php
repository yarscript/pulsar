<?php

return [
    'view' => [
        'template' => 'php',
        'theme' => 'default',
        'directory' => __DIR__ . '/../view/theme',
        'extension' => '.tpl',
    ],
    'language' => [
        'language' => 'en-gb',
        'directory' => __DIR__ . '/../language',
    ],
    'url' => [
        'path' => ''
    ],
    'router' => include 'routes.php',
];
