<?php

namespace Tests\Feature\Article;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepotArticlesTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     */
    public function test_api_route()
    {
        $response = $this->get('/api/article/1');
        $response->assertStatus(200);
    }


    /**
     * @test
     *
     * @return void
     */
    public function get_all_articles()
    {
        $response = $this->get('/api/article/1');
        $response->assertStatus(200);
    }
}
