<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_number',
        'customer_id',
        'car_id',
        'sale_date',
        'car_price',
        'discount',
        'total_price',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'car_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
