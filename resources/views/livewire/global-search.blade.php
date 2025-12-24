<div class="relative mx-4 lg:mx-0 group w-full max-w-md" x-data="{ open: false }" @click.away="open = false">
    <div class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none">
                <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>
        <input 
            wire:model.live.debounce.300ms="search"
            @focus="open = true"
            @input="open = true"
            class="w-full pl-10 pr-4 py-2 text-sm text-gray-600 bg-gray-100 border-none rounded-full focus:bg-white focus:ring-2 focus:ring-blue-500 placeholder-gray-400 dark:bg-gray-700 dark:text-gray-200 dark:focus:bg-gray-600 transition-all duration-200" 
            type="text" 
            placeholder="Search clients, projects, invoices..."
        >
        
        <!-- Loading Indicator -->
        <div wire:loading class="absolute right-3 top-2.5">
            <svg class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Dropdown Results -->
    @if(strlen($search) >= 2 && count($results) > 0)
        <div 
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="absolute mt-2 w-full bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50 max-h-96 overflow-y-auto"
            style="display: none;"
        >
            @foreach(collect($results)->groupBy('type') as $type => $items)
                <div class="py-2">
                    <div class="px-4 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider bg-gray-50 dark:bg-gray-700/50">
                        {{ $type }}s
                    </div>
                    @foreach($items as $result)
                        <a href="{{ $result['url'] }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $result['title'] }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $result['subtitle'] }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    @elseif(strlen($search) >= 2 && count($results) === 0)
        <div 
            x-show="open"
            class="absolute mt-2 w-full bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50 p-4 text-center text-sm text-gray-500 dark:text-gray-400"
            style="display: none;"
        >
            No results found for "{{ $search }}"
        </div>
    @endif
</div>
