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
                        Forms\Components\TextInput::make('couple_email')
                            ->label('Email cặp đôi')
                            ->email()
                            ->required()
                            ->helperText('Email này sẽ dùng để xem dữ liệu khách mời trong Google Sheet'),
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
                            ->label('Ngày cưới (Dương lịch)')
                            ->required(),
                        Forms\Components\DateTimePicker::make('lunar_wedding_date')
                            ->label('Ngày cưới (Âm lịch)')
                            ->required(),
                        Forms\Components\TimePicker::make('party_time')
                            ->label('Giờ tiệc cưới')
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
                        Forms\Components\Textarea::make('google_map')
                            ->label('Google Map')
                            ->helperText('Dán link Google Map vào đây'),
                    ])->columns(2),

                Forms\Components\Section::make('Thông tin thanh toán')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Giá thiệp')
                            ->numeric()
                            ->prefix('VND'),
                        Forms\Components\Toggle::make('is_free')
                            ->label('Miễn phí'),
                        Forms\Components\Toggle::make('is_hot')
                            ->label('Nổi bật'),
                        Forms\Components\TextInput::make('bank_account_name')
                            ->label('Tên chủ tài khoản'),
                        Forms\Components\TextInput::make('bank_account_number')
                            ->label('Số tài khoản'),
                        Forms\Components\TextInput::make('bank_name')
                            ->label('Tên ngân hàng'),
                    ])->columns(2),

                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('seo_title')
                            ->label('Tiêu đề SEO')
                            ->maxLength(60),
                        Forms\Components\Textarea::make('seo_description')
                            ->label('Mô tả SEO')
                            ->maxLength(160),
                        Forms\Components\FileUpload::make('seo_image')
                            ->label('Ảnh SEO')
                            ->image()
                            ->disk('public')
                            ->directory('wedding-cards/seo')
                            ->visibility('public'),
                    ]),

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
                Tables\Columns\TextColumn::make('couple_email')
                    ->label('Email cặp đôi')
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
                Tables\Columns\TextColumn::make('price')
                    ->label('Giá')
                    ->money('VND')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_free')
                    ->label('Miễn phí')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_hot')
                    ->label('Nổi bật')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_free')
                    ->label('Miễn phí')
                    ->options([
                        1 => 'Miễn phí',
                        0 => 'Có phí',
                    ]),
                Tables\Filters\SelectFilter::make('is_hot')
                    ->label('Nổi bật')
                    ->options([
                        1 => 'Nổi bật',
                        0 => 'Bình thường',
                    ]),
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
