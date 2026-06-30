<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'destination_id',
        'travel_date', 'check_in_date', 'check_out_date', 'nights',
        'guests', 'total_price', 'status', 'notes',
    ];

    protected $casts = [
        'travel_date'    => 'date',
        'check_in_date'  => 'date',
        'check_out_date' => 'date',
        'total_price'    => 'decimal:2',
        'guests'         => 'integer',
        'nights'         => 'integer',
    ];

    // ── Accessors ────────────────────────────────────────────────────────────

    public function getNightsLabelAttribute(): string
    {
        $n = $this->nights ?? 1;
        return $n . ' ' . ($n === 1 ? 'night' : 'nights');
    }

    public function getTotalDisplayAttribute(): string
    {
        return '£' . number_format((float) $this->total_price);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'confirmed'  => 'success',
            'pending'    => 'warning',
            'cancelled'  => 'danger',
            'completed'  => 'info',
            default      => 'secondary',
        };
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destinations::class, 'destination_id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in_date', '>=', now()->toDateString());
    }

    // ── Status helpers ────────────────────────────────────────────────────────

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isConfirmed(): bool { return $this->status === 'confirmed'; }
    public function isCancelled(): bool { return $this->status === 'cancelled'; }
    public function isCompleted(): bool { return $this->status === 'completed'; }
}
