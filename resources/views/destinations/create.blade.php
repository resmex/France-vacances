@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet">
@endsection

@section('content')
@php $editing = isset($destinations); @endphp

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0" style="font-weight:600;">
        <i class="fas fa-home me-2" style="color:var(--admin-primary)"></i>
        {{ $editing ? 'Edit Property' : 'Add New Property' }}
    </h5>
    <a href="{{ route('destinations.index') }}" class="btn-admin-outline">
        <i class="fas fa-arrow-left me-1"></i> Back to Properties
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        @include('partials.errors')

        <form action="{{ $editing ? route('destinations.update', $destinations->id) : route('destinations.store') }}"
              method="POST" enctype="multipart/form-data" class="admin-form">
            @csrf
            @if($editing) @method('PUT') @endif

            {{-- ── Section: Core Details ──────────────────────────────────────────── --}}
            <div class="admin-form-section mb-4">
                <div class="admin-form-section-title">
                    <i class="fas fa-info-circle me-2"></i>Core Details
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="title">Property Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="title" id="title"
                           value="{{ old('title', $editing ? $destinations->title : '') }}"
                           placeholder="e.g. Mas des Oliviers" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="description">Short Description <span class="text-danger">*</span></label>
                    <textarea name="description" class="form-control" id="description" rows="3"
                              placeholder="1–2 sentences shown on listing cards" required>{{ old('description', $editing ? $destinations->description : '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="content">Full Description <span class="text-danger">*</span></label>
                    <input id="content" type="hidden" name="content"
                           value="{{ old('content', $editing ? $destinations->content : '') }}">
                    <trix-editor input="content"></trix-editor>
                </div>
            </div>

            {{-- ── Section: Property Details ──────────────────────────────────────── --}}
            <div class="admin-form-section mb-4">
                <div class="admin-form-section-title">
                    <i class="fas fa-house me-2"></i>Property Details
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="property_type">Property Type</label>
                        <select name="property_type" id="property_type" class="form-select">
                            <option value="">— Select Type —</option>
                            @foreach(['Cottage', 'Villa', 'Chalet', 'Apartment', 'Farmhouse', 'Manor'] as $type)
                            <option value="{{ $type }}"
                                {{ old('property_type', $editing ? $destinations->property_type : '') === $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="region">Region <span class="text-danger">*</span></label>
                        <select name="category" id="region" class="form-select">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category', $editing ? $destinations->category_id : '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        <div class="form-text">Maps to a Category (region).</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="location">Specific Location</label>
                        <input type="text" class="form-control" name="location" id="location"
                               value="{{ old('location', $editing ? $destinations->location : '') }}"
                               placeholder="e.g. Gordes, Provence">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="bedrooms">Bedrooms</label>
                        <input type="number" class="form-control" name="bedrooms" id="bedrooms" min="0"
                               value="{{ old('bedrooms', $editing ? $destinations->bedrooms : '') }}"
                               placeholder="3">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="bathrooms">Bathrooms</label>
                        <input type="number" class="form-control" name="bathrooms" id="bathrooms" min="0"
                               value="{{ old('bathrooms', $editing ? $destinations->bathrooms : '') }}"
                               placeholder="2">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="max_guests">Max Guests</label>
                        <input type="number" class="form-control" name="max_guests" id="max_guests" min="1"
                               value="{{ old('max_guests', $editing ? $destinations->max_guests : '') }}"
                               placeholder="6">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold" for="rating_cached">Display Rating</label>
                        <input type="number" class="form-control" name="rating_cached" id="rating_cached"
                               min="0" max="5" step="0.01"
                               value="{{ old('rating_cached', $editing ? $destinations->rating_cached : '') }}"
                               placeholder="4.94">
                        <div class="form-text">Overrides calculated rating.</div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="amenities">Amenities <span class="text-muted fw-normal">(comma-separated)</span></label>
                    <input type="text" class="form-control" name="amenities" id="amenities"
                           value="{{ old('amenities', $editing && $destinations->amenities ? implode(', ', $destinations->amenities) : '') }}"
                           placeholder="Wi-Fi, Parking, Private Pool, Dishwasher, BBQ">
                    <div class="form-text">Enter each amenity separated by a comma. Displayed as a checklist on the property page.</div>
                </div>
            </div>

            {{-- ── Section: Pricing & Publishing ─────────────────────────────────── --}}
            <div class="admin-form-section mb-4">
                <div class="admin-form-section-title">
                    <i class="fas fa-tag me-2"></i>Pricing &amp; Publishing
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="price_per_night">Price Per Night (£) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">£</span>
                            <input type="number" class="form-control" name="price_per_night" id="price_per_night"
                                   min="0" step="0.01"
                                   value="{{ old('price_per_night', $editing ? $destinations->price_per_night : '') }}"
                                   placeholder="285.00">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold" for="published_at">Published At</label>
                        <input type="text" class="form-control flatpickr" name="published_at" id="published_at"
                               value="{{ old('published_at', $editing ? $destinations->published_at : '') }}"
                               placeholder="Select date & time">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold d-block">&nbsp;</label>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="featured" id="featured" value="1"
                                   {{ old('featured', $editing ? $destinations->featured : false) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="featured">
                                <i class="fas fa-star me-1" style="color:var(--admin-accent)"></i> Feature on Homepage
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Section: Image & Tags ──────────────────────────────────────────── --}}
            <div class="admin-form-section mb-4">
                <div class="admin-form-section-title">
                    <i class="fas fa-image me-2"></i>Image &amp; Tags
                </div>

                @if($editing && $destinations->image)
                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Image</label>
                    <div>
                        <img src="{{ asset('storage/' . $destinations->image) }}"
                             alt="{{ $destinations->title }}"
                             class="img-preview"
                             style="max-height:180px;border-radius:10px;object-fit:cover;">
                    </div>
                </div>
                @endif

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="image">
                        {{ $editing ? 'Replace Image' : 'Property Image' }}
                        @if(!$editing)<span class="text-danger">*</span>@endif
                    </label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*"
                           {{ !$editing ? 'required' : '' }}>
                    <div class="form-text">JPEG, PNG or WebP. Min 1200×800px recommended.</div>
                </div>

                @if($tags->count() > 0)
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="tags">Tags</label>
                    <select name="tags[]" id="tags" class="form-select tags-selector" multiple>
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}"
                            @if($editing && $destinations->hasTag($tag->id)) selected @endif
                        >{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn-admin-primary">
                    <i class="fas fa-save me-1"></i>
                    {{ $editing ? 'Update Property' : 'Create Property' }}
                </button>
                <a href="{{ route('destinations.index') }}" class="btn-admin-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
    flatpickr('.flatpickr', { enableTime: true, dateFormat: 'Y-m-d H:i' });
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            $('.tags-selector').select2({ placeholder: 'Select tags…', allowClear: true });
        }
    });
</script>
@endsection
