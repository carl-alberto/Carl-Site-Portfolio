<?php
// Try to load Composer autoload from plugin, then wp-content, then project root
$paths = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../../../vendor/autoload.php',
];

$loaded = false;
foreach ($paths as $path) {
    if (file_exists($path)) {
        require $path;
        $loaded = true;
        break;
    }
}

if (! $loaded) {
    fwrite(STDERR, "Unable to find Composer autoload. Run composer install.\n");
    exit(1);
}

// Minimal WP constants to allow register_post_type calls to run safely in isolation
if (! defined('WPINC')) {
    define('WPINC', 'wp-includes');
}

// Autoload plugin classes should be registered by Composer PSR-4 from the plugin's composer.json
