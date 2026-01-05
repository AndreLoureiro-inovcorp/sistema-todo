<?php

use App\Models\Task;
use App\Models\User;

test('a user can create a task', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/tasks', [
        'title' => 'Test task',
        'description' => 'Task description',
        'priority' => 'high',
    ])->assertRedirect('/tasks');

    $this->assertDatabaseHas('tasks', [
        'title' => 'Test task',
        'user_id' => $user->id,
        'priority' => 'high',
    ]);
});

test('a user can see their own tasks', function () {
    $user = User::factory()->create();

    Task::factory()->create([
        'user_id' => $user->id,
        'title' => 'My task',
    ]);

    $this->actingAs($user)->get('/tasks')->assertOk()->assertSee('My task');
});

test('a user can update their task', function () {
    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
        'title' => 'Original title',
    ]);

    $this->actingAs($user)
        ->put("/tasks/{$task->id}", [
            'title' => 'Updated title',
            'description' => 'Updated description',
            'priority' => 'medium',
        ])
        ->assertRedirect('/tasks');

    $this->assertDatabaseHas('tasks', [
        'id' => $task->id,
        'title' => 'Updated title',
        'priority' => 'medium',
    ]);
});

test('a user can delete their task', function () {
    $user = User::factory()->create();

    $task = Task::factory()->create([
        'user_id' => $user->id,
    ]);

    $this->actingAs($user)
        ->delete("/tasks/{$task->id}")
        ->assertRedirect('/tasks');

    $this->assertDatabaseMissing('tasks', [
        'id' => $task->id,
    ]);
});

test('a user cannot see tasks from other users', function () {
    $user = User::factory()->create();

    Task::factory()->create([
        'title' => 'Other user task',
    ]);

    $this->actingAs($user)->get('/tasks')->assertOk()->assertDontSee('Other user task');
});
