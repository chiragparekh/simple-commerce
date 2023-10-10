<?php

use App\Enums\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

uses(
    Tests\TestCase::class,
     Illuminate\Foundation\Testing\RefreshDatabase::class,
)->beforeEach(function() {
    Artisan::call('commerce:setup-role-permission');
})->in('Feature');

function createAdminUser(): User {
    $user = User::factory()->create();
    $user->assignRole(Role::ADMIN->value);

    return $user;
}

