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

	/**
	 * Run any code after the post type has been registered.
	 *
	 * @return void
	 */
	public function after_register() {
		// Register 'role' post meta for REST API and block editor support.
		register_post_meta( 'portfolio', 'role', array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'string',
			'auth_callback' => function() {
				return current_user_can( 'edit_posts' );
			},
		) );
	}

	/**
	 * Register the Portfolio post type with block editor support.
	 */
	public function register(): bool {
		register_post_type(
			$this->get_name(),
			[
				'label'                 => $this->get_plural_label(),
				'labels'                => [
					'name'                  => esc_html__( 'Portfolios', 'tenup-plugin' ),
					'singular_name'         => esc_html__( 'Portfolio', 'tenup-plugin' ),
					'add_new'               => esc_html__( 'Add Portfolio', 'tenup-plugin' ),
					'add_new_item'          => esc_html__( 'Add New Portfolio', 'tenup-plugin' ),
					'edit_item'             => esc_html__( 'Edit Portfolio', 'tenup-plugin' ),
					'new_item'              => esc_html__( 'New Portfolio', 'tenup-plugin' ),
					'view_item'             => esc_html__( 'View Portfolio', 'tenup-plugin' ),
					'view_items'            => esc_html__( 'View Portfolios', 'tenup-plugin' ),
					'search_items'          => esc_html__( 'Search Portfolios', 'tenup-plugin' ),
					'not_found'             => esc_html__( 'No portfolios found', 'tenup-plugin' ),
					'not_found_in_trash'    => esc_html__( 'No portfolios found in Trash', 'tenup-plugin' ),
					'parent_item_colon'     => esc_html__( 'Parent Portfolio:', 'tenup-plugin' ),
					'all_items'             => esc_html__( 'All Portfolios', 'tenup-plugin' ),
					'archives'              => esc_html__( 'Portfolio Archives', 'tenup-plugin' ),
					'attributes'            => esc_html__( 'Portfolio Attributes', 'tenup-plugin' ),
					'insert_into_item'      => esc_html__( 'Insert into portfolio', 'tenup-plugin' ),
					'uploaded_to_this_item' => esc_html__( 'Uploaded to this portfolio', 'tenup-plugin' ),
					'featured_image'        => esc_html__( 'Featured image', 'tenup-plugin' ),
					'set_featured_image'    => esc_html__( 'Set featured image', 'tenup-plugin' ),
					'remove_featured_image' => esc_html__( 'Remove featured image', 'tenup-plugin' ),
					'use_featured_image'    => esc_html__( 'Use as featured image', 'tenup-plugin' ),
					'menu_name'             => esc_html__( 'Portfolios', 'tenup-plugin' ),
					'filter_items_list'     => esc_html__( 'Filter portfolios list', 'tenup-plugin' ),
					'items_list_navigation' => esc_html__( 'Portfolios list navigation', 'tenup-plugin' ),
					'items_list'            => esc_html__( 'Portfolios list', 'tenup-plugin' ),
					// Add more labels as needed.
				],
				'description'           => esc_html__( 'Portfolio custom post type.', 'tenup-plugin' ),
				'public'                => true,
				'publicly_queryable'    => true,
				'exclude_from_search'   => false,
				'show_ui'               => true,
				'show_in_menu'          => true,
				'show_in_nav_menus'     => true,
				'show_in_admin_bar'     => true,
				'menu_position'         => 5,
				'menu_icon'             => $this->get_menu_icon(),
				'capability_type'       => 'post',
				'capabilities'          => [],
				'map_meta_cap'          => true,
				'hierarchical'          => false,
				'supports'              => $this->get_supported_features(),
				'taxonomies'            => $this->get_supported_taxonomies(),
				'has_archive'           => true,
				'rewrite'               => [
					'slug'       => 'portfolio',
					'with_front' => true,
				],
				'query_var'             => true,
				'can_export'            => true,
				'show_in_rest'          => true,
				'rest_base'             => 'portfolio',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				// Add any other options as needed.
			]
		);
		return true;
	}
}
