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
    ) {
        return tap(Category::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'short_description' => $shortDescription
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
