<?php

namespace App\Actions\Category;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderedPaginatedCategories
{
    public function handle(
        int $perPage = 15,
        string $sortingOrder = 'asc'
    ): LengthAwarePaginator
    {
        return Category::query()
            ->orderBy('sort_order', $sortingOrder)
            ->paginate($perPage);
    }
}
