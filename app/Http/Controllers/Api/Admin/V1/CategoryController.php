<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Actions\Category\OrderedPaginatedCategories;
use App\Actions\Category\StoreCategoryAction;
use App\Actions\Category\UpdateCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\V1\DeleteCategoryRequest;
use App\Http\Requests\Api\Admin\V1\IndexCategoryRequest;
use App\Http\Requests\Api\Admin\V1\ShowCategoryRequest;
use App\Http\Requests\Api\Admin\V1\StoreCategoryRequest;
use App\Http\Requests\Api\Admin\V1\UpdateCategoryRequest;
use App\Http\Resources\Api\Admin\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(
        protected StoreCategoryAction $storeCategoryAction,
        protected UpdateCategoryAction $updateCategoryAction,
        protected OrderedPaginatedCategories $orderedPaginatedCategories,
    )
    {}

    public function index(IndexCategoryRequest $request)
    {
        $categories = $this->orderedPaginatedCategories->handle();

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->storeCategoryAction->handle(
            name: $request->string('name'),
            slug: Str::slug($request->string('name')),
            description: $request->string('description'),
            shortDescription: $request->string('short_description'),
            file: $request->file('image'),
            sortOrder: $request->integer('sort_order', 1),
        );

        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->updateCategoryAction->handle(
            category: $category,
            name: $request->string('name'),
            slug: Str::slug($request->string('name')),
            description: $request->string('description'),
            shortDescription: $request->string('short_description'),
            file: $request->file('image'),
            sortOrder: $request->integer('sort_order', 1),
        );

        return new CategoryResource($category->refresh());
    }

    public function show(ShowCategoryRequest $request, Category $category)
    {
        return new CategoryResource($category);
    }

    public function destroy(DeleteCategoryRequest $request, Category $category)
    {
        $category->delete();
    }
}
