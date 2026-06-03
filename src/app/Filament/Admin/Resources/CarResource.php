<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CarResource\Pages;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Inventory';

    protected static ?string $navigationGroup = 'Car Sales';

    protected static ?string $modelLabel = 'Mobil';

    protected static ?string $pluralModelLabel = 'Inventory Mobil';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Mobil')
                    ->schema([
                        Forms\Components\TextInput::make('brand')
                            ->label('Brand')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('model')
                            ->label('Model')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('year')
                            ->label('Tahun')
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('plate_number')
                            ->label('Nomor Plat')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('color')
                            ->label('Warna')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Spesifikasi')
                    ->schema([
                        Forms\Components\Select::make('transmission')
                            ->label('Transmisi')
                            ->options([
                                'manual' => 'Manual',
                                'automatic' => 'Automatic',
                            ])
                            ->default('manual')
                            ->required(),

                        Forms\Components\TextInput::make('fuel_type')
                            ->label('Bahan Bakar')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('mileage')
                            ->label('Kilometer')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'available' => 'Available',
                                'booked' => 'Booked',
                                'sold' => 'Sold',
                            ])
                            ->default('available')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Harga')
                    ->schema([
                        Forms\Components\TextInput::make('purchase_price')
                            ->label('Harga Beli')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required(),

                        Forms\Components\TextInput::make('selling_price')
                            ->label('Harga Jual')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Foto dan Deskripsi')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Foto Mobil')
                            ->image()
                            ->disk('public')
                            ->directory('cars')
                            ->imageEditor(),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),

                Tables\Columns\TextColumn::make('brand')
                    ->label('Brand')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('model')
                    ->label('Model')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),

                Tables\Columns\TextColumn::make('plate_number')
                    ->label('Plat Nomor')
                    ->searchable(),

                Tables\Columns\TextColumn::make('transmission')
                    ->label('Transmisi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'manual' => 'gray',
                        'automatic' => 'info',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('selling_price')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'available' => 'success',
                        'booked' => 'warning',
                        'sold' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'booked' => 'Booked',
                        'sold' => 'Sold',
                    ]),

                Tables\Filters\SelectFilter::make('transmission')
                    ->label('Transmisi')
                    ->options([
                        'manual' => 'Manual',
                        'automatic' => 'Automatic',
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
