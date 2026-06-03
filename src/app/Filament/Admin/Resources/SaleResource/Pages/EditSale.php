<?php

namespace App\Filament\Admin\Resources\SaleResource\Pages;

use App\Filament\Admin\Resources\SaleResource;
use App\Models\Car;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSale extends EditRecord
{
    protected static string $resource = SaleResource::class;

    protected ?int $oldCarId = null;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->after(function () {
                    $this->record->car?->update([
                        'status' => 'available',
                    ]);
                }),
        ];
    }

    protected function beforeSave(): void
    {
        $this->oldCarId = $this->record->getOriginal('car_id');
    }

    protected function afterSave(): void
    {
        if ($this->oldCarId && $this->oldCarId !== $this->record->car_id) {
            Car::where('id', $this->oldCarId)
                ->where('status', 'sold')
                ->update([
                    'status' => 'available',
                ]);
        }

        $this->record->car?->update([
            'status' => 'sold',
        ]);
    }
}
