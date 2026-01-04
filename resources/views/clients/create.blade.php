<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Add Client') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden rounded-xl">
                <div class="p-6 text-slate-100">
                    <form action="{{ route('clients.store') }}" method="POST" class="max-w-2xl mx-auto space-y-6">
                        @csrf
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full"
                                :value="old('company_name')" />
                            <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                :value="old('email')" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                :value="old('phone')" />
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address"
                                class="mt-1 block w-full rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-500"
                                rows="3">{{ old('address') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address')" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('clients.index') }}"
                                class="text-sm text-slate-400 hover:text-white transition-colors">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Create Client') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>