<?php

use PHPUnit\Framework\TestCase;
use TenUpPlugin\PostTypes\Learning;

class TestLearning extends TestCase {
    public function test_getters_return_expected_values() {
        $learning = new Learning();

        $this->assertSame('learning', $learning->get_name());
        $this->assertStringContainsString('Learning', $learning->get_singular_label());
        $this->assertStringContainsString('Learnings', $learning->get_plural_label());

        $supports = $learning->get_supported_features();
        $this->assertIsArray($supports);
        $this->assertContains('title', $supports);
        $this->assertContains('editor', $supports);

        $taxes = $learning->get_supported_taxonomies();
        $this->assertIsArray($taxes);
        $this->assertContains('technology', $taxes);
    }

    public function test_can_register_returns_bool_and_register_does_not_throw() {
        $learning = new Learning();
        $this->assertTrue(is_bool($learning->can_register()));

        // register() will call register_post_type which exists in WP; ensure it doesn't fatally error by
        // defining a noop function if it's not present
        if (! function_exists('register_post_type')) {
            function register_post_type($name, $args = []) {
                return [$name, $args];
            }
        }

        $this->expectNotToPerformAssertions();
        $learning->register();
    }
}
