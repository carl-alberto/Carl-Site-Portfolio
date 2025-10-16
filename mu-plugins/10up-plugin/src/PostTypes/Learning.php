<?php
/**
 * Learning Post Type
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\PostTypes;

use TenupFramework\PostTypes\AbstractPostType;

/**
 * Registers the "Learning" post type.
 */
class Learning extends AbstractPostType {
	/**
	 * Get the post type name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'learning';
	}

	/**
	 * Get the singular post type label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return esc_html__( 'Learning', 'tenup-plugin' );
	}

	/**
	 * Get the plural post type label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return esc_html__( 'Learnings', 'tenup-plugin' );
	}

	/**
	 * Get the menu icon for the post type.
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return 'dashicons-welcome-learn-more';
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
	 * Returns the default supported taxonomies for the post type.
	 *
	 * @return array<string>
	 */
	public function get_supported_taxonomies() {
		return [
			'technology',
			'provider',
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
			'thumbnail',
		];
	}

	/**
	 * Register the Learning post type with block editor support.
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
	 * Register custom meta fields for Learning post type.
	 */
	public function register_meta_fields() {
		register_post_meta(
			'learning',
			'learning_type',
			[
				'type'         => 'string',
				'description'  => 'Type of learning (e.g. course, certificate)',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		register_post_meta(
			'learning',
			'issued_date',
			[
				'type'         => 'string',
				'description'  => 'Issued date',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
	}
}
