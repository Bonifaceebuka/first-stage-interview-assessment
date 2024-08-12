<?php

namespace Tests\Unit\AuthTest;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskUpdateTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_task_updated_successfully()
    {
        $user = User::find(1);
        $task = Task::find(2);
        $this->actingAs($user, 'sanctum');

        $taskData = [
            'title' => 'Clothe shopping',
            'description' => 'I want to go shopping for new clothes',
            'status' => 'completed'
        ];
        $response = $this->putJson('/api/tasks/'.$task->id, $taskData);
        $response->assertStatus(200);
    }
}
