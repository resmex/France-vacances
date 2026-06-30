<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'booking_id', 'payment_id', 'user_email',
        'amount', 'currency', 'reference',
        'method', 'status', 'is_simulated',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'is_simulated' => 'boolean',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getAmountDisplayAttribute(): string
    {
        return '£' . number_format((float) $this->amount);
    }
}
