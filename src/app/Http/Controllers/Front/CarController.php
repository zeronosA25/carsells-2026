<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Car;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::query()
            ->where('status', 'available')
            ->latest()
            ->paginate(9);

        return view('front.cars.index', compact('cars'));
    }

    public function show(Car $car)
    {
        abort_if($car->status !== 'available', 404);

        return view('front.cars.show', compact('car'));
    }
}
