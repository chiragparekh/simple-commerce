<?php

use App\Http\Controllers\Api\Admin\V1\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Admin Routes
Route::group([
    'prefix' => 'admin/v1',
    'as' => 'api.admin.v1.',
    'middleware' => [
        'auth:sanctum'
    ]
], function() {
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
});


