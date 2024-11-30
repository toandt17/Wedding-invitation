<?php

namespace App\Filament\Resources\WeddingCardResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Illuminate\Support\Collection;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Album ảnh';

    protected static ?string $recordTitleAttribute = 'image_path';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Loại ảnh')
                    ->options([
                        'gallery' => 'Album ảnh',
                        'featured' => 'Ảnh nổi bật',
                        'cover' => 'Ảnh bìa',
                        'bride' => 'Ảnh cô dâu',
                        'groom' => 'Ảnh chú rể',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Hình ảnh')
                    ->image()
                    ->disk('public')
                    ->directory('wedding-cards/photos')
                    ->visibility('public')
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->label('Mô tả')
                    ->maxLength(500),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Thứ tự')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Hình ảnh'),
                Tables\Columns\SelectColumn::make('type')
                    ->label('Loại ảnh')
                    ->options([
                        'gallery' => 'Album ảnh',
                        'featured' => 'Ảnh nổi bật',
                        'cover' => 'Ảnh bìa',
                        'bride' => 'Ảnh cô dâu',
                        'groom' => 'Ảnh chú rể',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Thứ tự')
                    ->sortable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Thêm ảnh'),
                Tables\Actions\Action::make('uploadMultiple')
                    ->label('Upload nhiều ảnh')
                    ->form([
                        Forms\Components\FileUpload::make('images')
                            ->label('Chọn ảnh')
                            ->multiple()
                            ->image()
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->label('Loại')
                            ->options([
                                'gallery' => 'Album ảnh',
                                'featured' => 'Ảnh nổi bật',
                            ])
                            ->required()
                            ->default('gallery'),
                    ])
                    ->action(function (array $data) {
                        $images = collect($data['images']);
                        $order = $this->getOwnerRecord()->photos()->max('sort_order') ?? 0;

                        $images->each(function ($image) use (&$order, $data) {
                            $order++;
                            $this->getOwnerRecord()->photos()->create([
                                'image_path' => $image,
                                'type' => $data['type'],
                                'sort_order' => $order,
                            ]);
                        });
                    }),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
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
}
