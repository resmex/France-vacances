<?php

namespace App;

use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'about', 'role', 'profile_photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ── Role helpers ────────────────────────────────────────────────────────────
    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isOwner(): bool    { return $this->role === 'owner'; }
    public function isFinance(): bool  { return $this->role === 'finance'; }
    public function isIt(): bool       { return $this->role === 'it'; }
    public function isCustomer(): bool { return $this->role === 'customer'; }

    public function hasRole(string ...$roles): bool
    {
        return in_array($this->role, $roles, true);
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            'admin'   => 'home',
            'owner'   => 'owner.dashboard',
            'finance' => 'finance.dashboard',
            'it'      => 'it.dashboard',
            default   => 'account.dashboard',
        };
    }

    public function roleBadgeClass(): string
    {
        return match ($this->role) {
            'admin'   => 'badge bg-danger',
            'owner'   => 'badge bg-primary',
            'finance' => 'badge bg-success',
            'it'      => 'badge bg-purple text-white',
            default   => 'badge bg-secondary',
        };
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin'   => 'Administrator',
            'owner'   => 'Property Owner',
            'finance' => 'Finance',
            'it'      => 'IT / Technical',
            default   => 'Customer',
        };
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function wishlistedDestinations()
    {
        return $this->belongsToMany(Destinations::class, 'wishlists', 'user_id', 'destination_id')
            ->withTimestamps();
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        return $this->profile_photo ? asset('storage/'.$this->profile_photo) : null;
    }

    public function hasWishlisted(Destinations $destination): bool
    {
        return $this->wishlist()->where('destination_id', $destination->id)->exists();
    }

    public function toggleWishlist(Destinations $destination): bool
    {
        if ($this->hasWishlisted($destination)) {
            $this->wishlist()->where('destination_id', $destination->id)->delete();

            return false;
        }

        $this->wishlist()->create(['destination_id' => $destination->id]);

        return true;
    }
}
