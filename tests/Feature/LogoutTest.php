<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'admin@mail.com']);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/clients', [], $headers)->assertStatus(200);
        $this->json('get', '/api/logout', [], $headers)->assertStatus(200);
    }

    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create(['email' => 'admin@mail.com']);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Simulating logout
        $user->authAcessToken()->delete();

        $this->json('get', '/api/clients', [], $headers)->assertStatus(401);
    }
}
