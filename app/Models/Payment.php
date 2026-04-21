<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'tenancy_id',
        'amount',
        'phone',
        'status',
        'merchant_request_id',
        'checkout_request_id',
        'mpesa_receipt',
        'failure_reason',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'amount'  => 'decimal:2',
    ];

    protected $hidden = [
        'merchant_request_id',
    ];

    public function tenancy()
    {
        return $this->belongsTo(Tenancy::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    public function receipt()
{
    return $this->hasOne(Receipt::class);
}

public static function expireStale(): void
{
    self::where('status', 'pending')
        ->where('created_at', '<', now()->subMinutes(30))
        ->update([
            'status'         => 'failed',
            'failure_reason' => 'Payment expired — no response received.',
        ]);
}

}
