<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserTest extends TestCase
{
    /**
     * Créer un utilisateur sans role
     *
     * @test
     * @return void
     */
    public function create_user_without_role()
    {
        $response = $this->post('/api/user', [
            'nom_personnel' => 'Rakoto',
            'prenoms_personnel' => 'Beloha',
            'email' => 'rakoto@example.com',
            'adresse_personnel' => "Tanambao 5",
            'cin_personnel' => '301032032334',
            'contact_personnel' => '0325654323',
            'password' => Hash::make('password'),
        ]);

        $response->assertStatus(201);
        $datas = json_decode($response->getContent());
        $this->assertNotEmpty($datas);
    }


    /**
     * Creer un utilisateur avec des roles existants
     *
     * @test
     * @return void
     */
    public function create_user_with_role()
    {
        $user = [
            'nom_personnel' => 'Role',
            'prenoms_personnel' => 'User',
            'email' => 'user-role@example.com',
            'adresse_personnel' => "Tanambao 5",
            'cin_personnel' => '301032032333',
            'contact_personnel' => '0325654323',
            'password' => Hash::make('password'),
        ];

        $roles = [1, 2, 3, 4]; // Identifiant des rôles

        $data = [
            'user' => $user,
            'roles' => $roles,
        ];

        $response = $this->post('/api/user', $data);

        $response->assertStatus(201);
        $datas = json_decode($response->getContent());
        $this->assertNotEmpty($datas);
    }
}
