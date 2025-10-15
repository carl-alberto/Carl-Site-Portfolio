<?php
/**
 * Technology Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

class Technology extends AbstractTaxonomy {
    public function get_name() {
        return 'technology';
    }
    public function get_singular_label() {
        return esc_html__( 'Technology', 'tenup-plugin' );
    }
    public function get_plural_label() {
        return esc_html__( 'Technologies', 'tenup-plugin' );
    }
    public function get_object_type() {
        return [ 'learning' ];
    }
    public function can_register() {
        return true;
    }
}
