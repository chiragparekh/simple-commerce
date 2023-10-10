<?php

namespace App\Http\Controllers\Api\Admin\V1;

use App\Actions\Category\StoreCategoryAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\V1\StoreCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct(protected StoreCategoryAction $storeCategoryAction)
    {
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->storeCategoryAction->handle(
            name: $request->string('name'),
            slug: Str::slug($request->string('name')),
            description: $request->string('description'),
            shortDescription: $request->string('short_description'),
            file: $request->file('image'),
        );
    }
}
