<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an admin can create an agent profile', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('users.store'), [
            'name' => 'Agent Principal',
            'email' => 'agent.principal@example.com',
            'password' => 'password',
            'role' => User::RoleAgent,
            'status' => 'active',
        ])
        ->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
        'email' => 'agent.principal@example.com',
        'role' => User::RoleAgent,
    ]);
});

test('an agent cannot manage profiles', function () {
    $agent = User::factory()->agent()->create();

    $this->actingAs($agent)
        ->get(route('users.index'))
        ->assertForbidden();
});
