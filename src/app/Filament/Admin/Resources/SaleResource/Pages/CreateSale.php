<?php

namespace App\Filament\Admin\Resources\SaleResource\Pages;

use App\Filament\Admin\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSale extends CreateRecord
{
    protected static string $resource = SaleResource::class;

    protected function afterCreate(): void
    {
        $this->record->car?->update([
            'status' => 'sold',
        ]);
    }
}
