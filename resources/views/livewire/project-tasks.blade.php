<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100">Tasks</h3>
    </div>
    
    <div class="p-4">
        <!-- Add Task Form -->
        <form wire:submit.prevent="addTask" class="flex gap-2 mb-6">
            <input type="text" wire:model="content" placeholder="Add a new task..." class="flex-1 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition disabled:opacity-50" wire:loading.attr="disabled">
                Add
            </button>
        </form>

        <!-- Task List -->
        <div class="space-y-3">
            @forelse($tasks as $task)
                <div class="flex items-center justify-between group p-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-md transition" wire:key="task-{{ $task->id }}">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" 
                               wire:click="toggle({{ $task->id }})" 
                               {{ $task->is_completed ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer">
                        <span class="{{ $task->is_completed ? 'line-through text-gray-400 dark:text-gray-500' : 'text-gray-700 dark:text-gray-200' }}">
                            {{ $task->content }}
                        </span>
                    </div>
                    <button wire:click="delete({{ $task->id }})" class="text-gray-400 hover:text-red-500 dark:hover:text-red-400 opacity-0 group-hover:opacity-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            @empty
                <div class="text-center text-gray-400 py-4">
                    No tasks yet. Add one above!
                </div>
            @endforelse
        </div>
    </div>
</div>
