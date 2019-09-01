<?php

namespace Tests\Feature;

use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully()
    {
        $payload = [
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => 'password',
            'c_password' => 'password',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);;
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/register')
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Validation error.',
                'data' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                    'c_password' => ['The c password field is required.']
                ]
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name' => 'User',
            'email' => 'user@mail.com',
            'password' => 'password',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Validation error.',
                'data' => [
                    'c_password' => ['The c password field is required.']
                ]
            ]);
    }
}
