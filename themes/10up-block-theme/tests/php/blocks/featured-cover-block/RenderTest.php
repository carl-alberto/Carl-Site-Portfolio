<?php

use PHPUnit\Framework\TestCase;
use Brain\Monkey;
use Brain\Monkey\Functions;

class RenderTest extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();

		Functions\when('get_post')->alias(fn() => $GLOBALS['post']);
		Functions\when('get_the_post_thumbnail_url')->alias(fn() => false);
		Functions\when('get_block_wrapper_attributes')->alias(fn() => 'class="wp-block-myplugin-featured-cover-block"');
		Functions\when('esc_url')->alias(fn($url) => $url);
		Functions\when('esc_attr')->alias(fn($attr) => $attr);
	}

    protected function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }

    public function test_render_with_featured_image_and_content() {
        $attributes = [
            'backgroundColor' => '#ff0000',
            'textColor' => '#ffffff',
        ];
        $content = '<p>Inner content</p>';

        $post = (object) ['ID' => 123];
        $GLOBALS['post'] = $post;

        Functions\when('get_post')->justReturn($post);
        Functions\when('get_the_post_thumbnail_url')->justReturn('https://example.com/image.jpg');
        Functions\when('get_block_wrapper_attributes')->justReturn('class="wp-block-myplugin-featured-cover-block"');

        ob_start();
        include __DIR__ . '/../../../../blocks/featured-cover-block/render.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('background-image: url(https://example.com/image.jpg)', $output);
        $this->assertStringContainsString('background-color:#ff0000', $output);
        $this->assertStringContainsString($content, $output);
    }

    public function test_render_without_featured_image() {
        $attributes = [];
        $content = '';

        $post = (object) ['ID' => 456];
        $GLOBALS['post'] = $post;

        Functions\when('get_post')->justReturn($post);
        Functions\when('get_the_post_thumbnail_url')->justReturn(false);
        Functions\when('get_block_wrapper_attributes')->justReturn('class="wp-block-myplugin-featured-cover-block"');

        ob_start();
        include __DIR__ . '/../../../../blocks/featured-cover-block/render.php';
        $output = ob_get_clean();

        $this->assertStringNotContainsString('background-image:', $output);
        $this->assertStringContainsString('background-color:#172030', $output);
    }
}
