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

add_theme_support( 'custom-fields' );

/**
 * Enqueue admin script to restrict blocks based on post type.
 *
 * @param string $hook The current admin page.
 * @return void
 */
function enqueue_block_restriction_script( $hook ) {
	// Only load in the post editor screen
	if ( 'post-new.php' !== $hook && 'post.php' !== $hook ) {
		return;
	}

	wp_enqueue_script(
		'restrict-blocks-js',
		TENUP_BLOCK_THEME_DIST_URL . 'js/restrict-blocks.js', // adjust path as needed
		array( 'wp-blocks', 'wp-edit-post', 'wp-data', 'wp-hooks' ),
		'1.0',
		true
	);
}
add_action( 'admin_enqueue_scripts', 'enqueue_block_restriction_script' );


/**
 * Custom allowed blocks filter.
 *
 * @param array  $allowed_blocks allowed blocks array.
 * @param object $block_editor_context Block editor context.
 * @return array<string> Allowed blocks that will be overridden.
 */
function my_custom_allowed_blocks( array $allowed_blocks, object $block_editor_context ): array {

	if ( ! empty( $block_editor_context->post ) && 'portfolio' === $block_editor_context->post->post_type ) {
		return [
			'core/paragraph',
			'core/heading',
			'tenup/portfolio-header',
		];
	}

	// Allow all blocks elsewhere
	return $allowed_blocks;
}
// add_filter( 'allowed_block_types_all', 'my_custom_allowed_blocks', 10, 2 );
