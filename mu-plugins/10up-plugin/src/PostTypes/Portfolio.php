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
     * Run any code after the post type has been registered.
     *
     * @return void
     */
    public function after_register() {
        // Register any hooks/filters you need.
    }
}
