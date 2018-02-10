<?php

namespace Admin;

final class App
{
    const VERSION = '1.0.0a';

    public function getConfig()
    {
        return include __DIR__ . '/../config/config.php';
    }

    public function getName()
    {
        return __NAMESPACE__;
    }
}
