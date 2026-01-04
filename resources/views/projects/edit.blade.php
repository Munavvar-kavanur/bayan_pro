<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight">
            {{ __('Edit Project') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden rounded-xl">
                <div class="p-6 text-slate-100">
                    <form action="{{ route('projects.update', $project) }}" method="POST"
                        class="max-w-2xl mx-auto space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="client_id" :value="__('Client')" />
                            <select name="client_id" id="client_id"
                                class="mt-1 block w-full rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-500"
                                required>
                                <option value="" class="bg-slate-800 text-slate-400">Select a Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }} class="bg-slate-800">
                                        {{ $client->company_name ? $client->company_name . ' (' . $client->name . ')' : $client->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('client_id')" />
                        </div>

                        <div>
                            <x-input-label for="name" :value="__('Project Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $project->name)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-500">{{ old('description', $project->description) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="status" :value="__('Status')" />
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-lg bg-slate-900/50 border-white/10 text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 placeholder-slate-500"
                                    required>
                                    <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }} class="bg-slate-800">Pending</option>
                                    <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }} class="bg-slate-800">In Progress</option>
                                    <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }} class="bg-slate-800">On Hold</option>
                                    <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }} class="bg-slate-800">Completed</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('status')" />
                            </div>

                            <div>
                                <x-input-label for="deadline" :value="__('Deadline')" />
                                <x-text-input id="deadline" name="deadline" type="date" class="mt-1 block w-full"
                                    :value="old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '')" />
                                <x-input-error class="mt-2" :messages="$errors->get('deadline')" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('projects.index') }}"
                                class="text-sm text-slate-400 hover:text-white transition-colors">
                                {{ __('Cancel') }}
                            </a>
                            <x-primary-button>
                                {{ __('Update Project') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>