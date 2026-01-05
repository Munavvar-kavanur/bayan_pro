<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #333;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            line-height: 24px;
        }

        .invoice-header {
            margin-bottom: 20px;
        }

        .invoice-header table {
            width: 100%;
        }

        .invoice-header td {
            vertical-align: top;
        }

        .invoice-header td.title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
        }

        .invoice-header td.title img {
            height: 60px;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: bold;
            color: #fff;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .status-paid {
            background-color: #10b981;
        }

        .status-overdue {
            background-color: #f43f5e;
        }

        .status-sent {
            background-color: #3b82f6;
        }

        .status-default {
            background-color: #64748b;
        }

        .client-info table {
            width: 100%;
            margin-bottom: 20px;
        }

        .heading {
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .heading td {
            padding: 10px;
        }

        .item {
            border-bottom: 1px solid #eee;
        }

        .item td {
            padding: 10px;
        }

        .text-right {
            text-align: right;
        }

        .total-section {
            width: 100%;
            margin-top: 20px;
        }

        .total-section td {
            padding: 5px 10px;
        }

        .notes {
            margin-top: 30px;
            font-style: italic;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <div class="invoice-header">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="title">
                        @php
                            $logo = \App\Models\Setting::get('invoice_logo') ?? \App\Models\Setting::get('branding_logo');
                        @endphp
                        @if($logo)
                            <img src="{{ public_path('storage/' . $logo) }}" alt="Logo">
                        @else
                            INVOICE
                        @endif
                        <br>
                        <span
                            style="font-size: 14px; color: #777; font-weight: normal;">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="text-right">
                        <strong>{{ \App\Models\Setting::get('company_name', 'Bayan Pro') }}</strong><br>
                        {!! nl2br(\App\Models\Setting::get('company_address')) !!}<br>
                        {{ \App\Models\Setting::get('company_email') }}<br>
                        {{ \App\Models\Setting::get('company_phone') }}
                        <br><br>
                        <span class="status-badge status-{{ $invoice->status }}">
                            {{ ucfirst($invoice->status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="client-info">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <strong>Bill To:</strong><br>
                        {{ $invoice->client->company_name ?? $invoice->client->name }}<br>
                        @if($invoice->client->company_name)
                            {{ $invoice->client->name }}<br>
                        @endif
                        {!! nl2br($invoice->client->address) !!}<br>
                        {{ $invoice->client->email }}
                    </td>
                    <td class="text-right">
                        <strong>Issue Date:</strong> {{ $invoice->issue_date->format('F d, Y') }}<br>
                        <strong>Due Date:</strong> {{ $invoice->due_date->format('F d, Y') }}
                    </td>
                </tr>
            </table>
        </div>

        <table cellpadding="0" cellspacing="0" style="width: 100%;">
            <tr class="heading">
                <td>Item Details</td>
                <td class="text-right">Qty</td>
                <td class="text-right">Price</td>
                <td class="text-right">Amount</td>
            </tr>

            @foreach($invoice->items as $item)
                <tr class="item">
                    <td>
                        <b>{{ $item->title }}</b>
                        @if($item->description)
                            <br><span style="font-size: 12px; color: #777;">{!! nl2br($item->description) !!}</span>
                        @endif
                    </td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">
                        {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($item->unit_price, 2) }}</td>
                    <td class="text-right">
                        {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($item->amount, 2) }}</td>
                </tr>
            @endforeach
        </table>

        <div class="total-section">
            <table cellpadding="0" cellspacing="0" align="right" style="width: 40%; margin-left: auto;">
                @php
                    $subtotal = $invoice->items->sum('amount');
                    $discountAmount = 0;
                    if ($invoice->discount_type === 'fixed') {
                        $discountAmount = $invoice->discount_value;
                    } else {
                        $discountAmount = $subtotal * ($invoice->discount_value / 100);
                    }
                    $taxable = max(0, $subtotal - $discountAmount);
                    $taxAmount = $taxable * ($invoice->tax_rate / 100);
                @endphp

                <tr>
                    <td>Subtotal</td>
                    <td class="text-right">
                        {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($subtotal, 2) }}</td>
                </tr>

                @if($discountAmount > 0)
                    <tr style="color: #10b981;">
                        <td>Discount
                            ({{ $invoice->discount_type === 'percent' ? $invoice->discount_value . '%' : 'Fixed' }})</td>
                        <td class="text-right">-
                            {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($discountAmount, 2) }}
                        </td>
                    </tr>
                @endif

                @if($taxAmount > 0)
                    <tr>
                        <td>Tax ({{ $invoice->tax_rate }}%)</td>
                        <td class="text-right">
                            {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($taxAmount, 2) }}</td>
                    </tr>
                @endif

                <tr style="border-top: 2px solid #333; font-weight: bold; font-size: 16px;">
                    <td style="padding-top: 10px;">Total</td>
                    <td class="text-right" style="padding-top: 10px; color: #6366f1;">
                        {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($invoice->total_amount, 2) }}
                    </td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>

        @if($invoice->notes)
            <div class="notes">
                <strong>Notes & Payment Terms</strong><br>
                {{ $invoice->notes }}
            </div>
        @endif

        <div style="text-align: center; margin-top: 50px; font-size: 12px; color: #999;">
            Thank you for your business!
        </div>
    </div>
</body>

</html>