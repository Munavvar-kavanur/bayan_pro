<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Quotation Details') }} #{{ $quotation->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden rounded-xl p-8">
                <div class="text-slate-100">

                    <!-- Header Info -->
                    <div class="flex justify-between items-start mb-8 border-b border-white/10 pb-6">
                        <div>
                            @php
                                $logo = \App\Models\Setting::get('quotation_logo') ?? \App\Models\Setting::get('branding_logo');
                            @endphp
                            @if($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="Company Logo"
                                    class="h-16 object-contain mb-4">
                            @else
                                <h1 class="text-3xl font-bold text-white mb-2">QUOTATION</h1>
                            @endif

                            <div class="flex items-center gap-3 mb-4">
                                @if($logo)
                                    <h1 class="text-3xl font-bold text-white">QUOTATION</h1>
                                @endif
                                <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($quotation->status === 'accepted') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                @elseif($quotation->status === 'sent') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                @elseif($quotation->status === 'rejected') bg-rose-500/10 text-rose-400 border border-rose-500/20
                                @else bg-slate-700 text-slate-300 border border-slate-600 @endif">
                                    {{ ucfirst($quotation->status) }}
                                </span>
                            </div>

                            <!-- Company Info -->
                            <div class="text-sm text-slate-400 space-y-1">
                                <p class="font-bold text-white text-lg">
                                    {{ \App\Models\Setting::get('company_name', 'Bayan Pro') }}</p>
                                <p class="whitespace-pre-line">{{ \App\Models\Setting::get('company_address') }}</p>
                                <p>{{ \App\Models\Setting::get('company_email') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-slate-500 text-sm uppercase tracking-wider font-bold mb-2">Issued To</p>
                            <h3 class="text-xl font-semibold text-white mb-1">
                                {{ $quotation->client->company_name ?? $quotation->client->name }}</h3>
                            <p class="text-slate-400 text-sm">{{ $quotation->client->email }}</p>
                            <p class="text-slate-400 text-sm whitespace-pre-line">{{ $quotation->client->address }}</p>
                        </div>
                    </div>

                    <!-- Meta Grid -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-10">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Issue Date</p>
                            <p class="text-lg font-medium text-white">{{ $quotation->issue_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Expiry Date</p>
                            <p class="text-lg font-medium text-white">{{ $quotation->expiry_date->format('M d, Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Project</p>
                            <p class="text-lg font-medium text-white">
                                {{ $quotation->project ? $quotation->project->name : 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Amount</p>
                            <p class="text-2xl font-bold text-indigo-400 text-shadow-sm">
                                ${{ number_format($quotation->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-hidden rounded-lg border border-white/10 mb-8">
                        <table class="min-w-full divide-y divide-white/10">
                            <thead class="bg-white/5">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Item</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Qty</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Unit Price</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/10">
                                @foreach($quotation->items as $item)
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-white">{{ $item->title }}</div>
                                            @if($item->description)
                                                <div class="text-xs text-slate-400 mt-1 whitespace-pre-line">
                                                    {{ $item->description }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm text-slate-300">{{ $item->quantity }}</td>
                                        <td class="px-6 py-4 text-right text-sm text-slate-300">
                                            ${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="px-6 py-4 text-right text-sm font-semibold text-white">
                                            ${{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('quotations.edit', $quotation) }}"
                            class="px-4 py-2 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg transition-colors border border-white/10">
                            Edit Quotation
                        </a>
                        <button
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-colors backdrop-blur-sm"
                            onclick="alert('Conversion feature coming soon!')">
                            Convert to Invoice
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>