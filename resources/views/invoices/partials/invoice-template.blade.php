<div class="p-10 text-slate-100 print:p-8 print:text-black">

    <!-- Invoice Header -->
    <div class="flex justify-between items-start border-b border-white/10 print:border-gray-200 pb-8 mb-8">
        <div>
            @php
                $logo = \App\Models\Setting::get('invoice_logo') ?? \App\Models\Setting::get('branding_logo');
            @endphp
            @if($logo)
                <img src="{{ asset('storage/' . $logo) }}" alt="Company Logo" class="h-16 object-contain mb-4">
            @else
                <h1 class="text-4xl font-extrabold text-white print:text-black tracking-tight mb-4">INVOICE
                </h1>
            @endif

            <div class="flex items-center gap-3 mb-2">
                @if($logo)
                    <h1 class="text-4xl font-extrabold text-white print:text-black tracking-tight">INVOICE
                    </h1>
                @endif
                <span
                    class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full 
                    @if($invoice->status === 'paid') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 print:bg-green-100 print:text-green-800 print:border-green-200
                    @elseif($invoice->status === 'overdue') bg-rose-500/10 text-rose-400 border border-rose-500/20 print:bg-red-100 print:text-red-800 print:border-red-200
                    @elseif($invoice->status === 'sent') bg-blue-500/10 text-blue-400 border border-blue-500/20 print:bg-blue-100 print:text-blue-800 print:border-blue-200
                    @else bg-slate-700 text-slate-300 border border-slate-600 print:bg-gray-100 print:text-gray-800 print:border-gray-200 @endif">
                    {{ $invoice->status }}
                </span>
            </div>
            <p class="text-slate-400 print:text-gray-500 font-medium">
                #INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-bold text-white print:text-black">
                {{ \App\Models\Setting::get('company_name', 'Bayan Pro') }}
            </h2>
            <div class="text-slate-400 print:text-gray-500 text-sm mt-1 space-y-1">
                <p class="whitespace-pre-line">{{ \App\Models\Setting::get('company_address') }}</p>
                <p>{{ \App\Models\Setting::get('company_email') }}</p>
                <p>{{ \App\Models\Setting::get('company_phone') }}</p>
            </div>
        </div>
    </div>

    <!-- Client & Dates -->
    <div class="grid grid-cols-2 gap-8 mb-10">
        <div>
            <h3 class="text-xs font-bold text-slate-500 print:text-gray-400 uppercase tracking-widest mb-3">
                Bill To</h3>
            <div class="text-slate-100 print:text-black">
                <p class="font-bold text-lg mb-1">
                    {{ $invoice->client->company_name ?? $invoice->client->name }}
                </p>
                @if($invoice->client->company_name)
                    <p class="text-slate-400 print:text-gray-600">{{ $invoice->client->name }}</p>
                @endif
                <p class="text-slate-400 print:text-gray-600 whitespace-pre-line mt-1 text-sm">
                    {{ $invoice->client->address }}
                </p>
                <p class="text-slate-400 print:text-gray-600 mt-1 text-sm">{{ $invoice->client->email }}
                </p>
            </div>
        </div>
        <div class="text-right space-y-3">
            <div>
                <h3 class="text-xs font-bold text-slate-500 print:text-gray-400 uppercase tracking-widest mb-1">
                    Issue Date</h3>
                <p class="font-medium text-slate-100 print:text-black">
                    {{ $invoice->issue_date->format('F d, Y') }}
                </p>
            </div>
            <div>
                <h3 class="text-xs font-bold text-slate-500 print:text-gray-400 uppercase tracking-widest mb-1">
                    Due Date</h3>
                <p class="font-medium text-slate-100 print:text-black">
                    {{ $invoice->due_date->format('F d, Y') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="mb-10">
        <div class="overflow-hidden rounded-lg border border-white/10 print:border-gray-200">
            <table class="min-w-full divide-y divide-white/10 print:divide-gray-200">
                <thead>
                    <tr class="bg-white/5 print:bg-gray-50">
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-bold text-slate-400 print:text-gray-500 uppercase tracking-wider">
                            Item Details</th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-bold text-slate-400 print:text-gray-500 uppercase tracking-wider">
                            Qty</th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-bold text-slate-400 print:text-gray-500 uppercase tracking-wider">
                            Price</th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-bold text-slate-400 print:text-gray-500 uppercase tracking-wider">
                            Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10 print:divide-gray-200">
                    @foreach($invoice->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-white print:text-black">{{ $item->title }}
                                </p>
                                @if($item->description)
                                    <p class="text-xs text-slate-400 print:text-gray-500 mt-1 whitespace-pre-line">
                                        {{ $item->description }}
                                    </p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-300 print:text-gray-600">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm text-slate-300 print:text-gray-600">
                                {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($item->unit_price, 2) }}
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-semibold text-white print:text-black">
                                {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($item->amount, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Totals Structure -->
    <div class="flex justify-end">
        <div class="w-full sm:w-1/2 lg:w-1/3 space-y-3">
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

            <div class="flex justify-between text-sm">
                <span class="text-slate-400 print:text-gray-600">Subtotal</span>
                <span
                    class="font-medium text-slate-100 print:text-black">{{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($subtotal, 2) }}</span>
            </div>

            @if($discountAmount > 0)
                <div class="flex justify-between text-sm text-emerald-400 print:text-green-600">
                    <span>Discount <span
                            class="text-xs">({{ $invoice->discount_type === 'percent' ? $invoice->discount_value . '%' : 'Fixed' }})</span></span>
                    <span>-
                        {{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($discountAmount, 2) }}</span>
                </div>
            @endif

            @if($taxAmount > 0)
                <div class="flex justify-between text-sm text-slate-400 print:text-gray-600">
                    <span>Tax <span class="text-xs">({{ $invoice->tax_rate }}%)</span></span>
                    <span>{{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($taxAmount, 2) }}</span>
                </div>
            @endif

            <div class="border-t border-white/10 print:border-gray-200 pt-3 pb-3 flex justify-between items-center">
                <span class="text-base font-bold text-white print:text-black">Total</span>
                <span
                    class="text-2xl font-bold text-indigo-400 print:text-indigo-600">{{ \App\Models\Setting::get('currency_symbol', '$') }}{{ number_format($invoice->total_amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Footer Notes -->
    @if($invoice->notes)
        <div class="mt-12 pt-8 border-t border-white/10 print:border-gray-200">
            <h4 class="text-xs font-bold text-slate-500 print:text-gray-400 uppercase tracking-widest mb-2">
                Notes & Payment Terms</h4>
            <p class="text-sm text-slate-400 print:text-gray-600 italic">{{ $invoice->notes }}</p>
        </div>
    @endif

    <div class="mt-8 text-center text-xs text-slate-500 print:text-gray-500 print:mt-16">
        <p>Thank you for your business!</p>
    </div>

</div>