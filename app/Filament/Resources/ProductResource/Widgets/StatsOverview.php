<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Enums\ProductStatus;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Products', Product::count()),
            Card::make('Sold', Product::where('status', ProductStatus::Sold)->count())->description('Total product sold'),
            Card::make('Posted', Product::where('status', ProductStatus::Posted)->count())->description('Total product sent to post'),
        ];
    }
}
