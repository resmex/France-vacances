<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed — France Vacances</title>
    <style>
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background:#f8f5ef; margin:0; padding:0; color:#1f2937; }
        .wrapper { max-width:600px; margin:40px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,.08); }
        .header { background:#082B4C; padding:32px 40px; text-align:center; }
        .header h1 { color:#fff; margin:0; font-size:22px; font-weight:700; letter-spacing:-.3px; }
        .header p { color:#D4AF37; margin:4px 0 0; font-size:13px; }
        .confirmed-banner { background:#22c55e; color:#fff; text-align:center; padding:16px; font-weight:700; font-size:16px; }
        .body { padding:32px 40px; }
        .ref-badge { background:#f8f5ef; border:1px solid #e5e7eb; border-radius:8px; padding:12px 20px; text-align:center; margin-bottom:24px; }
        .ref-badge .label { font-size:11px; text-transform:uppercase; letter-spacing:.08em; color:#6b7280; }
        .ref-badge .value { font-size:20px; font-weight:700; color:#082B4C; font-family:monospace; }
        .prop-card { border:1px solid #e5e7eb; border-radius:10px; overflow:hidden; margin-bottom:24px; }
        .prop-card .prop-body { padding:16px 20px; }
        .prop-card h2 { margin:0 0 4px; font-size:16px; font-weight:700; color:#082B4C; }
        .prop-card .location { color:#6b7280; font-size:13px; margin:0 0 12px; }
        .detail-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
        .detail-item { background:#f8f5ef; border-radius:6px; padding:10px 12px; }
        .detail-item .label { font-size:10px; text-transform:uppercase; letter-spacing:.06em; color:#9ca3af; margin-bottom:2px; }
        .detail-item .value { font-weight:600; font-size:14px; color:#1f2937; }
        .total-row { background:#082B4C; border-radius:8px; padding:14px 20px; display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; }
        .total-row .label { color:#d1d5db; font-size:13px; }
        .total-row .value { color:#D4AF37; font-size:20px; font-weight:700; }
        .next-steps { background:#f8f5ef; border-radius:8px; padding:20px; margin-bottom:24px; }
        .next-steps h3 { font-size:14px; font-weight:700; color:#082B4C; margin:0 0 12px; }
        .step { display:flex; gap:12px; margin-bottom:10px; font-size:13px; color:#374151; }
        .step .num { min-width:22px; height:22px; background:#082B4C; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; }
        .footer { background:#f8f5ef; padding:24px 40px; text-align:center; border-top:1px solid #e5e7eb; }
        .footer p { margin:4px 0; font-size:12px; color:#9ca3af; }
        .footer a { color:#082B4C; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🏡 France Vacances</h1>
        <p>Holiday Homes in France</p>
    </div>

    <div class="confirmed-banner">
        ✓ &nbsp; Your Booking is Confirmed
    </div>

    <div class="body">
        <p>Dear {{ $booking->user->name ?? 'Guest' }},</p>
        <p>Thank you for booking with France Vacances. Your holiday is secured and we're looking forward to welcoming you.</p>

        <div class="ref-badge">
            <div class="label">Booking Reference</div>
            <div class="value">{{ $booking->payment->reference ?? 'FV-' . $booking->id }}</div>
        </div>

        <div class="prop-card">
            <div class="prop-body">
                <h2>{{ $booking->destination->title }}</h2>
                <p class="location">📍 {{ $booking->destination->location ?? $booking->destination->region_label }}</p>
                <div class="detail-grid">
                    <div class="detail-item">
                        <div class="label">Check-in</div>
                        <div class="value">{{ $booking->check_in_date->format('D d M Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Check-out</div>
                        <div class="value">{{ $booking->check_out_date->format('D d M Y') }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Duration</div>
                        <div class="value">{{ $booking->nights_label }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="label">Guests</div>
                        <div class="value">{{ $booking->guests }} {{ Str::plural('Guest', $booking->guests) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="total-row">
            <span class="label">Total Paid (GBP)</span>
            <span class="value">{{ $booking->total_display }}</span>
        </div>

        <div class="next-steps">
            <h3>What Happens Next</h3>
            <div class="step"><div class="num">1</div><span>We'll send your property information pack and arrival details 2 weeks before check-in.</span></div>
            <div class="step"><div class="num">2</div><span>Keep this email safe — your reference number is <strong>{{ $booking->payment->reference ?? 'FV-' . $booking->id }}</strong>.</span></div>
            <div class="step"><div class="num">3</div><span>Our UK team is available Mon–Fri 9AM–5:30PM on +44 20 7946 0123 if you have any questions.</span></div>
        </div>

        <p style="font-size:13px;color:#6b7280;">This booking is ABTA protected. In the unlikely event of any issues, you are financially protected. Full details are available on our website.</p>
    </div>

    <div class="footer">
        <p><strong>France Vacances Ltd</strong> &nbsp;·&nbsp; 12 Regent Street, London W1B 5JG</p>
        <p>+44 20 7946 0123 &nbsp;·&nbsp; <a href="mailto:info@francevacances.co.uk">info@francevacances.co.uk</a></p>
        <p style="margin-top:8px;">ABTA Protected &nbsp;·&nbsp; Company No. 12345678 (England &amp; Wales)</p>
        <p style="margin-top:4px;font-size:11px;">This is a demonstration system. No real payment has been processed.</p>
    </div>
</div>
</body>
</html>
