<?php

namespace Tests\Unit\AuthTest;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class FetchOneTaskTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_is_one_task_fetched_successfully()
    {
        $user = User::find(1);
        $task = Task::find(1);
        $this->actingAs($user, 'sanctum');

        $response = $this->getJson('/api/tasks/'.$task->id);
        $response->assertStatus(200);
    }
}
