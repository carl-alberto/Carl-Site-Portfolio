<?php
use PHPUnit\Framework\TestCase;

class Test_Featured_Cover_Block_Render extends TestCase {
    protected function setUp(): void {
        \WP_Mock::setUp();
        \WP_Mock::userFunction('get_post', [
            'return' => (object) ['ID' => 7],
        ]);
    }

    protected function tearDown(): void {
        \WP_Mock::tearDown();
    }

    public function test_no_featured_image() {
        \WP_Mock::userFunction('get_the_post_thumbnail_url', ['return' => false]);

        $attributes = [];
        $content = '<p>Inner content</p>';
        ob_start();
        include __DIR__ . '/../../blocks/featured-cover-block/render.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('wp-block-myplugin-featured-cover-block', $output);
        $this->assertStringContainsString('background-color:#172030', $output);
        $this->assertStringNotContainsString('background-image', $output);
    }

    public function test_with_featured_image() {
        $img = 'https://example.com/featured.jpg';
        \WP_Mock::userFunction('get_the_post_thumbnail_url', ['return' => $img]);

        ob_start();
        include __DIR__ . '/../../blocks/featured-cover-block/render.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('background-image: url(' . esc_url($img) . ')', $output);
    }
}
