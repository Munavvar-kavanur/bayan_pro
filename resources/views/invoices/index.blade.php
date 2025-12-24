<x-app-layout>
    <div class="min-h-screen bg-gray-50/50 dark:bg-gray-900">
        
        <!-- Header & Stats -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Invoices</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your billing and payments.</p>
                </div>
                <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-all focus:ring-4 focus:ring-indigo-500/20">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    New Invoice
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Volume -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Volume</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($totalAmount, 2) }}</h3>
                        </div>
                        <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Total Paid -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Paid</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($totalPaid, 2) }}</h3>
                        </div>
                        <div class="p-2 bg-green-50 dark:bg-green-900/30 rounded-lg text-green-600 dark:text-green-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Overdue</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">${{ number_format($totalOverdue, 2) }}</h3>
                        </div>
                        <div class="p-2 bg-red-50 dark:bg-red-900/30 rounded-lg text-red-600 dark:text-red-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                    </div>
                </div>

                 <!-- Count -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                     <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Invoices</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $totalInvoices }}</h3>
                        </div>
                        <div class="p-2 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-600 dark:text-gray-400">
                             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Table List -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
                
                @if(session('success'))
                    <div class="bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 p-4 text-sm font-medium border-b border-green-100 dark:border-green-800">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700/50">
                        <thead class="bg-gray-50/50 dark:bg-gray-700/20">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Invoice</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Client</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700/50 bg-white dark:bg-gray-800">
                            @forelse ($invoices as $invoice)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs ring-1 ring-indigo-100 dark:ring-indigo-700">
                                            #{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="ml-4">
                                            <a href="{{ route('invoices.show', $invoice) }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                                Invoice #{{ $invoice->id }}
                                            </a>
                                            @if($invoice->project)
                                                <div class="text-xs text-gray-500 mt-0.5 flex items-center gap-1">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                                    {{ Str::limit($invoice->project->name, 20) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                         <!-- Generative Avatar for Client -->
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-purple-400 to-indigo-500 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white dark:ring-gray-800">
                                            {{ substr($invoice->client->company_name ?? $invoice->client->name, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $invoice->client->company_name ?? $invoice->client->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $invoice->client->email ?? 'No email' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $invoice->due_date->format('M d, Y') }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $invoice->created_at->diffForHumans() }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($invoice->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                        @if($invoice->status === 'paid') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800
                                        @elseif($invoice->status === 'overdue') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800
                                        @elseif($invoice->status === 'sent') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800
                                        @else bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600 @endif
                                    ">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                            @if($invoice->status === 'paid') bg-green-500 
                                            @elseif($invoice->status === 'overdue') bg-red-500
                                            @elseif($invoice->status === 'sent') bg-blue-500
                                            @else bg-gray-500 @endif
                                        "></span>
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                    <div class="opacity-0 group-hover:opacity-100 transition-opacity flex justify-end items-center gap-2">
                                        <a href="{{ route('invoices.show', $invoice) }}" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-400 hover:text-indigo-600 dark:text-gray-500 dark:hover:text-indigo-400 transition-colors" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice) }}" class="p-1.5 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-400 hover:text-indigo-600 dark:text-gray-500 dark:hover:text-indigo-400 transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </a>
                                        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this invoice?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg text-gray-400 hover:text-red-600 dark:text-gray-500 dark:hover:text-red-400 transition-colors" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-24 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-full mb-4">
                                            <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">No invoices yet</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 max-w-sm mt-1 mb-6">Create your first invoice to listing billing and tracking payments.</p>
                                        <a href="{{ route('invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm">
                                            Create Invoice
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Pagination -->
                @if($invoices->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
