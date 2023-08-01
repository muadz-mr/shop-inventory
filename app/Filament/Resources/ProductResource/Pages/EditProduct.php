<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Enums\ProductStatus;
use App\Filament\Resources\ProductResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    // protected static string $view = 'filament.resources.products.pages.edit-product';

    protected function getSavedNotificationMessage(): ?string
    {
        return 'Product updated';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->before(function () {
                    // execute code before a record is deleted
                })
                ->after(function () {
                    // execute code after a record is deleted
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $oldAttachments = $record->attachments;
        $newAttachments = $data['attachments'];

        $record->update($data);

        if ($record) {
            if ($oldAttachments && count($oldAttachments) > 0) {
                if ($newAttachments && count($newAttachments) > 0) {
                    foreach ($oldAttachments as $key => $oldAttachment) {
                        $paths = Arr::where($newAttachments, function ($value, $key) use ($oldAttachment) {
                            return $oldAttachment != $value;
                        });

                        if ($paths) Storage::disk('public')->delete($oldAttachment);
                    }
                } else {
                    Storage::disk('public')->delete($oldAttachments);
                }
            }
        }

        return $record;
    }
}
