<?php
/**
 * PluginCore module.
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin;

use TenupFramework\ModuleInitialization;
use TenUpPlugin\PostTypes\Portfolio;
use TenUpPlugin\PostTypes\Company;
use TenUpPlugin\PostTypes\Learning;
use TenUpPlugin\PostTypes\Contribution;
use TenUpPlugin\PostTypes\Demo;

/**
 * PluginCore module.
 */
class PluginCore {

	/**
	 * Default setup routine.
	 *
	 * @return void
	 */
	public function setup() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'init', [ $this, 'init' ], apply_filters( 'tenup_plugin_init_priority', 8 ) );

		add_filter( 'acf/settings/save_json', [ $this, 'save_point' ] );
		add_filter( 'acf/settings/load_json', [ $this, 'load_point' ] );

		// Register Portfolio post type.
		add_action(
			'init',
			function () {
				$portfolio = new Portfolio();
				if ( $portfolio->can_register() ) {
					$portfolio->register();
				}
			}
		);

		// Register Company post type.
		add_action(
			'init',
			function () {
				$company = new Company();
				if ( $company->can_register() ) {
					$company->register();
				}
			}
		);

		// Register Learning post type.
		add_action(
			'init',
			function () {
				$learning = new Learning();
				if ( $learning->can_register() ) {
					$learning->register();
				}
			}
		);

		// Register Community Contribution post type.
		add_action(
			'init',
			function () {
				$contribution = new Contribution();
				if ( $contribution->can_register() ) {
					$contribution->register();
				}
			}
		);

		do_action( 'tenup_plugin_loaded' );
	}

	/**
	 * Registers the default textdomain.
	 *
	 * @return void
	 */
	public function i18n() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'tenup-plugin' );

		load_textdomain( 'tenup-plugin', WP_LANG_DIR . '/tenup-plugin/tenup-plugin-' . $locale . '.mo' );
		load_plugin_textdomain( 'tenup-plugin', false, plugin_basename( TENUP_PLUGIN_PATH ) . '/languages/' );
	}

	/**
	 * Initializes the plugin and fires an action other plugins can hook into.
	 *
	 * @return void
	 */
	public function init() {
		do_action( 'tenup_plugin_before_init' );

		if ( ! class_exists( '\TenupFramework\ModuleInitialization' ) ) {
			add_action(
				'admin_notices',
				function () {
					$class = 'notice notice-error';

					printf(
						'<div class="%1$s"><p>%2$s</p></div>',
						esc_attr( $class ),
						wp_kses_post(
							__(
								'Please ensure the <a href="https://github.com/10up/wp-framework"><code>10up/wp-framework</code></a> composer package is installed.',
								'tenup-plugin'
							)
						)
					);
				}
			);

			return;
		}

		ModuleInitialization::instance()->init_classes( TENUP_PLUGIN_INC );

		do_action( 'tenup_plugin_init' );
	}

	/**
	 * Activate the plugin.
	 *
	 * @return void
	 */
	public function activate() {
		// First load the init scripts in case any rewrite functionality is being loaded.
		$this->init();
		flush_rewrite_rules();
	}

	/**
	 * Deactivate the plugin.
	 *
	 * Uninstall routines should be in uninstall.php.
	 *
	 * @return void
	 */
	public function deactivate() {
		// Intentionally left blank.
	}

	/**
	 * Get an initialized class by its full class name, including namespace.
	 *
	 * @param string $class_name The class name including the namespace.
	 *
	 * @return false|\TenupFramework\ModuleInterface
	 */
	public static function get_module( $class_name ) {
		return ModuleInitialization::get_module( $class_name );
	}

	/**
	 * Path to the acf-folder save point relative to the mu-plugin directory.
	 *
	 * @param string $path Path of the ACF config file.
	 *
	 * @return string
	 */
	public function save_point(): string {
		return TENUP_PLUGIN_INC . 'config/acf-json';
	}

	/**
	 * Load acf-folder JSON on this path.
	 *
	 * @param array $paths Paths of the ACF config files.
	 *
	 * @return array
	 */
	public function load_point( array $paths ): array {
		unset( $paths[0] );
		$paths[] = TENUP_PLUGIN_INC . 'config/acf-json';
		return $paths;
	}

	/**
	 * Adding Gutenberg blocks from templates.
	 *
	 * @param array $block The block to be rendered.
	 * @return void
	 */
	public function acf_block_render_callback( $block ) {

		$slug = str_replace( 'acf/', '', $block['name'] );

		if ( file_exists( get_theme_file_path( "/template-parts/gutenberg/block-{$slug}.php" ) ) ) {
			include get_theme_file_path( "/template-parts/gutenberg/block-{$slug}.php" );
		}
	}
}
