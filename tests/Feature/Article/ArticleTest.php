<?php

namespace Tests\Feature\Article;

use App\Models\Article\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * Teste le fonctionnement de la route de l'article
     *
     * @return void
     */
    public function test_route_connection()
    {
        $response = $this->get('/api/article');

        $response->assertStatus(200);
    }

    /**
     * Teste la listes des articles obténues (Deux cents résultats par défaut donc on teste
     * le resultat par defaut)
     * Ce test peut echouer dans le cas d'une resultat paginé
     *
     * @return void
     */
    public function test_all_articles()
    {
        $response = $this->get('/api/article');

        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);

        $this->assertCount(200, $data);
    }

    /**
     * Test la pagination des articles
     *
     * @return void
     */
    public function test_all_articles_paginated()
    {
        $queryParameters = 'page=2';

        $response = $this->get("/api/article?$queryParameters");

        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);

        $this->assertCount(13, $data);
    }

    /**
     * Test la pagination des articles
     *
     * @return void
     */
    public function test_all_articles_paginated_manually()
    {
        $queryParameters = 'perPage=50&page=2';

        $response = $this->get("/api/article?$queryParameters");

        $response->assertStatus(200);

        $data = json_decode($response->getContent(), true);

        $this->assertCount(50, $data);
    }

    /**
     * Test la pagination des articles
     *
     * @return void
     */
    public function test_find_one_article()
    {
        $response = $this->get('/api/article/Ab id id aspernatur ut aut ad et.');

        $response->assertStatus(200);

        $this->assertNotNull($response->getData());
    }

    /**
     * Test la pagination des articles
     *
     * @return void
     */
    public function test_not_found_article()
    {
        $response = $this->get('/api/article/not-found-reference');

        $response->assertStatus(404);
    }
}
