<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_can_view_tasks_index()
    {
        $response = $this->actingAs($this->user)
            ->get(route('tasks.index'));

        $response->assertStatus(200);
    }

    public function test_can_create_task()
    {
        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'todo',
            'due_date' => now()->addDays(7)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
            'user_id' => $this->user->id,
        ]);
    }

    public function test_can_update_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'todo',
        ]);

        $updatedData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => 'in_progress',
            'due_date' => now()->addDays(14)->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->user)
            ->put(route('tasks.update', $task), $updatedData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
            'status' => 'in_progress',
        ]);
    }

    public function test_can_delete_task()
    {
        $task = Task::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_cannot_update_other_users_task()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $updatedData = [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'status' => 'in_progress',
        ];

        $response = $this->actingAs($this->user)
            ->put(route('tasks.update', $task), $updatedData);

        $response->assertForbidden();
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
        ]);
    }

    public function test_cannot_delete_other_users_task()
    {
        $otherUser = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $task));

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_can_filter_tasks_by_status()
    {
        Task::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'todo',
        ]);

        Task::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('tasks.index', ['status' => 'todo']));

        $response->assertStatus(200);
        $response->assertInertia(fn ($assert) => $assert
            ->component('Tasks/Index')
            ->has('tasks', 1)
            ->where('tasks.0.status', 'todo')
        );
    }
} 