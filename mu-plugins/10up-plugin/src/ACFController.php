<?php
/**
 * ACF Set-up.
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin;

/**
 * Controller responsible for ACF related functionality.
 */
class ACFController {

	/**
	 * Boot the controller.
	 *
	 * @return void
	 */
	public function set_up() {

		add_filter( 'acf/settings/save_json', [ $this, 'save_point' ] );
		add_filter( 'acf/settings/load_json', [ $this, 'load_point' ] );

		// add_filter( 'acf/settings/enable_post_types', '__return_false' );

		// add_action( 'acf/render_field_settings/type=text', [ $this, 'add_readonly_and_disabled_options_to_field' ] );

	}

	/**
	 * Path to the acf-folder save point.
	 *
	 * @param $path
	 *
	 * @return string
	 */
	public function save_point( string $path ): string {
		return $this->config->get_app_directory() . '/config/acf-json';
	}

	/**
	 * Load acf-folder JSON on this path.
	 *
	 * @param $paths
	 *
	 * @return array
	 */
	public function load_point( $paths ): array {
		unset( $paths[0] );
		$paths[] = $this->config->get_app_directory() . '/config/acf-json';
		return $paths;
	}
}
