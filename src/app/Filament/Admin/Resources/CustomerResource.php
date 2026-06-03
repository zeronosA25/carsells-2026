<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CustomerResource\Pages;
use App\Filament\Admin\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Admin\Resources\CustomerResource\RelationManagers\SalesRelationManager;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'CRM Customer';

    protected static ?string $navigationGroup = 'Car Sales';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('name')
                ->label('Nama Customer')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->maxLength(255),

            TextInput::make('phone')
                ->label('Nomor HP')
                ->tel()
                ->maxLength(255),

            TextInput::make('identity_number')
                ->label('NIK / Nomor Identitas')
                ->maxLength(255),

            Textarea::make('address')
                ->label('Alamat')
                ->rows(4)
                ->columnSpanFull(),
        ])
        ->columns(2);
}

public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            TextColumn::make('email')
                ->label('Email')
                ->searchable(),

            TextColumn::make('phone')
                ->label('Nomor HP')
                ->searchable(),

            TextColumn::make('sales_count')
                ->label('Total Pembelian')
                ->counts('sales'),

            TextColumn::make('created_at')
                ->label('Dibuat')
                ->dateTime()
                ->sortable(),
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
            SalesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
