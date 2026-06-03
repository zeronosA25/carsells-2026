<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    public function run(): void
    {
        $customer = Customer::first();
        $car = Car::where('status', 'available')->first();

        if (! $customer || ! $car) {
            return;
        }

        Sale::create([
            'invoice_number' => 'INV-' . now()->format('YmdHis'),
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'sale_date' => now()->toDateString(),
            'car_price' => $car->selling_price,
            'discount' => 5000000,
            'total_price' => $car->selling_price - 5000000,
            'payment_method' => 'cash',
            'payment_status' => 'paid',
            'notes' => 'Transaksi dummy dari seeder.',
        ]);

        $car->update([
            'status' => 'sold',
        ]);
    }
}
