<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'Product created';
    }
}
