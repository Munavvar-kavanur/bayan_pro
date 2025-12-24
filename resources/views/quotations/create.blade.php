<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @livewire('quotation-form', ['client_id' => $clientId])
        </div>
    </div>
</x-app-layout>
