<?php
/**
 * Contribution Type Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

class ContributionType extends AbstractTaxonomy {
	public function get_name() {
		return 'contribution_type';
	}
	public function get_singular_label() {
		return esc_html__( 'Contribution Type', 'tenup-plugin' );
	}
	public function get_plural_label() {
		return esc_html__( 'Contribution Types', 'tenup-plugin' );
	}
	public function get_object_type() {
		return [ 'community_contribution' ];
	}
	public function can_register() {
		return true;
	}
}
