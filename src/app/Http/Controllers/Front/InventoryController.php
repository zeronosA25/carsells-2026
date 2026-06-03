<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $cars = Car::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('plate_number', 'like', "%{$search}%")
                        ->orWhere('year', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->brand, function ($query, $brand) {
                $query->where('brand', $brand);
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $brands = Car::query()
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');

        $totalValue = Car::sum('selling_price');
        $activeReservations = Car::where('status', 'booked')->count();
        $availableUnits = Car::where('status', 'available')->count();

        return view('front.inventory.index', compact(
            'cars',
            'brands',
            'totalValue',
            'activeReservations',
            'availableUnits'
        ));
    }
}
