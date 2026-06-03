<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSold = Car::where('status', 'sold')->count();

        $totalRevenue = Sale::where('payment_status', 'paid')
            ->sum('total_price');

        $availableCars = Car::where('status', 'available')
            ->latest()
            ->limit(4)
            ->get();

        $latestSales = Sale::with(['customer', 'car'])
            ->latest()
            ->limit(5)
            ->get();

        return view('front.dashboard.index', compact(
            'totalSold',
            'totalRevenue',
            'availableCars',
            'latestSales'
        ));
    }
}
