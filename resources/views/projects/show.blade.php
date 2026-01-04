<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-white leading-tight">
                {{ __('Project Details') }}
            </h2>
            <a href="{{ route('projects.index') }}"
                class="px-4 py-2 bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white rounded-lg transition-colors border border-white/10">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass overflow-hidden rounded-xl">
                <div class="p-6 text-slate-100">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $project->name }}</h3>
                            <p class="text-sm text-slate-400 mt-1">Client:
                                {{ $project->client->company_name ?? $project->client->name }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($project->status === 'completed') bg-emerald-500/10 text-emerald-400 border border-emerald-500/20
                            @elseif($project->status === 'in_progress') bg-blue-500/10 text-blue-400 border border-blue-500/20
                            @elseif($project->status === 'on_hold') bg-amber-500/10 text-amber-400 border border-amber-500/20
                            @else bg-slate-700 text-slate-300 border border-slate-600 @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>

                    <div x-data="{ tab: 'overview' }">
                        <!-- Tabs Navigation -->
                        <div class="border-b border-white/10 mb-6">
                            <nav class="-mb-px flex space-x-8">
                                <button @click="tab = 'overview'"
                                    :class="{'border-indigo-500 text-indigo-400': tab === 'overview', 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-600': tab !== 'overview'}"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                    Overview
                                </button>
                                <button @click="tab = 'tasks'"
                                    :class="{'border-indigo-500 text-indigo-400': tab === 'tasks', 'border-transparent text-slate-400 hover:text-slate-200 hover:border-slate-600': tab !== 'tasks'}"
                                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors">
                                    Tasks ({{ $project->tasks()->count() }})
                                </button>
                            </nav>
                        </div>

                        <!-- Overview Tab -->
                        <div x-show="tab === 'overview'" class="space-y-6">
                            <div class="bg-white/5 p-6 rounded-lg border border-white/10">
                                <h4 class="text-lg font-medium mb-2 text-white">Description</h4>
                                <p class="whitespace-pre-line text-slate-300">
                                    {{ $project->description ?? 'No description provided.' }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Deadline
                                    </h4>
                                    <p class="text-lg font-medium text-white">
                                        {{ $project->deadline ? $project->deadline->format('M d, Y') : 'No Deadline' }}
                                    </p>
                                </div>
                                <div class="bg-white/5 p-4 rounded-lg border border-white/10">
                                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-1">Created
                                        At</h4>
                                    <p class="text-lg font-medium text-white">
                                        {{ $project->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Tasks Tab -->
                        <div x-show="tab === 'tasks'" style="display: none;">
                            <livewire:project-tasks :project="$project" />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('projects.edit', $project) }}"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 text-white rounded-lg shadow-lg shadow-indigo-500/30 ring-1 ring-indigo-500/50 transition-colors backdrop-blur-sm">Edit
                            Project</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this project?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="px-4 py-2 bg-rose-600 hover:bg-rose-500 text-white rounded-lg shadow-lg shadow-rose-500/30 ring-1 ring-rose-500/50 transition-colors backdrop-blur-sm">Delete
                                Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>