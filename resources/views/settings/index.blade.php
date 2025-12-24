<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 p-4 rounded-lg text-sm font-medium border border-green-100 dark:border-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <a href="{{ route('settings.index', ['tab' => 'general']) }}" 
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                               {{ $tab === 'general' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                                Company Profile
                            </a>
                            <a href="{{ route('settings.index', ['tab' => 'finance']) }}" 
                               class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors
                               {{ $tab === 'finance' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">
                                Finance & Defaults
                            </a>
                        </nav>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tab" value="{{ $tab }}">

                        <div class="space-y-6 max-w-3xl">
                            
                            @if($tab === 'general')
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Company Information</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">These details will appear on your invoices and quotations.</p>

                                    <div class="grid grid-cols-1 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Name</label>
                                            <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Email</label>
                                            <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Phone</label>
                                            <input type="text" name="company_phone" value="{{ $settings['company_phone'] ?? '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                                            <textarea name="company_address" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['company_address'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @elseif($tab === 'finance')
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Finance Defaults</h3>
                                    
                                    <div class="grid grid-cols-1 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Currency Symbol</label>
                                            <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm max-w-xs">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Default Tax Rate (%)</label>
                                            <input type="number" step="0.01" name="default_tax_rate" value="{{ $settings['default_tax_rate'] ?? '0' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm max-w-xs">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Invoice Notes Default</label>
                                            <textarea name="default_invoice_notes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $settings['default_invoice_notes'] ?? '' }}</textarea>
                                            <p class="mt-1 text-xs text-gray-500">Default notes displayed on new invoices.</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition-colors focus:ring-4 focus:ring-indigo-500/20">
                                    Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
