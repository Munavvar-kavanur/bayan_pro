<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('invoices.edit', $invoice) }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit
                </a>
                <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                    Print PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 print:py-0">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg print:shadow-none print:rounded-none" id="invoice">
                <div class="p-10 text-gray-900 dark:text-gray-100 print:p-8">
                    
                    <!-- Invoice Header -->
                    <div class="flex justify-between items-start border-b border-gray-200 dark:border-gray-700 pb-8 mb-8">
                        <div>
                            @php
                                $logo = \App\Models\Setting::get('invoice_logo') ?? \App\Models\Setting::get('branding_logo');
                            @endphp
                            @if($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="Company Logo" class="h-16 object-contain mb-4">
                            @else
                                <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-4">INVOICE</h1>
                            @endif

                            <div class="flex items-center gap-3 mb-2">
                                @if($logo)
                                    <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight">INVOICE</h1>
                                @endif
                                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full 
                                    @if($invoice->status === 'paid') bg-green-100 text-green-800 border border-green-200
                                    @elseif($invoice->status === 'overdue') bg-red-100 text-red-800 border border-red-200
                                    @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800 border border-blue-200
                                    @else bg-gray-100 text-gray-800 border border-gray-200 @endif">
                                    {{ $invoice->status }}
                                </span>
                            </div>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">#INV-{{ str_pad($invoice->id, 5, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-right">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ \App\Models\Setting::get('company_name', 'Bayan Pro') }}</h2>
                            <div class="text-gray-500 dark:text-gray-400 text-sm mt-1 space-y-1">
                                <p class="whitespace-pre-line">{{ \App\Models\Setting::get('company_address') }}</p>
                                <p>{{ \App\Models\Setting::get('company_email') }}</p>
                                <p>{{ \App\Models\Setting::get('company_phone') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Client & Dates -->
                    <div class="grid grid-cols-2 gap-8 mb-10">
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Bill To</h3>
                            <div class="text-gray-900 dark:text-gray-100">
                                <p class="font-bold text-lg mb-1">{{ $invoice->client->company_name ?? $invoice->client->name }}</p>
                                @if($invoice->client->company_name)
                                    <p class="text-gray-600 dark:text-gray-400">{{ $invoice->client->name }}</p>
                                @endif
                                <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line mt-1 text-sm">{{ $invoice->client->address }}</p>
                                <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">{{ $invoice->client->email }}</p>
                            </div>
                        </div>
                        <div class="text-right space-y-3">
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Issue Date</h3>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->issue_date->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Due Date</h3>
                                <p class="font-medium text-gray-900 dark:text-gray-100">{{ $invoice->due_date->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-10">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700/50">
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider rounded-l-lg">Item Details</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                                    <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider rounded-r-lg">Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($invoice->items as $item)
                                    <tr>
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $item->title }}</p>
                                            @if($item->description)
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 whitespace-pre-line">{{ $item->description }}</p>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-600 dark:text-gray-400">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right text-sm text-gray-600 dark:text-gray-400">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">${{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="font-medium text-gray-900 dark:text-gray-100">${{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between text-sm text-green-600 dark:text-green-400">
                                    <span>Discount <span class="text-xs">({{ $invoice->discount_type === 'percent' ? $invoice->discount_value . '%' : 'Fixed' }})</span></span>
                                    <span>- ${{ number_format($discountAmount, 2) }}</span>
                                </div>
                            @endif

                            @if($taxAmount > 0)
                                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                                    <span>Tax <span class="text-xs">({{ $invoice->tax_rate }}%)</span></span>
                                    <span>${{ number_format($taxAmount, 2) }}</span>
                                </div>
                            @endif

                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3 pb-3 flex justify-between items-center">
                                <span class="text-base font-bold text-gray-900 dark:text-white">Total</span>
                                <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($invoice->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Notes -->
                    @if($invoice->notes)
                        <div class="mt-12 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Notes & Payment Terms</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 italic">{{ $invoice->notes }}</p>
                        </div>
                    @endif
                    
                    <div class="mt-8 text-center text-xs text-gray-400 dark:text-gray-500 print:mt-16">
                        <p>Thank you for your business!</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
