<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Brain\Monkey;

Monkey\setUp();

register_shutdown_function(function () {
    Monkey\tearDown();
});
