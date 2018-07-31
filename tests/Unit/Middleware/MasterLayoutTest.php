<?php
/**
 * {description}
 *
 * @author
 */

namespace Tests\Unit\Middleware;

class MasterLayoutTest extends \PHPUnit\Framework\TestCase
{
    /** @test */
    public function invokable_returns_callable(): void
    {
        $response = new \middleware\MasterLayout();

        $this->assertInternalType('callable', $response);
    }
}