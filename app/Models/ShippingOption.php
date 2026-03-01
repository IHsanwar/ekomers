<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingOption extends Model
{
    protected $fillable = [
        'name',
        'cost',
        'delivery_type',
        'estimated_delivery_time',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'shipping_option_id');
    }
}
