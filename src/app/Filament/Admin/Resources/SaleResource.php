<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SaleResource\Pages;
use App\Filament\Admin\Resources\SaleResource\RelationManagers;
use App\Models\Sale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Car;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $navigationGroup = 'Car Sales';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Data Transaksi')
                ->schema([
                    TextInput::make('invoice_number')
                        ->label('Nomor Invoice')
                        ->default(fn () => 'INV-' . now()->format('YmdHis'))
                        ->disabled()
                        ->dehydrated()
                        ->required()
                        ->unique(ignoreRecord: true),

                    DatePicker::make('sale_date')
                        ->label('Tanggal Transaksi')
                        ->default(now())
                        ->required(),

                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship('customer', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Select::make('car_id')
            ->label('Mobil')
            ->options(function ($record) {
                return Car::query()
                    ->where(function ($query) use ($record) {
                        $query->where('status', 'available');

                        if ($record) {
                            $query->orWhere('id', $record->car_id);
                        }
                    })
                    ->get()
                    ->mapWithKeys(fn ($car) => [
                        $car->id => "{$car->brand} {$car->model} {$car->year} - Rp " . number_format($car->selling_price, 0, ',', '.')
                    ]);
            })
            ->searchable()
            ->required()
            ->live()
            ->rule(function ($record) {
                return function (string $attribute, $value, \Closure $fail) use ($record) {
                    $car = Car::find($value);

                    if (! $car) {
                        $fail('Mobil tidak ditemukan.');
                        return;
                    }

                    if ($car->status !== 'available' && $record?->car_id !== (int) $value) {
                        $fail('Mobil ini sudah tidak tersedia untuk dijual.');
                    }
                };
            })
            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                $car = Car::find($state);

                if (! $car) {
                    return;
                }

                $set('car_price', $car->selling_price);

                $discount = (float) ($get('discount') ?? 0);
                $set('total_price', $car->selling_price - $discount);
            }),
                ])
                ->columns(2),

            Section::make('Pembayaran')
                ->schema([
                    TextInput::make('car_price')
                        ->label('Harga Mobil')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            $discount = (float) ($get('discount') ?? 0);
                            $set('total_price', (float) $state - $discount);
                        }),

                    TextInput::make('discount')
                        ->label('Diskon')
                        ->numeric()
                        ->prefix('Rp')
                        ->default(0)
                        ->live()
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            $carPrice = (float) ($get('car_price') ?? 0);
                            $set('total_price', $carPrice - (float) $state);
                        }),

                    TextInput::make('total_price')
                        ->label('Total Bayar')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated()
                        ->required(),

                    Select::make('payment_method')
                        ->label('Metode Pembayaran')
                        ->options([
                            'cash' => 'Cash',
                            'credit' => 'Credit',
                            'transfer' => 'Transfer',
                        ])
                        ->default('cash')
                        ->required(),

                    Select::make('payment_status')
                        ->label('Status Pembayaran')
                        ->options([
                            'unpaid' => 'Belum Dibayar',
                            'paid' => 'Lunas',
                            'installment' => 'Cicilan',
                        ])
                        ->default('unpaid')
                        ->required(),

                    Textarea::make('notes')
                        ->label('Catatan')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('invoice_number')
                ->label('Invoice')
                ->searchable()
                ->sortable(),

            TextColumn::make('customer.name')
                ->label('Customer')
                ->searchable()
                ->sortable(),

            TextColumn::make('car.brand')
                ->label('Brand Mobil')
                ->searchable(),

            TextColumn::make('car.model')
                ->label('Model Mobil')
                ->searchable(),

            TextColumn::make('sale_date')
                ->label('Tanggal')
                ->date()
                ->sortable(),

            TextColumn::make('total_price')
                ->label('Total')
                ->money('IDR')
                ->sortable(),

            TextColumn::make('payment_status')
                ->label('Status Bayar')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'paid' => 'success',
                    'installment' => 'warning',
                    'unpaid' => 'danger',
                    default => 'gray',
                }),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('payment_status')
                ->label('Status Pembayaran')
                ->options([
                    'unpaid' => 'Belum Dibayar',
                    'paid' => 'Lunas',
                    'installment' => 'Cicilan',
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
