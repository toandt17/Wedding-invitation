<?php

namespace App\Filament\Resources\WeddingMusicResource\Pages;

use App\Filament\Resources\WeddingMusicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeddingMusic extends ListRecords
{
    protected static string $resource = WeddingMusicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
