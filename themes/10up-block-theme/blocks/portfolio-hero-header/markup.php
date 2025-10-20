<?php
/**
 * tenup markup
 *
 * @package tenup\Blocks\tenup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the post ID safely - ensure it's a valid integer
$post_id = get_the_ID();
if ( ! $post_id || $post_id < 0 ) {
	return; // Exit early if no valid post ID
}

$featured_image_url = get_the_post_thumbnail_url( $post_id, 'full' );
$taxonomy           = get_the_term_list( $post_id, 'technology', '', ', ' );
$custom_field       = get_post_meta( $post_id, 'role', true );
$excerpt            = get_the_excerpt( $post_id );
$title              = get_the_title( $post_id );
?>

<div <?php echo wp_kses_post( get_block_wrapper_attributes() ); ?>>
	<div class="portfolio-hero-header" style="position:relative;">
		<?php if ( $featured_image_url ) : ?>
			<img src="<?php echo esc_url( $featured_image_url ); ?>" class="portfolio-hero-header-bg" alt="" />
			<div class="portfolio-hero-header-gradient"></div>
		<?php endif; ?>

		<div class="portfolio-hero-header-content wp-block-group__inner-container">
			<?php if ( $title ) : ?>
				<h1 class="portfolio-hero-header-title"><?php echo esc_html( $title ); ?></h1>
			<?php endif; ?>

			<?php if ( $excerpt ) : ?>
				<p class="portfolio-hero-header-excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>

			<?php if ( $taxonomy ) : ?>
				<div class="portfolio-hero-header-taxonomy">
					<?php echo wp_kses_post( $taxonomy ); // @phpstan-ignore-line ?>
				</div>
			<?php endif; ?>

			<?php if ( $custom_field ) : ?>
				<div class="portfolio-hero-header-custom">
					<?php echo esc_html( $custom_field ); // @phpstan-ignore-line ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
