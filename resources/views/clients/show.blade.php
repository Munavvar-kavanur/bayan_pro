<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Client Details') }}
            </h2>
            <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="{ tab: 'details' }" class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="tab = 'details'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'details', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'details'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Client Details
                            </button>
                            <button @click="tab = 'projects'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'projects', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'projects'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Projects ({{ $client->projects->count() }})
                            </button>
                            <button @click="tab = 'invoices'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'invoices', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'invoices'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Invoices ({{ $client->invoices->count() }})
                            </button>
                            <button @click="tab = 'quotations'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'quotations', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'quotations'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Quotations ({{ $client->quotations->count() ?? 0 }})
                            </button>
                        </nav>
                    </div>

                    <!-- Details Tab -->
                    <div x-show="tab === 'details'" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Personal Information</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="mb-2"><span class="font-bold text-gray-600 dark:text-gray-400">Name:</span> <span class="pl-2">{{ $client->name }}</span></p>
                                <p class="mb-2"><span class="font-bold text-gray-600 dark:text-gray-400">Company Name:</span> <span class="pl-2">{{ $client->company_name ?? 'N/A' }}</span></p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Contact Details</h3>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p class="mb-2"><span class="font-bold text-gray-600 dark:text-gray-400">Email:</span> <span class="pl-2">{{ $client->email ?? 'N/A' }}</span></p>
                                <p class="mb-2"><span class="font-bold text-gray-600 dark:text-gray-400">Phone:</span> <span class="pl-2">{{ $client->phone ?? 'N/A' }}</span></p>
                            </div>
                        </div>
                        
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Address</h3>
                             <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <p>{{ $client->address ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Projects Tab -->
                    <div x-show="tab === 'projects'" style="display: none;">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition text-sm">
                                + Add Project
                            </a>
                        </div>
                         <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Project Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Deadline</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($client->projects as $project)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold">{{ $project->name }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($project->status === 'completed') bg-green-100 text-green-800 
                                                    @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800 
                                                    @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $project->deadline ? $project->deadline->format('Y-m-d') : 'N/A' }}
                                            </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">Edit</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No projects found for this client.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Invoices Tab -->
                    <div x-show="tab === 'invoices'" style="display: none;">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('invoices.create', ['client_id' => $client->id]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition text-sm">
                                + Create Invoice
                            </a>
                        </div>
                         <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Invoice #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Due Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($client->invoices as $invoice)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('invoices.show', $invoice) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold">#{{ $invoice->id }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($invoice->status === 'paid') bg-green-100 text-green-800 
                                                    @elseif($invoice->status === 'sent') bg-blue-100 text-blue-800 
                                                    @elseif($invoice->status === 'overdue') bg-red-100 text-red-800 
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($invoice->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                                ${{ number_format($invoice->total_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $invoice->due_date ? $invoice->due_date->format('Y-m-d') : 'N/A' }}
                                            </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">Edit</a>
                                                <a href="{{ route('invoices.show', $invoice) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No invoices found for this client.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Quotations Tab -->
                    <div x-show="tab === 'quotations'" style="display: none;">
                        <div class="flex justify-end mb-4">
                            <a href="{{ route('quotations.create', ['client_id' => $client->id]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition text-sm">
                                + Create Quotation
                            </a>
                        </div>
                         <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quotation #</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Expiry Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($client->quotations as $quotation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('quotations.show', $quotation) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-semibold">#{{ $quotation->id }}</a>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    @if($quotation->status === 'accepted') bg-green-100 text-green-800 
                                                    @elseif($quotation->status === 'sent') bg-blue-100 text-blue-800 
                                                    @elseif($quotation->status === 'rejected') bg-red-100 text-red-800 
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($quotation->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white font-medium">
                                                ${{ number_format($quotation->total_amount, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $quotation->expiry_date ? $quotation->expiry_date->format('Y-m-d') : 'N/A' }}
                                            </td>
                                             <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('quotations.edit', $quotation) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">Edit</a>
                                                <a href="{{ route('quotations.show', $quotation) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">View</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No quotations found for this client.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('clients.edit', $client) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Edit Client</a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete Client</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
