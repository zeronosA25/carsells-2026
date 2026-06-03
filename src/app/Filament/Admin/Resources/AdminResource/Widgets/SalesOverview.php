<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SalesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Mobil', Car::count())
                ->description('Semua mobil di inventory')
                ->icon('heroicon-o-truck'),

            Stat::make('Mobil Tersedia', Car::where('status', 'available')->count())
                ->description('Siap dijual')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('Mobil Terjual', Car::where('status', 'sold')->count())
                ->description('Sudah masuk transaksi')
                ->color('danger')
                ->icon('heroicon-o-banknotes'),

            Stat::make('Total Pendapatan', 'Rp ' . number_format(
                Sale::where('payment_status', 'paid')->sum('total_price'),
                0,
                ',',
                '.'
            ))
                ->description('Dari transaksi lunas')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('Total Customer', Customer::count())
                ->description('Data CRM customer')
                ->icon('heroicon-o-users'),

            Stat::make('Total Transaksi', Sale::count())
                ->description('Semua transaksi penjualan')
                ->icon('heroicon-o-document-text'),
        ];
    }
}
