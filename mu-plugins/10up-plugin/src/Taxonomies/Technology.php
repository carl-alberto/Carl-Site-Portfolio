<?php
/**
 * Technology Taxonomy
 *
 * @package TenUpPlugin
 */

namespace TenUpPlugin\Taxonomies;

use TenupFramework\Taxonomies\AbstractTaxonomy;

/**
 * Registers the "Technology" taxonomy.
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
	 * Get the object type associated with the taxonomy.
	 *
	 * @return array
	 */
	public function get_object_type() {
		return [ 'learning' ];
	}

	/**
	 * Can the class be registered?
	 *
	 * @return bool
	 */
	public function can_register() {
		return true;
	}
}
