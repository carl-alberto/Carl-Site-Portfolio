<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class PortfolioHeaderTest extends TestCase
{
    public function test_portfolio_block_files_exist(): void
    {
        $files = [
            __DIR__ . '/../../blocks/portfolio-header/block.json',
            __DIR__ . '/../../blocks/portfolio-header/markup.php',
        ];

        foreach ($files as $file) {
            $this->assertFileExists($file, "Missing: $file");
        }
    }

    public function test_renders_with_featured_image(): void
    {
        global $mock_thumbnail_url;
        $mock_thumbnail_url = 'https://example.com/hero.jpg';

        ob_start();
        require __DIR__ . '/../../blocks/portfolio-header/markup.php';
        $output = ob_get_clean();

        $this->assertNotEmpty($output);
        $this->assertStringContainsString('wp-block-tenup-portfolio-header', $output);
        $this->assertStringContainsString('hero-block__background', $output);
        $this->assertStringContainsString('https://example.com/hero.jpg', $output);
        $this->assertStringContainsString('Test Portfolio', $output);
        $this->assertStringContainsString('Portfolio, Design', $output);
    }

    public function test_renders_without_featured_image(): void
    {
        global $mock_thumbnail_url;
        $mock_thumbnail_url = '';

        ob_start();
        require __DIR__ . '/../../blocks/portfolio-header/markup.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('wp-block-tenup-portfolio-header', $output);
        $this->assertStringNotContainsString('hero-block__background', $output);
    }

    public function test_renders_taxonomies(): void
    {
        global $mock_thumbnail_url;
        $mock_thumbnail_url = 'https://example.com/hero.jpg';

        ob_start();
        require __DIR__ . '/../../blocks/portfolio-header/markup.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('hero-block__taxonomies', $output);
        $this->assertStringContainsString('Portfolio, Design', $output);
    }

    public function test_block_wrapper_attributes(): void
    {
        global $mock_thumbnail_url;
        $mock_thumbnail_url = 'https://example.com/hero.jpg';

        ob_start();
        require __DIR__ . '/../../blocks/portfolio-header/markup.php';
        $output = ob_get_clean();

        $this->assertStringContainsString('wp-block-tenup-portfolio-header', $output);
        $this->assertStringContainsString('portfolio-block', $output);
    }
}
