<?php

use App\Models\User;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('"convidado" não pode acessar a lista de usuários', function () {
    $this->get(route('users.index'))
        ->assertRedirect(route('login'));
});

test('vendedor não pode acessar listagem de usuários (erro 403)', function () {
    $seller = User::factory()->create(['role' => UserRole::SELLER]);

    $this->actingAs($seller)
        ->get(route('users.index'))
        ->assertStatus(403);
});

test('admin pode listar usuários', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    User::factory()->count(3)->create();

    $response = $this->actingAs($admin)
        ->get(route('users.index'));
    $response->assertStatus(200);
    $response->assertViewHas('page');

    $pageData = $response->viewData('page');
    expect($pageData['component'])->toBe('Users/Index');
});

test('admin pode criar um novo vendedor válido', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    
    $userData = [
        'name' => 'Novo Vendedor',
        'email' => 'vendedor@teste.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => UserRole::SELLER->value,
        'status' => UserStatus::ACTIVE->value,
    ];

    $response = $this->actingAs($admin)
        ->post(route('users.store'), $userData);

    $response->assertRedirect(route('users.index'));
    
    $this->assertDatabaseHas('users', [
        'email' => 'vendedor@teste.com',
        'role' => UserRole::SELLER->value
    ]);
});

test('não permite criar usuário com e-mail duplicado', function () {
    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    User::factory()->create(['email' => 'duplicado@teste.com']);

    $userData = [
        'name' => 'Outro',
        'email' => 'duplicado@teste.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'role' => UserRole::SELLER->value,
        'status' => UserStatus::ACTIVE->value,
    ];

    $this->actingAs($admin)
        ->post(route('users.store'), $userData)
        ->assertSessionHasErrors('email');
});