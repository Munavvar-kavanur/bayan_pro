<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Client Details') }}
            </h2>
            <a href="{{ route('clients.index') }}"
                class="px-4 py-2 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg transition-colors border border-white/10">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden rounded-xl">
                <div x-data="{ tab: 'details' }" class="p-6 text-slate-100">

                    <!-- Tabs Navigation -->
                    <div class="border-b border-white/10 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="tab = 'details'"
                                :class="{'border-indigo-500 text-indigo-400': tab === 'details', 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-600': tab !== 'details'}"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Client Details
                            </button>
                            <button @click="tab = 'projects'"
                                :class="{'border-indigo-500 text-indigo-400': tab === 'projects', 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-600': tab !== 'projects'}"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Projects ({{ $client->projects->count() }})
                            </button>
                            <button @click="tab = 'invoices'"
                                :class="{'border-indigo-500 text-indigo-400': tab === 'invoices', 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-600': tab !== 'invoices'}"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Invoices ({{ $client->invoices->count() }})
                            </button>
                            <button @click="tab = 'quotations'"
                                :class="{'border-indigo-500 text-indigo-400': tab === 'quotations', 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-600': tab !== 'quotations'}"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                Quotations ({{ $client->quotations->count() ?? 0 }})
                            </button>
                        </nav>
                    </div>

                    <!-- Details Tab -->
                    <div x-show="tab === 'details'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-white mb-2">Personal Information</h3>
                            <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                <p class="mb-2"><span class="font-bold text-slate-400">Name:</span> <span
                                        class="pl-2 text-slate-200">{{ $client->name }}</span></p>
                                <p class="mb-2"><span class="font-bold text-slate-400">Company Name:</span> <span
                                        class="pl-2 text-slate-200">{{ $client->company_name ?? 'N/A' }}</span></p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-white mb-2">Contact Details</h3>
                            <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                <p class="mb-2"><span class="font-bold text-slate-400">Email:</span> <span
                                        class="pl-2 text-slate-200">{{ $client->email ?? 'N/A' }}</span></p>
                                <p class="mb-2"><span class="font-bold text-slate-400">Phone:</span> <span
                                        class="pl-2 text-slate-200">{{ $client->phone ?? 'N/A' }}</span></p>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-white mb-2">Address</h3>
                            <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                <p class="text-slate-200">{{ $client->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Tab -->
                    <div x-show="tab === 'projects'" style="display: none;">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('projects.create') }}"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-all font-medium text-sm backdrop-blur-sm">
                                + Add Project
                            </a>
                        </div>
                        <div class="overflow-x-auto rounded-lg border border-white/10">
                            <table class="min-w-full divide-y divide-white/10">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Project Name</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Deadline</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-transparent divide-y divide-white/10">
                                    @forelse($client->projects as $project)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('projects.show', $project) }}"
                                                    class="text-indigo-400 hover:text-indigo-300 font-semibold">{{ $project->name }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($project->status === 'completed') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                                        @elseif($project->status === 'in_progress') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                                        @elseif($project->status === 'on_hold') bg-amber-500/10 text-amber-400 border border-amber-500/20
                                                        @else bg-slate-700 text-slate-300 border border-slate-600 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                                {{ $project->deadline ? $project->deadline->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('projects.edit', $project) }}"
                                                    class="text-indigo-400 hover:text-indigo-300 transition-colors">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-slate-500">No projects found
                                                for this client.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Invoices Tab -->
                    <div x-show="tab === 'invoices'" style="display: none;">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-all font-medium text-sm backdrop-blur-sm">
                                + Create Invoice
                            </a>
                        </div>
                        <div class="overflow-x-auto rounded-lg border border-white/10">
                            <table class="min-w-full divide-y divide-white/10">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Invoice #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Due Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-transparent divide-y divide-white/10">
                                    @forelse($client->invoices as $invoice)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('invoices.show', $invoice) }}"
                                                    class="text-indigo-400 hover:text-indigo-300 font-semibold">#{{ $invoice->id }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($invoice->status === 'paid') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                                        @elseif($invoice->status === 'sent') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                                        @elseif($invoice->status === 'overdue') bg-rose-500/10 text-rose-400 border border-rose-500/20
                                                        @else bg-slate-700 text-slate-300 border border-slate-600 @endif">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                                ${{ number_format($invoice->total_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                                {{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('invoices.edit', $invoice) }}"
                                                    class="text-indigo-400 hover:text-indigo-300 mr-3 transition-colors">Edit</a>
                                                <a href="{{ route('invoices.show', $invoice) }}"
                                                    class="text-slate-400 hover:text-white transition-colors">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-slate-500">No invoices found
                                                for this client.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Quotations Tab -->
                    <div x-show="tab === 'quotations'" style="display: none;">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('quotations.create', ['client_id' => $client->id]) }}"
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-all font-medium text-sm backdrop-blur-sm">
                                + Create Quotation
                            </a>
                        </div>
                        <div class="overflow-x-auto rounded-lg border border-white/10">
                            <table class="min-w-full divide-y divide-white/10">
                                <thead class="bg-white/5">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Quotation #</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Status</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Amount</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Expiry Date</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-slate-400 uppercase tracking-wider">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-transparent divide-y divide-white/10">
                                    @forelse($client->quotations as $quotation)
                                        <tr class="hover:bg-white/5 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('quotations.show', $quotation) }}"
                                                    class="text-indigo-400 hover:text-indigo-300 font-semibold">#{{ $quotation->id }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($quotation->status === 'accepted') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                                                        @elseif($quotation->status === 'sent') bg-blue-500/10 text-blue-400 border border-blue-500/20
                                                        @elseif($quotation->status === 'rejected') bg-rose-500/10 text-rose-400 border border-rose-500/20
                                                        @else bg-slate-700 text-slate-300 border border-slate-600 @endif">
                                                    {{ ucfirst($quotation->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-medium">
                                                ${{ number_format($quotation->total_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400">
                                                {{ $quotation->expiry_date ? $quotation->expiry_date->format('Y-m-d') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('quotations.edit', $quotation) }}"
                                                    class="text-indigo-400 hover:text-indigo-300 mr-3 transition-colors">Edit</a>
                                                <a href="{{ route('quotations.show', $quotation) }}"
                                                    class="text-slate-400 hover:text-white transition-colors">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-slate-500">No quotations found
                                                for this client.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('clients.edit', $client) }}"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-colors backdrop-blur-sm">Edit
                            Client</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this client?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-lg shadow-lg shadow-rose-500/30 ring-1 ring-rose-500/50 transition-colors backdrop-blur-sm">Delete
                                Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>