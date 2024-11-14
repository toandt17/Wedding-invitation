<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WeddingCardResource\Pages;
use App\Filament\Resources\WeddingCardResource\RelationManagers\PhotosRelationManager;
use App\Filament\Resources\WeddingCardResource\RelationManagers\RsvpsRelationManager;
use App\Models\WeddingCard;
use App\Services\WeddingTemplates\TemplateRegistry;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WeddingCardResource extends Resource
{
    protected static ?string $model = WeddingCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationLabel = 'Thiệp cưới';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Thông tin cơ bản')
                    ->schema([
                        Forms\Components\Select::make('template_id')
                            ->label('Mẫu thiệp')
                            ->options(TemplateRegistry::getAllTemplates())
                            ->required(),
                        Forms\Components\TextInput::make('slug')
                            ->label('Đường dẫn')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->helperText('Ví dụ: hauvami, toanvahoa'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Kích hoạt')
                            ->default(true),
                    ])->columns(3),

                Forms\Components\Section::make('Thông tin cô dâu chú rể')
                    ->schema([
                        Forms\Components\TextInput::make('groom_name')
                            ->label('Tên chú rể')
                            ->required(),
                        Forms\Components\TextInput::make('bride_name')
                            ->label('Tên cô dâu')
                            ->required(),
                        Forms\Components\TextInput::make('groom_father_name')
                            ->label('Tên bố chú rể')
                            ->required(),
                        Forms\Components\TextInput::make('groom_mother_name')
                            ->label('Tên mẹ chú rể')
                            ->required(),
                        Forms\Components\TextInput::make('bride_father_name')
                            ->label('Tên bố cô dâu')
                            ->required(),
                        Forms\Components\TextInput::make('bride_mother_name')
                            ->label('Tên mẹ cô dâu')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Hình ảnh')
                    ->schema([
                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Ảnh bìa')
                            ->image()
                            ->disk('public')
                            ->directory('wedding-cards/covers')
                            ->visibility('public')
                            ->required(),
                        Forms\Components\FileUpload::make('groom_image')
                            ->label('Ảnh chú rể')
                            ->image()
                            ->disk('public')
                            ->directory('wedding-cards/grooms')
                            ->visibility('public')
                            ->required(),
                        Forms\Components\FileUpload::make('bride_image')
                            ->label('Ảnh cô dâu')
                            ->image()
                            ->disk('public')
                            ->directory('wedding-cards/brides')
                            ->visibility('public')
                            ->required(),
                    ])->columns(3),

                Forms\Components\Section::make('Thông tin tiệc cưới')
                    ->schema([
                        Forms\Components\DateTimePicker::make('wedding_date')
                            ->label('Thời gian')
                            ->required(),
                        Forms\Components\TextInput::make('venue_name')
                            ->label('Tên địa điểm')
                            ->required(),
                        Forms\Components\Textarea::make('venue_address')
                            ->label('Địa chỉ')
                            ->required(),
                        Forms\Components\Textarea::make('google_map_iframe')
                            ->label('Google Map Iframe')
                            ->helperText('Dán mã nhúng Google Map vào đây'),
                    ])->columns(2),

                Forms\Components\Section::make('Nội dung khác')
                    ->schema([
                        Forms\Components\Textarea::make('wedding_poem')
                            ->label('Câu thơ/Lời chúc')
                            ->rows(4),
                        Forms\Components\FileUpload::make('qr_code')
                            ->label('Mã QR')
                            ->image(),
                        Forms\Components\Select::make('wedding_music_id')
                            ->label('Nhạc nền')
                            ->relationship('music', 'name')
                            ->preload()
                            ->searchable()
                            ->options(function () {
                                return \App\Models\WeddingMusic::where('is_active', true)
                                    ->pluck('name', 'id');
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->label('Đường dẫn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('groom_name')
                    ->label('Chú rể')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bride_name')
                    ->label('Cô dâu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wedding_date')
                    ->label('Ngày cưới')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Kích hoạt'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
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

    public static function getRelations(): array
    {
        return [
            PhotosRelationManager::class,
            RsvpsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWeddingCards::route('/'),
            'create' => Pages\CreateWeddingCard::route('/create'),
            'edit' => Pages\EditWeddingCard::route('/{record}/edit'),
        ];
    }
}
