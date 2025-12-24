<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Quotation Details') }} #{{ $quotation->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                 
                 <!-- Header Info -->
                 <div class="flex justify-between items-start mb-8 border-b border-gray-200 dark:border-gray-700 pb-6">
                    <div>
                        @php
                            $logo = \App\Models\Setting::get('quotation_logo') ?? \App\Models\Setting::get('branding_logo');
                        @endphp
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Company Logo" class="h-16 object-contain mb-4">
                        @endif
                         <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Quotation</h1>
                         <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($quotation->status === 'accepted') bg-green-100 text-green-800 
                            @elseif($quotation->status === 'sent') bg-blue-100 text-blue-800 
                            @elseif($quotation->status === 'rejected') bg-red-100 text-red-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($quotation->status) }}
                        </span>
                        
                        <!-- Company Info -->
                        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                             <p class="font-bold text-gray-900 dark:text-white">{{ \App\Models\Setting::get('company_name', 'Bayan Pro') }}</p>
                             <p class="whitespace-pre-line">{{ \App\Models\Setting::get('company_address') }}</p>
                             <p>{{ \App\Models\Setting::get('company_email') }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-500 dark:text-gray-400 text-sm">Issued To:</p>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $quotation->client->company_name ?? $quotation->client->name }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $quotation->client->email }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm whitespace-pre-line">{{ $quotation->client->address }}</p>
                    </div>
                 </div>

                 <!-- Meta Grid -->
                 <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Issue Date</p>
                        <p class="text-gray-900 dark:text-white">{{ $quotation->issue_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Expiry Date</p>
                        <p class="text-gray-900 dark:text-white">{{ $quotation->expiry_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Project</p>
                        <p class="text-gray-900 dark:text-white">{{ $quotation->project ? $quotation->project->name : 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Amount</p>
                        <p class="text-xl font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($quotation->total_amount, 2) }}</p>
                    </div>
                 </div>

                 <!-- Items Table -->
                 <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-lg mb-8">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Item</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unit Price</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($quotation->items as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->title }}</div>
                                    @if($item->description)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $item->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-white">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-white">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-white">${{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                 </div>

                 <!-- Actions -->
                 <div class="flex justify-end gap-3">
                    <a href="{{ route('quotations.edit', $quotation) }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white rounded-md transition duration-150">
                        Edit Quotation
                    </a>
                    <!-- Placeholder for Convert to Invoice -->
                     <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition duration-150 shadow-sm" onclick="alert('Conversion feature coming soon!')">
                        Convert to Invoice
                    </button>
                 </div>
            </div>
        </div>
    </div>
</x-app-layout>
