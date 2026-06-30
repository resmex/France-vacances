<?php

namespace App;

use Database\Factories\DestinationsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Destinations extends Model
{
    use HasFactory, SoftDeletes;

    protected static function newFactory()
    {
        return DestinationsFactory::new();
    }

    protected $fillable = [
        'title', 'description', 'content', 'image', 'published_at', 'category_id', 'pricing',
        'duration', 'group_size', 'tour_type',
        // France Vacances property fields
        'property_type', 'location', 'region',
        'bedrooms', 'bathrooms', 'max_guests',
        'amenities', 'featured', 'price_per_night', 'rating_cached',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'amenities'    => 'array',
        'featured'     => 'boolean',
        'price_per_night' => 'decimal:2',
        'rating_cached'   => 'decimal:2',
    ];

    // ── Accessors ──────────────────────────────────────────────

    /** Numeric price for calculations (falls back to price_per_night, then pricing string). */
    public function getPriceAttribute(): int
    {
        if ($this->price_per_night) {
            return (int) $this->price_per_night;
        }
        return (int) preg_replace('/[^\d]/', '', $this->pricing ?? '0');
    }

    /** Formatted GBP display, e.g. "£285/night". */
    public function getPriceDisplayAttribute(): string
    {
        $amount = $this->price_per_night ?? $this->getPriceAttribute();
        return '£' . number_format((float) $amount) . '/night';
    }

    /** Display label for the property type badge. */
    public function getPropertyTypeLabelAttribute(): string
    {
        return $this->property_type ?? $this->tour_type ?? 'Property';
    }

    /** Display label for bedrooms (falls back to duration string for legacy data). */
    public function getBedroomsLabelAttribute(): string
    {
        if ($this->bedrooms) {
            return $this->bedrooms . ' ' . ($this->bedrooms === 1 ? 'Bedroom' : 'Bedrooms');
        }
        return $this->duration ?? '–';
    }

    /** Display label for max guests (falls back to group_size string for legacy data). */
    public function getMaxGuestsLabelAttribute(): string
    {
        if ($this->max_guests) {
            return 'Sleeps ' . $this->max_guests;
        }
        return $this->group_size ?? '–';
    }

    /** Display label for the region. */
    public function getRegionLabelAttribute(): string
    {
        return $this->region ?? ($this->category ? $this->category->name : '–');
    }

    /** Rating to display: cached seed rating first, then calculated from reviews. */
    public function getDisplayRatingAttribute(): ?float
    {
        if ($this->rating_cached) {
            return (float) $this->rating_cached;
        }
        return $this->getAverageRatingAttribute();
    }

    /** Full image URL — handles both public/images and storage paths. */
    public function getImageUrlAttribute(): string
    {
        if (! $this->image) {
            return asset('images/destination-2.jpg');
        }
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        return asset('storage/' . $this->image);
    }

    // ── Image helpers ──────────────────────────────────────────

    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    // ── Relationships ──────────────────────────────────────────

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'destination_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'destination_id');
    }

    // ── Helper ────────────────────────────────────────────────

    public function hasTag($tagId): bool
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }

    // ── Scopes ────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeWithTags($query, array $tagIds)
    {
        return $query->whereHas('tags', function ($q) use ($tagIds) {
            $q->whereIn('tags.id', $tagIds);
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInRegion($query, string $region)
    {
        return $query->where('region', $region);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('property_type', $type);
    }

    // ── Rating helpers ────────────────────────────────────────

    public function getAverageRatingAttribute(): ?float
    {
        try {
            if ($this->relationLoaded('reviews')) {
                return $this->reviews->avg('rating');
            }
            return $this->reviews()->avg('rating');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getReviewsCountAttribute(): int
    {
        try {
            if ($this->relationLoaded('reviews')) {
                return $this->reviews->count();
            }
            return $this->reviews()->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
