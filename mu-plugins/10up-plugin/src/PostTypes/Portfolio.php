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
	 * Get the menu position for the post type.
	 *
	 * @return int|null
	 */
	public function get_menu_position(): ?int {
		return 5;
	}

	/**
	 * Get the post type options.
	 *
	 * @return array<string, mixed>
	 */
	public function get_options(): array {
		$options                  = parent::get_options();
		$options['rewrite']       = [
			'slug'       => 'portfolio',
			'with_front' => true,
		];
		$options['rest_base']     = 'portfolio';
		$options['template']      = $this->get_custom_blocks();
		// $options['template_lock'] = 'insert';
		$options['public']        = true;
		$options['has_archive']   = true;
		return $options;
	}

	/**
	 * Structure the default blocks for the post type.
	 */
	public function get_custom_blocks(): array {
		$block_arrays = array(
			array( 'tenup/inner-block-test' ),
			array(
				'core/columns',
				array(),
				array(
					array(
						'core/column',
						array(
							'layout' => array( 'type' => 'constrained' ),
						),
						array(
							array( 'core/paragraph', array() ),
							array(
								'core/heading',
								array(
									'content' => 'Project Overview',
									'level'   => 2,
								),
							),
							// Nested columns
							array(
								'core/columns',
								array(),
								array(
									// First empty column
									array(
										'core/column',
										array(),
										array(
											array(
												'core/paragraph',
												array(
													'placeholder' => 'Add project details here...',
													'style'       => array(
														'spacing' => array(
															'padding' => array(
																'top' => "var:preset|spacing|16",
															),
														),
													),
												),
											),
										),
									),
									// Second column with styled paragraph
									array(
										'core/column',
										array(),
										array(
											array(
												'core/paragraph',
												array(
													'style' => array(
														'typography' => array(
															'fontSize' => '18px',
														),
														'backgroundColor' => 'indigo',
														'border'          => array(
															'radius' => '10px',
														),
													),
													'backgroundColor' => 'indigo',
												),
											),
										),
									),
								),
							),
							array(
								'core/gallery',
								array(
									'columns' => 3,
									'linkTo'  => 'none',
								),
							),
						),
					),
				),
			),
		);
		return $block_arrays;
	}
}
