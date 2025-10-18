<?php
/**
 * Technology Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

/**
 * Technology Taxonomy.
 */
class Technology extends AbstractTaxonomy {

	/**
	 * Get the taxonomy name.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'technology';
	}

	/**
	 * Get the singular taxonomy label.
	 *
	 * @return string
	 */
	public function get_singular_label() {
		return esc_html__( 'Technology', 'tenup-plugin' );
	}

	/**
	 * Get the plural taxonomy label.
	 *
	 * @return string
	 */
	public function get_plural_label() {
		return esc_html__( 'Technologies', 'tenup-plugin' );
	}

	/**
	 * Checks whether the Module should run within the current context.
	 *
	 * @return bool
	 */
	public function can_register() {
		return true;
	}
}
