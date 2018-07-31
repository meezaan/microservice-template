<?php

namespace Tests\Functional;

class HomepageTest extends BaseTestCase
{
    /** @test */
    public function index_page_returns_status_200(): void
    {
        $response = $this->runApp('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
    }
}
