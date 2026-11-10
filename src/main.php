<?php

declare(strict_types=1);

if (PHP_VERSION_ID < 80500) {
    echo 'PHP version must be 8.5.0 or later to run';
    die;
} 

require_once __DIR__ . '/../vendor/autoload.php';

echo 'Running: ' . __FILE__ . PHP_EOL;
