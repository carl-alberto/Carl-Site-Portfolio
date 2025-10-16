<?php
/**
 * Contribution Type Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

/**
 * Add Contribution Type taxonomy.
 */
class ContributionType extends AbstractTaxonomy {

	/**
	 * Get the taxonomy name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'contribution_type';
	}

	/**
	 * Get the singular label for the taxonomy.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return esc_html__( 'Contribution Type', 'tenup-plugin' );
	}

	/**
	 * Get the plural label for the taxonomy.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return esc_html__( 'Contribution Types', 'tenup-plugin' );
	}

	/**
	 * Get the object types the taxonomy is associated with.
	 *
	 * @return array
	 */
	public function get_object_type() {
		return [ 'contribution' ];
	}

	/**
	 * Register the taxonomy as hierarchical.
	 */
	public function can_register() {
		return true;
	}
}
