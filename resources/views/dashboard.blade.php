<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-800 dark:text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Clients -->
                <div
                    class="glass overflow-hidden rounded-xl p-6 border-l-4 border-emerald-500 hover:bg-slate-50 dark:hover:bg-white/5 transition-all duration-300 relative group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="h-16 w-16 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">
                            Total Clients</div>
                        <div class="text-3xl font-bold text-slate-800 dark:text-white">{{ \App\Models\Client::count() }}
                        </div>
                        <div class="mt-2 text-xs text-emerald-600 dark:text-emerald-400 font-medium">
                            +{{ \App\Models\Client::where('created_at', '>=', now()->subDays(30))->count() }} this month
                        </div>
                    </div>
                </div>

                <!-- Projects -->
                <div
                    class="glass overflow-hidden rounded-xl p-6 border-l-4 border-indigo-500 hover:bg-slate-50 dark:hover:bg-white/5 transition-all duration-300 relative group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="h-16 w-16 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">
                            Active Projects</div>
                        <div class="text-3xl font-bold text-slate-800 dark:text-white">
                            {{ \App\Models\Project::where('status', 'in_progress')->count() }}</div>
                        <div class="mt-2 text-xs text-indigo-600 dark:text-indigo-400 font-medium">
                            {{ \App\Models\Project::count() }} total projects</div>
                    </div>
                </div>

                <!-- Invoices -->
                <div
                    class="glass overflow-hidden rounded-xl p-6 border-l-4 border-blue-500 hover:bg-slate-50 dark:hover:bg-white/5 transition-all duration-300 relative group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="h-16 w-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">
                            Pending Invoices</div>
                        <div class="text-3xl font-bold text-slate-800 dark:text-white">
                            {{ \App\Models\Invoice::whereIn('status', ['sent', 'overdue'])->count() }}</div>
                        <div class="mt-2 text-xs text-blue-600 dark:text-blue-400 font-medium">
                            {{ \App\Models\Invoice::where('status', 'overdue')->count() }} overdue</div>
                    </div>
                </div>

                <!-- Quotations -->
                <div
                    class="glass overflow-hidden rounded-xl p-6 border-l-4 border-amber-500 hover:bg-slate-50 dark:hover:bg-white/5 transition-all duration-300 relative group">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                        <svg class="h-16 w-16 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <div class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-wider mb-1">
                            Pending Quotations</div>
                        <div class="text-3xl font-bold text-slate-800 dark:text-white">
                            {{ \App\Models\Quotation::where('status', 'sent')->count() }}</div>
                        <div class="mt-2 text-xs text-amber-600 dark:text-amber-400 font-medium">
                            {{ \App\Models\Quotation::where('status', 'accepted')->count() }} accepted</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Projects -->
                <div class="glass overflow-hidden rounded-xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Recent Projects</h3>
                        <a href="{{ route('projects.index') }}"
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 uppercase tracking-wider">View
                            All</a>
                    </div>
                    <div class="overflow-hidden">
                        <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                            <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                                @foreach(\App\Models\Project::with('client')->latest()->take(5)->get() as $project)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <td class="py-3 pl-2">
                                            <div class="font-medium text-slate-800 dark:text-white">{{ $project->name }}
                                            </div>
                                            <div class="text-xs text-slate-500">{{ $project->client->name ?? 'N/A' }}</div>
                                        </td>
                                        <td class="py-3 text-right pr-2">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($project->status === 'completed') bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20
                                                @elseif($project->status === 'in_progress') bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20
                                                @elseif($project->status === 'on_hold') bg-amber-100 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20
                                                @else bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 @endif">
                                                {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(\App\Models\Project::count() === 0)
                            <p class="text-center text-slate-500 py-4">No projects found.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Invoices -->
                <div class="glass overflow-hidden rounded-xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Recent Invoices</h3>
                        <a href="{{ route('invoices.index') }}"
                            class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 uppercase tracking-wider">View
                            All</a>
                    </div>
                    <div class="overflow-hidden">
                        <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
                            <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                                @foreach(\App\Models\Invoice::with('client')->latest()->take(5)->get() as $invoice)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
                                        <td class="py-3 pl-2">
                                            <div class="font-medium text-slate-800 dark:text-white">#{{ $invoice->id }} -
                                                {{ $invoice->client->company_name ?? $invoice->client->name ?? 'N/A' }}
                                            </div>
                                            <div class="text-xs text-slate-500">{{ $invoice->issue_date->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="py-3 text-right">
                                            <div class="font-bold text-slate-800 dark:text-white">
                                                ${{ number_format($invoice->total_amount, 2) }}</div>
                                        </td>
                                        <td class="py-3 text-right pr-2">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full 
                                                @if($invoice->status === 'paid') bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-500/20
                                                @elseif($invoice->status === 'sent') bg-blue-100 dark:bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20
                                                @elseif($invoice->status === 'overdue') bg-rose-100 dark:bg-rose-500/10 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20
                                                @else bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600 @endif">
                                                {{ ucfirst($invoice->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if(\App\Models\Invoice::count() === 0)
                            <p class="text-center text-slate-500 py-4">No invoices found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>