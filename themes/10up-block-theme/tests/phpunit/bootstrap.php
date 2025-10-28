<?php
$themeRoot = dirname(__DIR__, 2);
require_once $themeRoot . '/vendor/autoload.php';

require_once __DIR__ . '/test-featured-cover-block.php';

// 🔥 COMPLETE WP MOCKS - ALL FUNCTIONS YOUR BLOCK NEEDS
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
        return false; // ✅ YOUR BLOCK EXPECTS NO ERRORS
    }
}

if (!function_exists('get_block_wrapper_attributes')) {
    function get_block_wrapper_attributes($extra_props = []) {
        return 'class="wp-block-tenup-portfolio-header portfolio-block"';
    }
}

// Essential escapes
if (!function_exists('wp_kses_post')) { function wp_kses_post($string) { return $string; } }
if (!function_exists('esc_url')) { function esc_url($url) { return $url; } }
if (!function_exists('esc_html')) { function esc_html($html) { return $html; } }

echo "✅ 100% COMPLETE Portfolio Header Mocks!\n";
