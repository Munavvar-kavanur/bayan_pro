<div class="glass rounded-xl shadow-xl overflow-hidden">
    <form wire:submit.prevent="save">
        
        <!-- Top Actions / Header -->
        <div class="px-8 py-6 border-b border-white/10 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white/5 backdrop-blur-sm">
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                {{ $quotation ? 'Edit Quotation' : 'New Quotation' }}
            </h1>
            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <a href="{{ route('quotations.index') }}" class="text-slate-400 hover:text-white text-sm font-medium transition-colors cursor-pointer">
                    Cancel
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white font-medium text-sm rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-colors focus:outline-none">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    Save Quotation
                </button>
            </div>
        </div>

        <div class="p-8 space-y-8 bg-transparent">
            
            <!-- Metadata Card -->
            <div class="glass rounded-xl p-6">
                 <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                     
                    <!-- Client Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Client</label>
                        
                        @if($client_id)
                            <!-- Selected State -->
                            <div class="flex items-center justify-between p-3 bg-indigo-500/10 border border-indigo-500/30 rounded-lg group transition-all">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center text-indigo-300 font-bold text-xs flex-shrink-0">
                                        {{ substr($client_search ? $client_search : 'C', 0, 2) }}
                                    </div>
                                    <div class="flex flex-col overflow-hidden">
                                        <span class="text-sm font-medium text-white truncate">{{ $client_search }}</span>
                                        <span class="text-xs text-indigo-300">Client Selected</span>
                                    </div>
                                </div>
                                <button type="button" wire:click="clearClient" class="text-slate-400 hover:text-rose-400 transition-colors p-1.5 rounded-md hover:bg-white/5 focus:outline-none" title="Change Client">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        @else
                            <!-- Search State -->
                            <div class="relative">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        wire:model.live="client_search"
                                        class="w-full rounded-lg bg-slate-900/50 border-white/10 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-4 py-2.5"
                                        placeholder="Search client..."
                                        autocomplete="off"
                                    >
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                    </div>
                                    <!-- Spinner -->
                                    <div wire:loading wire:target="client_search" class="absolute inset-y-0 right-10 flex items-center pointer-events-none">
                                        <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>

                                @if(strlen($client_search) >= 1)
                                <div class="absolute z-10 w-full mt-1 bg-slate-800 shadow-xl rounded-lg border border-white/10 max-h-60 overflow-y-auto">
                                    <ul wire:key="client-list-{{ count($found_clients) }}">
                                        @forelse($found_clients as $client)
                                            <li wire:key="client-row-{{ $client->id }}" class="border-b border-white/5 last:border-0">
                                                <button 
                                                    type="button"
                                                    wire:click="selectClient({{ $client->id }})"
                                                    class="w-full text-left px-4 py-3 hover:bg-white/5 cursor-pointer flex flex-col focus:outline-none transition-colors relative"
                                                >
                                                    <span class="text-sm font-medium text-white">{{ $client->company_name ?? $client->name }}</span>
                                                    @if($client->company_name)<span class="text-xs text-slate-400">{{ $client->name }}</span>@endif
                                                    
                                                    <!-- Loading Indicator -->
                                                    <div wire:loading.flex wire:target="selectClient({{ $client->id }})" class="absolute inset-y-0 right-4 items-center">
                                                        <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    </div>
                                                </button>
                                            </li>
                                        @empty
                                            <li class="px-4 py-3 text-sm text-slate-400 text-center">No clients found</li>
                                        @endforelse
                                    </ul>
                                </div>
                                @endif
                            </div>
                        @endif
                        @error('client_id') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Project Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Project</label>
                        
                        @if($project_id)
                             <!-- Selected State -->
                            <div class="flex items-center justify-between p-3 bg-white/5 border border-white/10 rounded-lg group transition-all">
                                <div class="flex items-center gap-3 overflow-hidden">
                                     <div class="w-8 h-8 rounded-full bg-slate-700 flex items-center justify-center text-slate-300 font-bold text-xs flex-shrink-0">
                                        P
                                    </div>
                                    <div class="flex flex-col overflow-hidden">
                                        <span class="text-sm font-medium text-white truncate">{{ $project_search }}</span>
                                        <span class="text-xs text-slate-400">Project Selected</span>
                                    </div>
                                </div>
                                <button type="button" wire:click="clearProject" class="text-slate-400 hover:text-rose-400 transition-colors p-1.5 rounded-md hover:bg-white/5 focus:outline-none" title="Change Project">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                        @else
                            <!-- Search State -->
                            <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        wire:model.live="project_search" 
                                        class="w-full rounded-lg bg-slate-900/50 border-white/10 text-white placeholder-slate-500 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm pl-4 py-2.5 disabled:opacity-50 disabled:bg-slate-800"
                                        placeholder="{{ $client_id ? 'Search project...' : 'Select client first' }}"
                                        autocomplete="off"
                                        @focus="open = true"
                                        @input="open = true"
                                        @keydown.escape="open = false"
                                        @keydown.enter.prevent="open = false"
                                        {{ !$client_id ? 'disabled' : '' }}
                                    >
                                     <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                                     </div>
                                     <!-- Spinner -->
                                    <div wire:loading wire:target="project_search" class="absolute inset-y-0 right-10 flex items-center pointer-events-none">
                                        <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </div>
                                </div>

                                <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-slate-800 shadow-xl rounded-lg border border-white/10 max-h-60 overflow-y-auto">
                                    <ul wire:key="project-list-{{ count($found_projects) }}">
                                        @forelse($found_projects as $project)
                                            <li wire:key="project-row-{{ $project->id }}" class="border-b border-white/5 last:border-0">
                                                <button 
                                                    type="button"
                                                    wire:click="selectProject({{ $project->id }})"
                                                    @mousedown.prevent
                                                    class="w-full text-left px-4 py-2.5 hover:bg-white/5 cursor-pointer text-sm text-slate-200 focus:outline-none transition-colors relative"
                                                >
                                                    {{ $project->name }}
                                                    <!-- Loading Indicator -->
                                                    <div wire:loading.flex wire:target="selectProject({{ $project->id }})" class="absolute inset-y-0 right-4 items-center">
                                                        <svg class="animate-spin h-4 w-4 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    </div>
                                                </button>
                                            </li>
                                        @empty
                                            @if($project_search && $client_id)
                                                <li class="px-4 py-3 text-sm text-slate-400 text-center">No projects found</li>
                                            @endif
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Issue Date -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Issue Date</label>
                        <input type="date" wire:model="issue_date" class="w-full rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        @error('issue_date') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Expiry Date</label>
                        <input type="date" wire:model="expiry_date" class="w-full rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                        @error('expiry_date') <p class="mt-1 text-xs text-rose-500">{{ $message }}</p> @enderror
                    </div>
                 </div>
            </div>

            <!-- Items Table -->
            <div class="glass rounded-xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-400">
                        <thead class="bg-white/5 text-xs uppercase text-slate-300 font-semibold">
                            <tr>
                                <th scope="col" class="px-6 py-4 w-12 text-center">#</th>
                                <th scope="col" class="px-6 py-4">Item Details</th>
                                <th scope="col" class="px-6 py-4 w-32 text-right">Qty</th>
                                <th scope="col" class="px-6 py-4 w-40 text-right">Price</th>
                                <th scope="col" class="px-6 py-4 w-40 text-right">Amount</th>
                                <th scope="col" class="px-6 py-4 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($items as $index => $item)
                            <tr class="hover:bg-white/5 group transition-colors">
                                <td class="px-6 py-4 text-center text-slate-500 text-xs">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 align-top space-y-2">
                                    <input type="text" wire:model="items.{{ $index }}.title" placeholder="Item name" class="w-full font-medium text-white border-0 border-b border-transparent hover:border-slate-600 focus:border-indigo-500 focus:ring-0 bg-transparent p-0 placeholder-slate-600 transition-colors">
                                    <textarea wire:model="items.{{ $index }}.description" placeholder="Description (Optional)" rows="1" class="w-full text-xs text-slate-400 border-0 focus:ring-0 bg-transparent p-0 placeholder-slate-600 resize-none"></textarea>
                                    @error('items.'.$index.'.title') <p class="text-xs text-rose-500">{{ $message }}</p> @enderror
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <input type="number" wire:model.live="items.{{ $index }}.quantity" min="1" class="w-full text-right rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-1">
                                </td>
                                <td class="px-6 py-4 align-top">
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-2 flex items-center text-slate-500 text-xs">$</span>
                                        <input type="number" wire:model.live="items.{{ $index }}.unit_price" step="0.01" min="0" class="w-full text-right pl-6 rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-1">
                                    </div>
                                </td>
                                <td class="px-6 py-4 align-top text-right font-medium text-white pt-5">
                                    ${{ number_format((floatval($items[$index]['quantity']) * floatval($items[$index]['unit_price'])), 2) }}
                                </td>
                                <td class="px-6 py-4 align-top text-center pt-5">
                                    <button type="button" wire:click="removeItem({{ $index }})" class="text-slate-500 hover:text-rose-500 transition-colors opacity-0 group-hover:opacity-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 bg-white/5 border-t border-white/10">
                    <button type="button" wire:click="addItem" class="text-sm font-semibold text-indigo-400 hover:text-indigo-300 inline-flex items-center gap-1 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Add New Item
                    </button>
                </div>
            </div>

            <!-- Footer / Totals -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Notes -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider">Notes</label>
                    <textarea wire:model="notes" rows="4" class="w-full rounded-xl bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm p-4 placeholder-slate-500" placeholder="Enter notes visible to the client..."></textarea>
                </div>

                <!-- Totals -->
                <div class="glass rounded-xl p-6 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400">Subtotal</span>
                        <span class="font-medium text-white text-base">${{ number_format($this->calculateTotal() / (1 + ($tax_rate/100)) + $discount_value, 2) }}</span> 
                        <!-- Simplification for display, logic handled in PHP -->
                    </div>

                    <div class="flex justify-between items-center text-sm pt-2">
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400">Discount</span>
                            <select wire:model.live="discount_type" class="text-xs border-none bg-slate-800 text-white rounded focus:ring-0 py-0.5 pl-2 pr-6 cursor-pointer">
                                <option value="fixed">$</option>
                                <option value="percent">%</option>
                            </select>
                        </div>
                        <input type="number" wire:model.live="discount_value" class="w-24 text-right rounded bg-slate-800 border-white/10 text-white text-sm py-1 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex justify-between items-center text-sm pt-2 border-b border-white/10 pb-4">
                        <span class="text-slate-400">Tax Rate (%)</span>
                        <input type="number" wire:model.live="tax_rate" class="w-24 text-right rounded bg-slate-800 border-white/10 text-white text-sm py-1 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div class="flex justify-between items-center pt-2">
                        <span class="text-lg font-bold text-white">Total</span>
                        <span class="text-2xl font-bold text-indigo-400">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
