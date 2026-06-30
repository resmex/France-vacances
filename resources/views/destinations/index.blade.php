@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0" style="font-weight:600;">
        <i class="fas fa-home me-2" style="color:var(--admin-primary)"></i>Holiday Properties
    </h5>
    <a href="{{ route('destinations.create') }}" class="btn-admin-accent">
        <i class="fas fa-plus me-1"></i> Add New Property
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($destinations->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Property</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Beds / Guests</th>
                    <th>Price/Night</th>
                    <th>Featured</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($destinations as $dest)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $dest->image) }}"
                             class="img-thumb" alt="{{ $dest->title }}"
                             style="width:56px;height:40px;object-fit:cover;border-radius:6px;">
                    </td>
                    <td>
                        <strong>{{ $dest->title }}</strong>
                        @if($dest->trashed())
                        <span class="badge bg-danger ms-1" style="font-size:.65rem;">Trashed</span>
                        @endif
                        <div style="font-size:.72rem;color:var(--admin-text-soft);">
                            {{ $dest->category->name ?? '—' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-cat" style="font-size:.72rem;">
                            {{ $dest->property_type_label }}
                        </span>
                    </td>
                    <td style="font-size:.82rem;">{{ $dest->location ?? '—' }}</td>
                    <td style="font-size:.82rem;">
                        {{ $dest->bedrooms ?? '—' }} bed &middot;
                        {{ $dest->max_guests ? 'up to '.$dest->max_guests : '—' }}
                    </td>
                    <td>
                        <strong style="color:var(--admin-primary);">{{ $dest->price_display }}</strong>
                    </td>
                    <td class="text-center">
                        @if($dest->featured)
                        <i class="fas fa-star" style="color:var(--admin-accent);font-size:.9rem;" title="Featured"></i>
                        @else
                        <span class="text-muted" style="font-size:.75rem;">—</span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            @if($dest->trashed())
                            <form action="{{ route('restore-destinations', $dest->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-admin-sm btn-admin-restore">
                                    <i class="fas fa-undo me-1"></i>Restore
                                </button>
                            </form>
                            @else
                            <a href="{{ route('destinations.edit', $dest->id) }}" class="btn-admin-sm btn-admin-edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <a href="{{ route('desti.show', $dest->id) }}" class="btn-admin-sm btn-admin-edit" target="_blank" title="View on site">
                                <i class="fas fa-external-link-alt"></i>
                            </a>
                            @endif
                            <form action="{{ route('destinations.destroy', $dest->id) }}" method="POST"
                                  onsubmit="return confirm('Delete {{ addslashes($dest->title) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-sm btn-admin-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="admin-empty">
            <i class="fas fa-home"></i>
            <h5>No Properties Yet</h5>
            <p>Add your first French holiday property to get started.</p>
            <a href="{{ route('destinations.create') }}" class="btn-admin-primary mt-2">
                <i class="fas fa-plus me-1"></i> Add Property
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
