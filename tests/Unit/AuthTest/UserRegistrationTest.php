<?php

namespace Tests\Unit\AuthTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_user_registration_successful()
    {
        $userData = [
            'email' => 'boniface@dev.com',
            'password' => 'password123',
            'name' => 'Agbo Boniface',
        ];
        $response = $this->postJson('/api/auth/register', $userData);
        $response->assertStatus(201);
    }
}
