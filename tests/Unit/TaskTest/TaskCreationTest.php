<?php

namespace Tests\Unit\AuthTest;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TaskCreationTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_task_created_successfully()
    {
        $user = User::find(1);
        $this->actingAs($user, 'sanctum');
        $taskData = [
            'title' => 'Grocery shopping',
            'description' => 'I want to go shopping',
            'planned_date' => '2024-08-20',
            'status' => 'todo',
        ];
        $response = $this->postJson('/api/tasks', $taskData);
        $response->assertStatus(201);
    }
}
