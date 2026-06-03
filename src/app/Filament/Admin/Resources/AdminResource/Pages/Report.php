<?php

namespace App\Filament\Admin\Pages;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class Report extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?string $navigationLabel = 'Report';

    protected static ?string $navigationGroup = 'Car Sales';

    protected static ?string $title = 'Report Penjualan';

    protected static string $view = 'filament.admin.pages.report';

    public ?string $startDate = null;

    public ?string $endDate = null;

    public function mount(): void
    {
        $this->startDate = now()->startOfMonth()->toDateString();
        $this->endDate = now()->endOfMonth()->toDateString();
    }

    protected function salesQuery(): Builder
    {
        return Sale::query()
            ->when($this->startDate, function ($query) {
                $query->whereDate('sale_date', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                $query->whereDate('sale_date', '<=', $this->endDate);
            });
    }

    public function getStats(): array
    {
        return [
            'total_cars' => Car::count(),
            'available_cars' => Car::where('status', 'available')->count(),
            'sold_cars' => Car::where('status', 'sold')->count(),
            'booked_cars' => Car::where('status', 'booked')->count(),

            'total_customers' => Customer::count(),
            'total_sales' => $this->salesQuery()->count(),
            'total_revenue' => $this->salesQuery()
                ->where('payment_status', 'paid')
                ->sum('total_price'),
            'pending_payment' => $this->salesQuery()
                ->whereIn('payment_status', ['unpaid', 'installment'])
                ->sum('total_price'),
        ];
    }

    public function getLatestSales()
    {
        return $this->salesQuery()
            ->with(['customer', 'car'])
            ->latest()
            ->limit(10)
            ->get();
    }
}
