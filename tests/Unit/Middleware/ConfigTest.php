<?php
/**
 * {description}
 *
 * @author
 */

namespace Tests\Unit\Middleware;

class ConfigTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function invokable_returns_callable(): void
    {
        $response = new \middleware\Config();

        $this->assertInternalType('callable', $response);
    }
}