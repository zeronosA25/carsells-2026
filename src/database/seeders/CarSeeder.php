<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $cars = [
            [
                'brand' => 'Toyota',
                'model' => 'Avanza',
                'year' => 2021,
                'plate_number' => 'B 1234 ABC',
                'color' => 'Silver',
                'transmission' => 'manual',
                'fuel_type' => 'Bensin',
                'mileage' => 25000,
                'purchase_price' => 180000000,
                'selling_price' => 205000000,
                'status' => 'available',
                'description' => 'Mobil keluarga irit dan siap pakai.',
            ],
            [
                'brand' => 'Honda',
                'model' => 'Brio',
                'year' => 2022,
                'plate_number' => 'B 5678 DEF',
                'color' => 'Merah',
                'transmission' => 'automatic',
                'fuel_type' => 'Bensin',
                'mileage' => 15000,
                'purchase_price' => 165000000,
                'selling_price' => 185000000,
                'status' => 'available',
                'description' => 'City car kecil, irit, dan nyaman.',
            ],
            [
                'brand' => 'Mitsubishi',
                'model' => 'Xpander',
                'year' => 2020,
                'plate_number' => 'B 9090 GHI',
                'color' => 'Hitam',
                'transmission' => 'automatic',
                'fuel_type' => 'Bensin',
                'mileage' => 35000,
                'purchase_price' => 210000000,
                'selling_price' => 235000000,
                'status' => 'available',
                'description' => 'MPV nyaman untuk keluarga.',
            ],
        ];

        foreach ($cars as $car) {
            Car::create($car);
        }
    }
}
