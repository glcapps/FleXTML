<?php

spl_autoload_register(function ($class) {
    $prefix = 'Flextml\\';
    $base_dir = __DIR__ . '/../php/Flextml/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Flextml\Api\Rest\Endpoint;

Endpoint::handle();
