<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
        'invoice_code',
        'shipping_option_id',
        'shipping_code',
        'shipping_status',
        'shipped_at',
        'delivered_at',
        'address',
    ];
    public function items()
{
    return $this->hasMany(TransactionItems::class);
}
    public static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            $datePart = now()->format('Ymd');
            $randomPart = strtoupper(substr(uniqid(), -4));
            $transaction->invoice_code = "INV-{$datePart}-{$randomPart}";
        });

    }
     protected $casts = [
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shippingOption()
    {
        return $this->belongsTo(ShippingOption::class, 'shipping_option_id');
    }

    // Scope untuk status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    public function deleteRecords()
    {
        $this->items()->delete();
        $this->delete();
    }

}
