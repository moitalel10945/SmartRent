<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'payment_id',
        'receipt_number',
        'amount',
        'mpesa_receipt',
        'phone',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
        'amount'       => 'decimal:2',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}