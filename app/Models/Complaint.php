<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'reason_category',
        'description',
        'evidence_images',
        'status',
        'action_type',
        'refund_method',
        'refund_account',
        'contact_number',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
