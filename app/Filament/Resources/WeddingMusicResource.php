<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingMusicResource\Pages;
use App\Models\WeddingMusic;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WeddingMusicResource extends Resource
{
    protected static ?string $model = WeddingMusic::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

    protected static ?string $navigationLabel = 'Nhạc nền';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Tên bài hát')
                    ->required(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('File nhạc')
                    ->acceptedFileTypes(['audio/mpeg', 'audio/mp3'])
                    ->disk('public')
                    ->directory('wedding-cards/music')
                    ->visibility('public')
                    ->maxSize(5120)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Kích hoạt')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Tên bài hát')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Kích hoạt'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeddingMusic::route('/'),
            'create' => Pages\CreateWeddingMusic::route('/create'),
            'edit' => Pages\EditWeddingMusic::route('/{record}/edit'),
        ];
    }
}
