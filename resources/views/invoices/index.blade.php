<x-app-layout>
    <div class="min-h-screen">

        <!-- Header & Stats -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-white">Invoices</h1>
                    <p class="text-sm text-slate-400 mt-1">Manage your billing and payments.</p>
                </div>
                <a href="{{ route('invoices.create') }}"
                    class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-all backdrop-blur-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Invoice
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Total Volume -->
                <div class="glass p-5 rounded-xl shadow-lg hover:bg-white/5 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Volume</p>
                            <h3 class="text-2xl font-bold text-white mt-1">${{ number_format($totalAmount, 2) }}</h3>
                        </div>
                        <div class="p-2 bg-indigo-500/10 rounded-lg text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Paid -->
                <div class="glass p-5 rounded-xl shadow-lg hover:bg-white/5 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Paid</p>
                            <h3 class="text-2xl font-bold text-white mt-1">${{ number_format($totalPaid, 2) }}</h3>
                        </div>
                        <div class="p-2 bg-emerald-500/10 rounded-lg text-emerald-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Overdue -->
                <div class="glass p-5 rounded-xl shadow-lg hover:bg-white/5 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Overdue</p>
                            <h3 class="text-2xl font-bold text-white mt-1">${{ number_format($totalOverdue, 2) }}</h3>
                        </div>
                        <div class="p-2 bg-rose-500/10 rounded-lg text-rose-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Count -->
                <div class="glass p-5 rounded-xl shadow-lg hover:bg-white/5 transition-colors">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Invoices</p>
                            <h3 class="text-2xl font-bold text-white mt-1">{{ $totalInvoices }}</h3>
                        </div>
                        <div class="p-2 bg-white/5 rounded-lg text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoices Table List -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="glass shadow-xl rounded-2xl overflow-hidden">

                @if(session('success'))
                    <div class="bg-emerald-500/10 text-emerald-400 p-4 text-sm font-medium border-b border-emerald-500/20">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/5">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Invoice</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Client</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Date</th>
                                <th scope="col"
                                    class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Amount</th>
                                <th scope="col"
                                    class="px-6 py-4 text-center text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10 bg-transparent">
                            @forelse ($invoices as $invoice)
                                <tr class="hover:bg-white/5 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 h-10 w-10 bg-indigo-500/20 rounded-lg flex items-center justify-center text-indigo-400 font-bold text-xs ring-1 ring-indigo-500/30">
                                                #{{ str_pad($invoice->id, 3, '0', STR_PAD_LEFT) }}
                                            </div>
                                            <div class="ml-4">
                                                <a href="{{ route('invoices.show', $invoice) }}"
                                                    class="text-sm font-bold text-white hover:text-indigo-400 transition-colors">
                                                    Invoice #{{ $invoice->id }}
                                                </a>
                                                @if($invoice->project)
                                                    <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                                                        {{ Str::limit($invoice->project->name, 20) }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <!-- Generative Avatar for Client -->
                                            <div
                                                class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-slate-800 shadow-lg shadow-indigo-500/20">
                                                {{ substr($invoice->client->company_name ?? $invoice->client->name, 0, 1) }}
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-white">
                                                    {{ $invoice->client->company_name ?? $invoice->client->name }}
                                                </div>
                                                <div class="text-xs text-slate-400">
                                                    {{ $invoice->client->email ?? 'No email' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-white font-medium">
                                            {{ $invoice->due_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-slate-500">{{ $invoice->created_at->diffForHumans() }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">
                                        ${{ number_format($invoice->total_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                                            @if($invoice->status === 'paid') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                            @elseif($invoice->status === 'overdue') bg-rose-500/10 text-rose-400 border border-rose-500/20
                                            @elseif($invoice->status === 'sent') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                            @else bg-slate-700 text-slate-300 border border-slate-600 @endif
                                        ">
                                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                                @if($invoice->status === 'paid') bg-emerald-500 
                                                @elseif($invoice->status === 'overdue') bg-rose-500
                                                @elseif($invoice->status === 'sent') bg-blue-500
                                                @else bg-slate-500 @endif
                                            "></span>
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <div
                                            class="opacity-0 group-hover:opacity-100 transition-opacity flex justify-end items-center gap-2">
                                            <a href="{{ route('invoices.show', $invoice) }}"
                                                class="p-1.5 hover:bg-white/10 rounded-lg text-slate-400 hover:text-indigo-400 transition-colors"
                                                title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('invoices.edit', $invoice) }}"
                                                class="p-1.5 hover:bg-white/10 rounded-lg text-slate-400 hover:text-indigo-400 transition-colors"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('Delete this invoice?');">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-1.5 hover:bg-rose-500/20 rounded-lg text-slate-400 hover:text-rose-400 transition-colors"
                                                    title="Delete">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-24 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="bg-white/5 p-4 rounded-full mb-4">
                                                <svg class="w-10 h-10 text-slate-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-white">No invoices yet</h3>
                                            <p class="text-sm text-slate-400 max-w-sm mt-1 mb-6">Create your first invoice
                                                to listing billing and tracking payments.</p>
                                            <a href="{{ route('invoices.create') }}"
                                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white font-medium rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 backdrop-blur-sm transition-all">
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
                    <div class="px-6 py-4 border-t border-white/10 bg-white/5">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>