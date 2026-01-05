<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 print:hidden">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Invoice Details') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('invoices.edit', $invoice) }}"
                    class="inline-flex items-center px-4 py-2 bg-white/5 border border-white/10 rounded-lg font-semibold text-xs text-slate-300 uppercase tracking-widest shadow-sm hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Edit
                </a>
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-indigo-500/30">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print PDF
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12 print:py-0">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 print:max-w-full print:px-0">
            <div class="glass overflow-hidden rounded-xl print:shadow-none print:rounded-none print:bg-white print:text-black"
                id="invoice">
                @include('invoices.partials.invoice-template')
            </div>
        </div>
    </div>
</x-app-layout>