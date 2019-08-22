<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testRequiresEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthorized.',
            ]);
    }


    public function testUserLoginsSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
        ]);

        $payload = ['email' => 'admin@mail.com', 'password' => 'password'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);

    }
}
