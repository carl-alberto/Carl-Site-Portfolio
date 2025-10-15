<?php
/**
 * Provider Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

class Provider extends AbstractTaxonomy {
    public function get_name() {
        return 'provider';
    }
    public function get_singular_label() {
        return esc_html__( 'Provider', 'tenup-plugin' );
    }
    public function get_plural_label() {
        return esc_html__( 'Providers', 'tenup-plugin' );
    }
    public function get_object_type() {
        return [ 'learning' ];
    }
    public function can_register() {
        return true;
    }
}
