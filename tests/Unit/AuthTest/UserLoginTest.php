<?php

namespace Tests\Unit\AuthTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_user_login_successful(): void
    {
        $userData = [
            'email' => 'boniface@dev.com',
            'password' => 'password123',
        ];
        $response = $this->postJson('/api/auth/login', $userData);
        $response->assertStatus(200);
    }
}
