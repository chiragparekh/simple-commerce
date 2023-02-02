<?php

namespace App\Http\Livewire\Products;

use App\Models\Product;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ListProducts extends Component implements HasTable
{
    use InteractsWithTable;

    public function render()
    {
        return view('livewire.products.list-products');
    }

    protected function getTableQuery(): Builder
    {
        return Product::query();
    }

    protected function getTableColumns(): array
    {
        return [
            // Tables\Columns\ImageColumn::make('author.avatar')
            //     ->size(40)
            //     ->circular(),
            // Spatiemedia::make('image'),
            SpatieMediaLibraryImageColumn::make('avatar'),
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('price'),
            // Tables\Columns\TextColumn::make('author.name'),
            // Tables\Columns\BadgeColumn::make('status')
            //     ->colors([
            //         'danger' => 'draft',
            //         'warning' => 'reviewing',
            //         'success' => 'published',
            //     ]),
            // Tables\Columns\IconColumn::make('is_featured')->boolean(),
        ];
    }
}
