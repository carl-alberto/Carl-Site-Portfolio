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
			'portfolio-type',
			'portfolio-tech',
			'portfolio-client',
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


	/**
	 * Run any code after the post type has been registered.
	 *
	 * @return void
	 */
	public function after_register() {
		// Register any hooks/filters you need.
	}

	/**
	 * Register the Portfolio post type with block editor support.
	 */
	public function register() {
		register_post_type(
			$this->get_name(),
			[
				'label'        => $this->get_plural_label(),
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => $this->get_menu_icon(),
				'supports'     => $this->get_supported_features(),
				'taxonomies'   => $this->get_supported_taxonomies(),
			]
		);
	}

	/**
	 * Register custom meta fields for Portfolio post type.
	 */
	public function register_meta_fields() {
		register_post_meta(
			'portfolio',
			'company',
			[
				'type'         => 'string',
				'description'  => 'Related company',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		register_post_meta(
			'portfolio',
			'duration',
			[
				'type'         => 'string',
				'description'  => 'Project duration',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		register_post_meta(
			'portfolio',
			'position',
			[
				'type'         => 'string',
				'description'  => 'Role or position',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
	}
}
