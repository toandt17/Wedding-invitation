<?php

namespace App\Filament\Resources\WeddingCardResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RsvpsRelationManager extends RelationManager
{
    protected static string $relationship = 'rsvps';

    protected static ?string $title = 'Danh sách khách mời';

    protected static ?string $recordTitleAttribute = 'guest_name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('guest_name')
                    ->label('Tên khách')
                    ->required(),
                Forms\Components\TextInput::make('phone_number')
                    ->label('Số điện thoại')
                    ->tel()
                    ->required(),
                Forms\Components\TextInput::make('number_of_guests')
                    ->label('Số người')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\Toggle::make('is_attending')
                    ->label('Tham dự')
                    ->required(),
                Forms\Components\Textarea::make('message')
                    ->label('Lời nhắn')
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guest_name')
                    ->label('Tên khách')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->label('Số điện thoại')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_guests')
                    ->label('Số người')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_attending')
                    ->label('Tham dự')
                    ->boolean(),
                Tables\Columns\TextColumn::make('message')
                    ->label('Lời nhắn')
                    ->limit(50),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày gửi')
                    ->dateTime()
                    ->sortable(),
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
}
