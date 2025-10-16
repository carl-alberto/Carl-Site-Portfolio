<?php
/**
 * Company Link Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

class PortfolioCompany extends AbstractTaxonomy {
    public function get_name() {
        return 'portfolio-company';
    }
    public function get_singular_label() {
        return esc_html__( 'Company', 'tenup-plugin' );
    }
    public function get_plural_label() {
        return esc_html__( 'Companies', 'tenup-plugin' );
    }
    public function get_object_type() {
        return [ 'portfolio' ];
    }
    public function can_register() {
        return true;
    }
}
