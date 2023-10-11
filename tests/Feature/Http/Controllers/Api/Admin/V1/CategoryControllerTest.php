<?php

use App\Actions\Category\OrderedPaginatedCategories;
use App\Http\Resources\Api\Admin\V1\CategoryResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;

test('it should not allow non-admin user to list categories', function() {
    $nonAdminUser = User::factory()->create();

    actingAs($nonAdminUser);

    getJson('/api/admin/v1/categories')
        ->assertForbidden();
});

test('admin user should be able to see category list', function() {
    $user = createAdminUser();

    Category::factory()->count(10)->create();

    actingAs($user);

    $response = getJson('/api/admin/v1/categories')
        ->assertSuccessful();

    $categories = app(OrderedPaginatedCategories::class)->handle();
    $categoriesResource = CategoryResource::collection($categories);

    assertEquals($categoriesResource->response()->getData(true), $response->json());
});

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
        'image' => $file,
        'sort_order' => 5
    ])->assertSuccessful();

    assertCount(1, Category::all());
    assertCount(1, Category::first()->getMedia());
    assertEquals(5, Category::first()->sort_order);
});

test('it should not allow non-admin user to update a category', function() {
    $nonAdminUser = User::factory()->create();
    $category = Category::factory()->create();

    actingAs($nonAdminUser);

    putJson(sprintf("/api/admin/v1/categories/%s", $category->id))->assertForbidden();
});

test('admin user should be able to update category information', function() {
    $user = createAdminUser();
    $category = Category::factory()->create();

    actingAs($user);

    $file = UploadedFile::fake()->image('updated-test-image.jpg');

    putJson(sprintf("/api/admin/v1/categories/%s", $category->id), [
        'name' => 'updated name',
        'description' => 'updated description',
        'short_description' => 'updated short description',
        'image' => $file,
        'sort_order' => 10
    ])->assertSuccessful();

    assertEquals($category->refresh()->name, 'updated name');
    assertEquals($category->refresh()->description, 'updated description');
    assertEquals($category->refresh()->short_description, 'updated short description');
    assertEquals($category->refresh()->getFirstMedia()->name, 'updated-test-image');
    assertEquals($category->refresh()->sort_order, 10);
});

test('it should not allow non-admin user to delete a category', function() {
    $nonAdminUser = User::factory()->create();
    $category = Category::factory()->create();

    actingAs($nonAdminUser);

    deleteJson(sprintf("/api/admin/v1/categories/%s", $category->id))->assertForbidden();
});

test('admin user should be able to delete category', function() {
    $user = createAdminUser();
    $category = Category::factory()->create();

    actingAs($user);

    assertCount(1, Category::all());

    deleteJson(sprintf("/api/admin/v1/categories/%s", $category->id))
        ->assertOk();

    assertCount(0, Category::all());
});


