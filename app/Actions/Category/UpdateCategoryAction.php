<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Http\UploadedFile;

class UpdateCategoryAction
{
    public function handle(
        Category $category,
        string $name,
        string $slug,
        string $description = null,
        string $shortDescription = null,
        UploadedFile $file = null,
        int $sortOrder = 1,
    ) {
        $category->update([
            'name' => $name,
            'slug' => $slug,
            'description' => $description,
            'short_description' => $shortDescription,
            'sort_order' => $sortOrder
        ]);

        $this->handleImageUpload($category, $file);
    }

    private function handleImageUpload(Category $category, UploadedFile $file = null): void
    {
        $category->clearMediaCollection();

        if(! $file) {
            return;
        }

        $category
            ->addMedia($file)
            ->toMediaCollection();
    }
}
