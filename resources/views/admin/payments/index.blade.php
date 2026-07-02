@extends('layouts.app')

@section('content')
<h5 class="mb-3 fw-bold">Payments</h5>

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($payments->count())
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Booking</th>
                    <th>Guest</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $p)
                <tr>
                    <td>{{ Str::limit($p->booking->destination->title ?? '—', 25) }}</td>
                    <td>{{ $p->booking->user->name ?? $p->user_email }}</td>
                    <td>{{ $p->amount_display }}</td>
                    <td>{{ ucfirst($p->method ?? 'card') }}{{ $p->is_simulated ? ' (demo)' : '' }}</td>
                    <td>{{ ucfirst($p->status ?? 'completed') }}</td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $payments->links('pagination::bootstrap-4') }}</div>
        @else
        <div class="p-5 text-center text-muted">
            <p>No payments recorded yet</p>
        </div>
        @endif
    </div>
</div>
@endsection
