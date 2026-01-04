<header class="sticky top-0 z-30 flex items-center justify-between px-6 py-4 glass-header transition-all duration-300">
    <div class="flex items-center flex-1 max-w-lg">
        <livewire:global-search />
    </div>

    <div class="flex items-center space-x-4">
        <!-- Theme Toggle -->
        <button @click="darkMode = !darkMode" type="button"
            class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-white/5 dark:hover:text-slate-200 transition-colors focus:outline-none">
            <!-- Sun (for Dark Mode) -->
            <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <!-- Moon (for Light Mode) -->
            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>

        <!-- Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-3 focus:outline-none group">
                <div class="text-right hidden sm:block">
                    <div
                        class="text-sm font-medium text-slate-700 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="text-xs text-slate-500">Admin</div>
                </div>
                <div class="relative">
                    <img class="h-10 w-10 rounded-full object-cover border-2 border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-indigo-500 transition-all duration-200"
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff"
                        alt="Avatar">
                    <div
                        class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900">
                    </div>
                </div>
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95" @click.away="open = false"
                class="absolute right-0 mt-2 w-56 glass rounded-xl shadow-2xl py-2 z-50 divide-y divide-gray-100 dark:divide-white/5 transform origin-top-right text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800"
                style="display: none;">

                <div class="px-4 py-3">
                    <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Signed in as</p>
                    <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ Auth::user()->email }}</p>
                </div>

                <div class="py-1">
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-slate-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </a>
                </div>

                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10 hover:text-red-700 dark:hover:text-red-300 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Log Out
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>