<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Project Details') }}
            </h2>
            <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h3 class="text-2xl font-bold">{{ $project->name }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Client: {{ $project->client->company_name ?? $project->client->name }}</p>
                        </div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($project->status === 'completed') bg-green-100 text-green-800 
                            @elseif($project->status === 'in_progress') bg-blue-100 text-blue-800 
                            @elseif($project->status === 'on_hold') bg-yellow-100 text-yellow-800 
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                        </span>
                    </div>

                <div x-data="{ tab: 'overview' }">
                    <!-- Tabs Navigation -->
                    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                        <nav class="-mb-px flex space-x-8">
                            <button @click="tab = 'overview'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'overview'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Overview
                            </button>
                            <button @click="tab = 'tasks'" :class="{'border-indigo-500 text-indigo-600 dark:text-indigo-400': tab === 'tasks', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300': tab !== 'tasks'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition">
                                Tasks ({{ $project->tasks()->count() }})
                            </button>
                        </nav>
                    </div>

                    <!-- Overview Tab -->
                    <div x-show="tab === 'overview'" class="space-y-6">
                        <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-lg">
                            <h4 class="text-lg font-medium mb-2">Description</h4>
                            <p class="whitespace-pre-line text-gray-700 dark:text-gray-300">{{ $project->description ?? 'No description provided.' }}</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <h4 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Deadline</h4>
                                <p class="text-lg font-medium">{{ $project->deadline ? $project->deadline->format('M d, Y') : 'No Deadline' }}</p>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-lg">
                                <h4 class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Created At</h4>
                                <p class="text-lg font-medium">{{ $project->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks Tab -->
                    <div x-show="tab === 'tasks'" style="display: none;">
                        <livewire:project-tasks :project="$project" />
                    </div>
                </div>

                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">Edit Project</a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">Delete Project</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
