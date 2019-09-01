<?php

namespace Tests\Feature;

use App\Client;
use App\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function testsClientsAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $user->assignRole([Role::where('name', 'User')->first()->id]);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'name' => 'Szczepańska',
            'vat_number' => '6529411372',
            'street' => 'Sądowa 15A/28',
            'city' => 'Bogatynia',
            'post_code' => '22-090',
            'email' => 'jbaranowska@kwiatkowska.info'
        ];

        $this->json('POST', '/api/clients', $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => 11,
                    'name' => 'Szczepańska',
                    'vat_number' => '6529411372',
                    'street' => 'Sądowa 15A/28',
                    'city' => 'Bogatynia',
                    'post_code' => '22-090',
                    'email' => 'jbaranowska@kwiatkowska.info'
                ],
                'message' => 'Client created successfully.'
            ]);
    }

    public function testsClientsAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $user->assignRole([Role::where('name', 'User')->first()->id]);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Client::class)->create([
            'name' => 'Szczepańska',
            'vat_number' => '6529411372',
            'street' => 'Sądowa 15A/28',
            'city' => 'Bogatynia',
            'post_code' => '22-090',
            'email' => 'jszczepan@kwiatkowska.info'
        ]);

        $payload = [
            'name' => 'Barańska',
            'vat_number' => '1234567890',
            'street' => 'Rolna 12',
            'city' => 'Warszawa',
            'post_code' => '01-000',
            'email' => 'pbaranska@mail.com'
        ];

        $response = $this->json('PUT', '/api/clients/'.$article->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => 11,
                    'name' => 'Barańska',
                    'vat_number' => '1234567890',
                    'street' => 'Rolna 12',
                    'city' => 'Warszawa',
                    'post_code' => '01-000',
                    'email' => 'pbaranska@mail.com'
                ],
                'message' => 'Client updated successfully.'
            ]);
    }

    public function testsClientsAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $user->assignRole([Role::where('name', 'User')->first()->id]);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Client::class)->create([
            'name' => 'Szczepańska',
            'vat_number' => '6529411372',
            'street' => 'Sądowa 15A/28',
            'city' => 'Bogatynia',
            'post_code' => '22-090',
            'email' => 'jszczepan@kwiatkowska.info'
        ]);

        $this->json('DELETE', '/api/clients/'.$article->id, [], $headers)
            ->assertStatus(200);
    }

    public function testClientsAreListedCorrectly()
    {
        factory(Client::class)->create([
            'name' => 'Szczepańska',
            'vat_number' => '6529411372',
            'street' => 'Sądowa 15A/28',
            'city' => 'Bogatynia',
            'post_code' => '22-090',
            'email' => 'jszczepan@kwiatkowska.info'
        ]);

        factory(Client::class)->create([
            'name' => 'Barańska',
            'vat_number' => '1234567890',
            'street' => 'Rolna 12',
            'city' => 'Warszawa',
            'post_code' => '01-000',
            'email' => 'pbaranska@mail.com'
        ]);

        $user = factory(User::class)->create();
        $user->assignRole([Role::where('name', 'User')->first()->id]);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/clients', [], $headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'vat_number',
                            'street',
                            'city',
                            'post_code',
                            'email'
                        ]
                    ],
                    'message'
            ]);
    }
}
