<?php
use PHPUnit\Framework\TestCase;

/**
 * @group blocks
 */
class FeaturedCoverBlockRenderTest extends WP_UnitTestCase {

    public function test_render_without_featured_image() {
        $post_id = self::factory()->post->create();
        $this->go_to( get_permalink( $post_id ) );

        $attributes = [
            'backgroundColor' => '#123456',
            'textColor'       => 'white',
        ];

        $content = '<p>Inner content</p>';

        // Simulate render.php logic
        ob_start();
        include dirname( __FILE__, 2 ) . '/blocks/featured-cover-block/render.php';
        $output = ob_get_clean();

        $this->assertStringContainsString( 'background-color:#123456', $output );
        $this->assertStringContainsString( $content, $output );
        $this->assertStringNotContainsString( 'background-image', $output );
    }

    public function test_render_with_featured_image() {
        $post_id = self::factory()->post->create();
        $attachment_id = self::factory()->attachment->create_upload_object( DIR_TESTDATA . '/images/canola.jpg', $post_id );
        set_post_thumbnail( $post_id, $attachment_id );

        $this->go_to( get_permalink( $post_id ) );

        $attributes = [
            'backgroundColor' => '#654321',
            'textColor'       => 'white',
        ];

        $content = '<p>With image</p>';

        // Simulate render.php logic
        ob_start();
        include dirname( __FILE__, 2 ) . '/blocks/featured-cover-block/render.php';
        $output = ob_get_clean();

        $this->assertStringContainsString( 'background-image', $output );
        $this->assertStringContainsString( 'background-color:#654321', $output );
        $this->assertStringContainsString( $content, $output );
    }
}
