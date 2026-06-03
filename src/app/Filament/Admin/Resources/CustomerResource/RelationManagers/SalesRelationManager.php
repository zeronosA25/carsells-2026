<?php

namespace App\Filament\Admin\Resources\CustomerResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SalesRelationManager extends RelationManager
{
    protected static string $relationship = 'sales';

    protected static ?string $title = 'Riwayat Pembelian';

    public function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('invoice_number')
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->searchable(),

                TextColumn::make('car.brand')
                    ->label('Brand Mobil'),

                TextColumn::make('car.model')
                    ->label('Model Mobil'),

                TextColumn::make('sale_date')
                    ->label('Tanggal')
                    ->date(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR'),

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
            ->filters([])
            ->headerActions([])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }
}
