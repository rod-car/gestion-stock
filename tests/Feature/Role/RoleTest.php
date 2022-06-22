<?php

namespace Tests\Feature\Role;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * Recuperer toutes les roles.
     *
     * @test
     * @return void
     */
    public function get_all_roles()
    {
        $response = $this->get('/api/roles');
        $response->assertStatus(200);
        $datas = json_decode($response->getContent());
        $this->assertCount(20, $datas);
    }


    /**
     * Recuperer une role
     *
     * @test
     * @return void
     */
    public function get_one_role()
    {
        $response = $this->get('/api/roles/1');
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals(1, $data['id']);
    }


    /**
     * Tester la creation d'un nouveau role
     *
     * @test
     * @return void
     */
    public function create_role()
    {
        $data = [
            'nom_role' => "Ajouter article"
        ];

        $response = $this->post("/api/roles", $data);
        $response->assertStatus(201);
        $data = json_decode($response->getContent(), true);
        $this->assertEquals('Ajouter article', $data['nom_role']);
    }

    /**
     * Tester la creation d'un role déja éxistant
     *
     * @test
     * @return void
     */
    public function create_role_already_exist()
    {
        $data = [
            'nom_role' => "Ajouter article"
        ];

        $response = $this->post("/api/roles", $data);
        $response->assertStatus(422);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $data);
    }


    /**
     * Tester la mise a jour de role
     *
     * @test
     * @return void
     */
    public function update_role()
    {
        $data = [
            'nom_role' => "Ajouter article modifié"
        ];

        $response = $this->patch("/api/roles/1", $data);
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('success', $data);
    }


    /**
     * Tester la supprésion d'un role
     *
     * @test
     * @return void
     */
    public function delete_role()
    {
        $response = $this->delete("/api/roles/6");
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('success', $data);
    }

    /**
     * Tester la supprésion d'un role qui n'est pas supprimable
     *
     * @test
     * @return void
     */
    public function delete_role_with_constraint_error()
    {
        $response = $this->delete("/api/roles/1");
        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('errors', $data);
    }
}
