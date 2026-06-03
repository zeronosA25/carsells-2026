<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'phone' => '081234567890',
                'identity_number' => '3171010101010001',
                'address' => 'Jakarta',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'phone' => '082345678901',
                'identity_number' => '3171010101010002',
                'address' => 'Tangerang',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@example.com',
                'phone' => '083456789012',
                'identity_number' => '3171010101010003',
                'address' => 'Bekasi',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
