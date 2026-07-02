@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0" style="font-weight:600;">Properties</h5>
    <a href="{{ route('destinations.create') }}" class="btn-admin-accent">Add Property</a>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($destinations->count() > 0)
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Property</th>
                    <th>Region</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($destinations as $dest)
                <tr>
                    <td>{{ $dest->title }}</td>
                    <td>{{ $dest->category->name ?? '—' }}</td>
                    <td>{{ $dest->property_type_label }}</td>
                    <td>{{ $dest->price_display }}</td>
                    <td>
                        @if($dest->trashed())
                            Trashed
                        @elseif($dest->featured)
                            Featured
                        @else
                            Active
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-flex gap-1 justify-content-end">
                            @if($dest->trashed())
                            <form action="{{ route('restore-destinations', $dest->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-admin-sm btn-admin-restore">Restore</button>
                            </form>
                            @else
                            <a href="{{ route('destinations.edit', $dest->id) }}" class="btn-admin-sm btn-admin-edit">Edit</a>
                            <a href="{{ route('desti.show', $dest->id) }}" class="btn-admin-sm btn-admin-edit" target="_blank" title="View on site">View</a>
                            @endif
                            <form action="{{ route('destinations.destroy', $dest->id) }}" method="POST"
                                  onsubmit="return confirm('Delete {{ addslashes($dest->title) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-admin-sm btn-admin-delete">Delete</button>
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
