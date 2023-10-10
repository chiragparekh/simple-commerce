<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\postJson;
use function PHPUnit\Framework\assertCount;

test('it should not allow non-admin user to create a category', function() {
    $nonAdminUser = User::factory()->create();

    actingAs($nonAdminUser);

    postJson('/api/admin/v1/categories')
        ->assertForbidden();
});

test('admin user should be able to create category', function() {
    $user = createAdminUser();

    actingAs($user);

    assertCount(0, Category::all());

    $file = UploadedFile::fake()->image('test.jpg');

    postJson('/api/admin/v1/categories', [
        'name' => 'Test category',
        'image' => $file
    ])->assertOk();

    assertCount(1, Category::all());
    assertCount(1, Category::first()->getMedia());
});


