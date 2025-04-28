<?php

namespace Tests\Feature;

use App\Models\Subtask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubtaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_a_subtask_for_a_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->post(route('tasks.subtasks.store', $task), [
            'title' => 'Test Subtask'
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('subtasks', [
            'task_id' => $task->id,
            'title' => 'Test Subtask'
        ]);
    }

    public function test_can_update_a_subtask_status_and_task_status_updates_accordingly()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);
        $subtask = Subtask::factory()->create([
            'task_id' => $task->id,
            'is_completed' => false
        ]);

        $response = $this->actingAs($user)->put(route('subtasks.update', $subtask), [
            'is_completed' => true
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('subtasks', [
            'id' => $subtask->id,
            'is_completed' => true
        ]);
        
        // Verify task status is updated
        $task->refresh();
        $this->assertEquals('done', $task->status);
    }

    public function test_can_delete_a_subtask_and_task_status_updates_accordingly()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create([
            'user_id' => $user->id,
            'status' => 'in_progress'
        ]);
        
        // Create multiple subtasks
        $subtask1 = Subtask::factory()->create([
            'task_id' => $task->id,
            'is_completed' => true
        ]);
        
        $subtask2 = Subtask::factory()->create([
            'task_id' => $task->id,
            'is_completed' => false
        ]);

        // Delete the completed subtask
        $response = $this->actingAs($user)->delete(route('subtasks.destroy', $subtask1));

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('subtasks', [
            'id' => $subtask1->id
        ]);
        
        // Verify task status is updated to in_progress since there's still an incomplete subtask
        $task->refresh();
        $this->assertEquals('in_progress', $task->status);

        // Delete the remaining subtask
        $response = $this->actingAs($user)->delete(route('subtasks.destroy', $subtask2));

        // Verify task status is updated to todo when all subtasks are deleted
        $task->refresh();
        $this->assertEquals('todo', $task->status);
    }
} 