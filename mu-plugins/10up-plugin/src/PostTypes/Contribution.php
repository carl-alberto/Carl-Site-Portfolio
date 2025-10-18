<?php
/**
 * Contribution Post Type
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\PostTypes;

use TenupFramework\PostTypes\AbstractPostType;

/**
 * Registers the "Contribution" post type.
 */
class Contribution extends AbstractPostType {
	/**
	 * Get the post type name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'contribution';
	}

	/**
	 * Get the singular post type label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return esc_html__( 'Contributions', 'tenup-plugin' );
	}

	/**
	 * Get the plural post type label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return esc_html__( 'Community Contributions', 'tenup-plugin' );
	}

	/**
	 * Get the menu icon for the post type.
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return 'dashicons-megaphone';
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
			'contribution-type',
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
			'thumbnail',
			'revisions',
			'custom-fields',
		];
	}

	/**
	 * Register the Community Contribution post type with block editor support.
	 */
	public function register(): bool {
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

		return true;
	}

	/**
	 * Register custom meta fields for Community Contribution post type.
	 */
	public function register_meta_fields(): bool {
		register_post_meta(
			'contribution',
			'event_date',
			[
				'type'         => 'string',
				'description'  => 'Event date',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		register_post_meta(
			'contribution',
			'role',
			[
				'type'         => 'string',
				'description'  => 'Role',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		register_post_meta(
			'contribution',
			'url',
			[
				'type'         => 'string',
				'description'  => 'URL',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		register_post_meta(
			'contribution',
			'slides_url',
			[
				'type'         => 'string',
				'description'  => 'Slides URL',
				'single'       => true,
				'show_in_rest' => true,
			]
		);
		return true;
	}
}
