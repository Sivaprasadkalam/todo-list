<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCreation()
    {
        // Create a user
        $user = User::factory()->create();
    
        // Log in the user
        $this->actingAs($user);
    
        // Create a task
        $response = $this->post('/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'due_date' => now(), // Add due date
            'priority' => 'high', // Add priority
            'status' => 'Pending',
            'category_id' => null
        ]);
    
        // Assert that the response redirects
        $response->assertRedirect('/tasks'); // Change this line
    
        // Assert that the task has been created in the database
        $this->assertDatabaseHas('tasks', ['title' => 'Test Task']);
    }
    


    public function testTaskUpdating()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a task for the user
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Log in the user
        $this->actingAs($user);

        // Update the task
        $response = $this->put("/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'due_date' => now(), // Add due date
            'priority' => 'High', // Add priority
            'status' => 'In Progress',
        ]);

        // Assert that the response is a redirect
        $response->assertRedirect('/tasks');

        // Assert that the task has been updated in the database
        $this->assertDatabaseHas('tasks', ['title' => 'Updated Title']);
    }

    public function testTaskDeletion()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a task for the user
        $task = Task::factory()->create(['user_id' => $user->id]);

        // Log in the user
        $this->actingAs($user);

        // Delete the task
        $response = $this->delete("/tasks/{$task->id}");

        // Assert that the response is a redirect
        $response->assertRedirect('/tasks');

        // Assert that the task has been deleted from the database
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
