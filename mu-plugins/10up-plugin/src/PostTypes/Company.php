<?php
/**
 * Company Post Type
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\PostTypes;

use TenupFramework\PostTypes\AbstractPostType;

class Company extends AbstractPostType {
    /**
     * Get the post type name.
     *
     * @return string
     */
    public function get_name() {
        return 'company';
    }

    /**
     * Get the singular post type label.
     *
     * @return string
     */
    public function get_singular_label() {
        return esc_html__( 'Company', 'tenup-plugin' );
    }

    /**
     * Get the plural post type label.
     *
     * @return string
     */
    public function get_plural_label() {
        return esc_html__( 'Companies', 'tenup-plugin' );
    }

    /**
     * Get the menu icon for the post type.
     *
     * @return string
     */
    public function get_menu_icon() {
        return 'dashicons-building';
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
     * Register the Company post type with block editor support.
     */
    public function register() {
        register_post_type( $this->get_name(), [
            'label' => $this->get_plural_label(),
            'public' => true,
            'show_in_rest' => true,
            'menu_icon' => $this->get_menu_icon(),
            'supports' => $this->get_supported_features(),
            'taxonomies' => $this->get_supported_taxonomies(),
        ] );
    }

    /**
     * Register custom meta fields for Company post type.
     */
    public function register_meta_fields() {
        register_post_meta( 'company', 'company', [
            'type' => 'string',
            'description' => 'Company name',
            'single' => true,
            'show_in_rest' => true,
        ] );
        register_post_meta( 'company', 'location', [
            'type' => 'string',
            'description' => 'Company location',
            'single' => true,
            'show_in_rest' => true,
        ] );
        register_post_meta( 'company', 'logo', [
            'type' => 'string',
            'description' => 'Company logo URL',
            'single' => true,
            'show_in_rest' => true,
        ] );
        register_post_meta( 'company', 'duration', [
            'type' => 'string',
            'description' => 'Duration',
            'single' => true,
            'show_in_rest' => true,
        ] );
        register_post_meta( 'company', 'position', [
            'type' => 'string',
            'description' => 'Position',
            'single' => true,
            'show_in_rest' => true,
        ] );
    }
}
