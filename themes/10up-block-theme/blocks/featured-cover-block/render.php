<?php
/**
 * Hero block with featured image background, site title, and taxonomies.
 *
 * @package myplugin\Blocks\featured-cover-block
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Inner block content (not used here, but kept for flexibility).
 * @var WP_Block $block      Block instance.
 */

$post               = get_post();
$post_id            = $post ? $post->ID : 0;
$featured_image_url = get_the_post_thumbnail_url( $post_id, 'large' );

$text_color       = $attributes['textColor'] ?? '';
$background_color = $attributes['backgroundColor'] ?? '#172030';


if ( false === $featured_image_url ) {
	$outer_div = get_block_wrapper_attributes();
} else {
	$featured_image_url = esc_url( $featured_image_url );
	$outer_div          = get_block_wrapper_attributes() . ' style="background-image: url(' . $featured_image_url . ');"';
}

?>
<div <?php echo $outer_div; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="overlay" <?php echo $background_color ? 'style="background-color:' . esc_attr( $background_color ) . ';"' : ''; ?>></div>
	<?php if ( ! empty( $content ) ) : ?>
			<div class="featured-cover-block__inner-content">
				<?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</div>
		<?php endif; ?>
	</div>
</div>
