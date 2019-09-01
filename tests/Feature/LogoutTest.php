<?php

namespace Tests\Feature;

use App\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(User::class)->create(['email' => 'user@mail.com']);
        $user->assignRole([Role::where('name', 'User')->first()->id]);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('get', '/api/clients', [], $headers)->assertStatus(200);
        $this->json('get', '/api/logout', [], $headers)->assertStatus(200);
    }

    public function testUserWithNullToken()
    {
        // Simulating login
        $user = factory(User::class)->create(['email' => 'user@mail.com']);
        $token = $user->createToken('RestApi')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        // Simulating logout
        $user->authAcessToken()->delete();

        $this->json('get', '/api/clients', [], $headers)->assertStatus(401);
    }
}
