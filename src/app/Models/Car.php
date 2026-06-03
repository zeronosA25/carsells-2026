<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'brand',
        'model',
        'year',
        'plate_number',
        'color',
        'transmission',
        'fuel_type',
        'mileage',
        'purchase_price',
        'selling_price',
        'status',
        'description',
        'image',
    ];

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->brand} {$this->model} {$this->year}";
    }
}
