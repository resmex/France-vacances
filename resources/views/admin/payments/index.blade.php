@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0 fw-bold"><i class="fas fa-receipt me-2" style="color:var(--admin-primary)"></i>Payments</h5>
    <div class="admin-stat-card d-inline-flex gap-2 align-items-center px-3 py-2">
        <i class="fas fa-pound-sign" style="color:var(--admin-accent);"></i>
        <div>
            <div style="font-size:.7rem;color:var(--admin-text-light);">Total Revenue</div>
            <div class="fw-bold" style="color:var(--admin-primary);">£{{ number_format($totalRevenue) }}</div>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-body p-0">
        @if($payments->count())
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Guest</th>
                    <th>Property</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $p)
                <tr>
                    <td><span class="font-monospace small">{{ $p->reference ?? $p->payment_id }}</span></td>
                    <td>{{ $p->booking->user->name ?? $p->user_email }}</td>
                    <td>{{ Str::limit($p->booking->destination->title ?? '—', 25) }}</td>
                    <td><strong>{{ $p->amount_display }}</strong></td>
                    <td>
                        {{ ucfirst($p->method ?? 'card') }}
                        @if($p->is_simulated)
                        <span class="badge bg-secondary" style="font-size:.6rem;">demo</span>
                        @endif
                    </td>
                    <td><small>{{ $p->created_at->format('d M Y') }}</small></td>
                    <td><span class="badge bg-success">{{ ucfirst($p->status ?? 'completed') }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-3">{{ $payments->links('pagination::bootstrap-4') }}</div>
        @else
        <div class="p-5 text-center text-muted">
            <i class="fas fa-receipt fa-2x mb-2 opacity-25"></i>
            <p>No payments recorded yet</p>
        </div>
        @endif
    </div>
</div>
@endsection
