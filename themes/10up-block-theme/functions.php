<?php
/**
 * Theme constants and setup functions
 *
 * @package TenupBlockTheme
 */

// Useful global constants.
define( 'TENUP_BLOCK_THEME_VERSION', '1.0.0' );
define( 'TENUP_BLOCK_THEME_TEMPLATE_URL', get_template_directory_uri() );
define( 'TENUP_BLOCK_THEME_PATH', get_template_directory() . '/' );
define( 'TENUP_BLOCK_THEME_DIST_PATH', TENUP_BLOCK_THEME_PATH . 'dist/' );
define( 'TENUP_BLOCK_THEME_DIST_URL', TENUP_BLOCK_THEME_TEMPLATE_URL . '/dist/' );
define( 'TENUP_BLOCK_THEME_INC', TENUP_BLOCK_THEME_PATH . 'src/' );
define( 'TENUP_BLOCK_THEME_BLOCK_DIST_DIR', TENUP_BLOCK_THEME_DIST_PATH . '/blocks/' );

// Require Composer autoloader if it exists.
if ( ! file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	throw new Exception( 'Please run `composer install` in your theme directory.' );
}

$is_local_env = in_array( wp_get_environment_type(), [ 'local', 'development' ], true );
$is_local_url = strpos( home_url(), '.test' ) || strpos( home_url(), '.local' );
$is_local     = $is_local_env || $is_local_url;

if ( $is_local && file_exists( __DIR__ . '/dist/fast-refresh.php' ) ) {
	require_once __DIR__ . '/dist/fast-refresh.php';

	if ( function_exists( 'TenUpToolkit\set_dist_url_path' ) ) {
		TenUpToolkit\set_dist_url_path( basename( __DIR__ ), TENUP_BLOCK_THEME_DIST_URL, TENUP_BLOCK_THEME_DIST_PATH );
	}
}

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/template-tags.php';

$theme_core = new \TenupBlockTheme\ThemeCore();
$theme_core->setup();


function render_portfolio_block($attributes) {
	$args = [
		'post_type' => 'portfolio',
		'posts_per_page' => $attributes['postsToShow'] ?? 3,
	];
	$query = new WP_Query($args);
	if (!$query->have_posts()) {
		return '<p>No portfolio items found.</p>';
	}
	$output = '<div class="portfolio-block">';
	while ($query->have_posts()) {
		$query->the_post();
		$image = get_the_post_thumbnail(get_the_ID(), 'medium');
		$title = get_the_title();
		$desc = get_the_excerpt();
		$output .= '<div class="portfolio-item">';
		$output .= $image ? '<div class="portfolio-image">' . $image . '</div>' : '';
		$output .= '<h3 class="portfolio-title">' . esc_html($title) . '</h3>';
		$output .= '<div class="portfolio-desc">' . esc_html($desc) . '</div>';
		$output .= '</div>';
	}
	wp_reset_postdata();
	$output .= '</div>';
	return $output;
}

// Enqueue block editor assets for Portfolio Block
add_action('enqueue_block_editor_assets', function() {
	wp_enqueue_script(
		'10up-portfolio-block',
		get_template_directory_uri() . '/blocks/portfolio-block/index.js',
		array('wp-blocks', 'wp-element', 'wp-i18n', 'wp-components', 'wp-editor'),
		TENUP_BLOCK_THEME_VERSION,
		true
	);
	wp_enqueue_style(
		'10up-portfolio-block-editor',
		get_template_directory_uri() . '/blocks/portfolio-block/editor.css',
		array(),
		TENUP_BLOCK_THEME_VERSION
	);
});

// Enqueue frontend styles for Portfolio Block
add_action('wp_enqueue_scripts', function() {
	wp_enqueue_style(
		'10up-portfolio-block-style',
		get_template_directory_uri() . '/blocks/portfolio-block/style.css',
		array(),
		TENUP_BLOCK_THEME_VERSION
	);
});
