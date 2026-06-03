<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        $cars = Car::query()
            ->where('status', 'available')
            ->latest()
            ->limit(6)
            ->get();

        return view('front.home', compact('cars'));
    }
}
