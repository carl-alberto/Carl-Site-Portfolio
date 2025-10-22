<?php
/**
 * Portfolio Post Type
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\PostTypes;

use TenupFramework\PostTypes\AbstractPostType;

/**
 * Portfolio post type.
 */
class Portfolio extends AbstractPostType {

	/**
	 * Get the post type name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'portfolio';
	}

	/**
	 * Get the singular post type label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return esc_html__( 'Portfolio', 'tenup-plugin' );
	}

	/**
	 * Get the plural post type label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return esc_html__( 'Portfolios', 'tenup-plugin' );
	}

	/**
	 * Get the menu icon for the post type.
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return 'dashicons-portfolio';
	}

	/**
	 * Can the class be registered?
	 *
	 * @return bool
	 */
	public function can_register() {
		return true;
	}

	/**
	 * Returns the default supported taxonomies. Add your custom taxonomies here.
	 *
	 * @return array<string>
	 */
	public function get_supported_taxonomies() {
		return [
			'technology',
			'company',
		];
	}

	/**
	 * Returns the default supported features for the post type.
	 *
	 * @return array<string>
	 */
	public function get_supported_features() {
		return [
			'title',
			'editor',
			'excerpt',
			'author',
			'thumbnail',
		];
	}

	public function get_menu_postion(): ?int {
		return 5;
	}

	public function get_options(): array {
		$options                  = parent::get_options();
		$options['rewrite']       = [
			'slug'       => 'portfolio',
			'with_front' => true,
		];
		$options['rest_base']     = 'portfolio';
		$options['template']      = $this->get_custom_blocks();
		$options['public']        = true;
		$options['has_archive']   = true;
		return $options;
	}
}
