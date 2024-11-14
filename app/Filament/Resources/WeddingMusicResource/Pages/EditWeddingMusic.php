<?php

namespace App\Filament\Resources\WeddingMusicResource\Pages;

use App\Filament\Resources\WeddingMusicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeddingMusic extends EditRecord
{
    protected static string $resource = WeddingMusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
