<?php

namespace Tests\Feature;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/tasks');

        $response->assertOk()
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'title', 'description', 'status', 'created_at', 'updated_at'],
                ],
                'links',
                'meta',
            ]);
    }

    public function test_it_creates_a_task(): void
    {
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Write tests',
            'description' => 'Cover the task API',
            'status' => TaskStatus::Pending->value,
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.title', 'Write tests')
            ->assertJsonPath('data.description', 'Cover the task API')
            ->assertJsonPath('data.status', TaskStatus::Pending->value);

        $this->assertDatabaseHas('tasks', [
            'title' => 'Write tests',
            'status' => TaskStatus::Pending->value,
        ]);
    }

    public function test_it_rejects_a_task_when_required_fields_are_missing(): void
    {
        $response = $this->postJson('/api/v1/tasks', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'status']);
    }

    public function test_it_rejects_an_unknown_status(): void
    {
        $response = $this->postJson('/api/v1/tasks', [
            'title' => 'Write tests',
            'status' => 'archived',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['status']);
    }

    public function test_it_returns_not_found_for_a_missing_task(): void
    {
        $this->getJson('/api/v1/tasks/999')->assertNotFound();
    }

    public function test_it_updates_a_task(): void
    {
        $task = Task::factory()->create([
            'status' => TaskStatus::Pending,
        ]);

        $response = $this->patchJson('/api/v1/tasks/'.$task->id, [
            'title' => 'Updated title',
            'status' => TaskStatus::Completed->value,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Updated title')
            ->assertJsonPath('data.status', TaskStatus::Completed->value);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated title',
            'status' => TaskStatus::Completed->value,
        ]);
    }

    public function test_it_replaces_a_task_with_put(): void
    {
        $task = Task::factory()->create([
            'description' => 'Old description',
            'status' => TaskStatus::Pending,
        ]);

        $response = $this->putJson('/api/v1/tasks/'.$task->id, [
            'title' => 'Replaced title',
            'description' => null,
            'status' => TaskStatus::InProgress->value,
        ]);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Replaced title')
            ->assertJsonPath('data.description', null)
            ->assertJsonPath('data.status', TaskStatus::InProgress->value);
    }

    public function test_it_deletes_a_task(): void
    {
        $task = Task::factory()->create();

        $this->deleteJson('/api/v1/tasks/'.$task->id)->assertNoContent();

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
