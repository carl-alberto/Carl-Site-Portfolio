<?php
/**
 * Hero block with featured image background, site title, and taxonomies.
 *
 * @package tenup\Blocks\hero-block
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner block content (not used here, but kept for flexibility).
 * @var WP_Block $block      Block instance.
 */

$post    = get_post();
$post_id = $post ? $post->ID : 0;

// Fallback if no post (e.g., in widget area or template without post)
if ( ! $post_id ) {
	return;
}

// Get featured image URL
$featured_image_url = get_the_post_thumbnail_url( $post_id, 'large' );

// Get post title
$post_title = get_the_title( $post_id );

// Get taxonomies (example: category and post_tag)
$taxonomy_terms = [];
$taxonomies     = get_post_taxonomies( $post_id );
foreach ( $taxonomies as $tax ) {
	// Skip internal or hidden taxonomies
	if ( in_array( $tax, [ 'post_format' ], true ) ) {
		continue;
	}
	$terms = get_the_terms( $post_id, $tax );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $term ) {
			$taxonomy_terms[] = esc_html( $term->name );
		}
	}
}
$taxonomy_list = implode( ', ', $taxonomy_terms );
?>

<div <?php echo get_block_wrapper_attributes();  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $featured_image_url ) : ?>
		<div class="hero-block__background" style="background-image: url(<?php echo esc_url( $featured_image_url ); ?>);">
			<div class="hero-block__content">
				<?php if ( $post_title ) : ?>
					<h1 class="hero-block__title"><?php echo esc_html( $post_title ); ?></h1>
				<?php endif; ?>

				<?php if ( $taxonomy_list ) : ?>
					<div class="hero-block__taxonomies">
						<?php echo esc_html( $taxonomy_list ); ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $content ) ) : ?>
					<div class="hero-block__inner-content">
						<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
