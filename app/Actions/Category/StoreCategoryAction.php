<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Http\UploadedFile;

class StoreCategoryAction
{
    public function handle(
        string $name,
        string $slug,
        string $description = null,
        string $shortDescription = null,
        UploadedFile $file = null,
        int $sortOrder = 1,
    ) {
        return tap(Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'short_description' => $shortDescription,
            'sort_order' => $sortOrder
        ]), function(Category $category) use ($file) {
            if(! $file) {
                return;
            }

            $category
               ->addMedia($file)
                ->toMediaCollection();
        });
    }
}
