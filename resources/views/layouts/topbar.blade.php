<header class="sticky top-0 z-30 flex items-center justify-between px-6 py-4 bg-white/80 border-b border-gray-200 backdrop-blur-md dark:bg-gray-800/90 dark:border-gray-700 transition-colors duration-300">
    <div class="flex items-center">
        <div class="relative mx-4 lg:mx-0 group">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" viewBox="0 0 24 24" fill="none">
                    <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <input class="w-32 pl-10 pr-4 py-2 text-sm text-gray-600 bg-gray-100 border-none rounded-full focus:bg-white focus:ring-2 focus:ring-blue-500 placeholder-gray-400 sm:w-64 dark:bg-gray-700 dark:text-gray-200 dark:focus:bg-gray-600 transition-all duration-200" type="text" placeholder="Search...">
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- Dark Mode Toggler -->
        <button x-data="{
            darkMode: localStorage.getItem('darkMode') === 'true',
            toggle() {
                this.darkMode = !this.darkMode;
                localStorage.setItem('darkMode', this.darkMode);
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            },
            init() {
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                }
            }
        }" x-init="init()" @click="toggle()" class="p-2 text-gray-500 rounded-full hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            <svg x-show="!darkMode" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
            <svg x-show="darkMode" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </button>

        <!-- Profile Dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none group">
                <div class="text-right hidden sm:block">
                    <div class="text-sm font-medium text-gray-700 dark:text-gray-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">Admin</div>
                </div>
                <img class="h-10 w-10 rounded-full object-cover border-2 border-white dark:border-gray-700 shadow-sm group-hover:border-blue-500 transition-all duration-200" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff" alt="Avatar">
            </button>

            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.away="open = false" 
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-1 z-50 ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 dark:divide-gray-700 transform origin-top-right" 
                 style="display: none;">
                
                <div class="px-4 py-3">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Signed in as</p>
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">{{ Auth::user()->email }}</p>
                </div>

                <div class="py-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Profile</a>
                </div>
                
                <div class="py-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">Log Out</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
