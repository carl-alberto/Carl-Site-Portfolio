<?php
// ✅ SHARED WP MOCKS - Works from ANYWHERE!

// Dynamic autoloader loading
$possibleAutoloaders = [
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/vendor/autoload.php',
];

$autoloadPath = null;
foreach ($possibleAutoloaders as $path) {
    if (file_exists($path)) {
        $autoloadPath = $path;
        break;
    }
}

if (!$autoloadPath) {
    die("❌ Autoloader not found! Run: composer install");
}

require_once $autoloadPath;

// 🔥 COMPLETE WP MOCKS (Your portfolio-header needs these)
if (!function_exists('get_post')) {
    function get_post($post_id = null, $output = null, $filter = 'raw') {
        return (object) [
            'ID' => 123,
            'post_title' => 'Test Portfolio',
            'post_content' => '',
            'post_thumbnail_id' => 456,
        ];
    }
}

if (!function_exists('get_the_post_thumbnail_url')) {
    function get_the_post_thumbnail_url($post_id = null, $size = 'large') {
        global $mock_thumbnail_url;
        return $mock_thumbnail_url ?? '';
    }
}

if (!function_exists('get_the_title')) {
    function get_the_title($post_id = null) {
        return 'Test Portfolio';
    }
}

if (!function_exists('get_post_taxonomies')) {
    function get_post_taxonomies($post_id = null) {
        return ['category', 'post_tag'];
    }
}

if (!function_exists('get_the_terms')) {
    function get_the_terms($post_id, $taxonomy) {
        return [
            (object) ['name' => 'Portfolio', 'slug' => 'portfolio'],
            (object) ['name' => 'Design', 'slug' => 'design'],
        ];
    }
}

if (!function_exists('is_wp_error')) {
    function is_wp_error($thing) {
        return false;
    }
}

if (!function_exists('get_block_wrapper_attributes')) {
    function get_block_wrapper_attributes($extra_props = []) {
        return 'class="wp-block-tenup-portfolio-header portfolio-block"';
    }
}

if (!function_exists('esc_url')) { function esc_url($url) { return $url; } }
if (!function_exists('esc_html')) { function esc_html($html) { return $html; } }

echo "✅ SHARED WP Mocks LOADED!\n";
