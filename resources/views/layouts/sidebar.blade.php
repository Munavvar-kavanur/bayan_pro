<div class="flex flex-col w-64 h-screen px-4 py-8 glass-sidebar transition-all duration-300">
    <div class="flex items-center justify-center mb-10 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center justify-center group w-full gap-2">
            <div
                class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white text-xl shadow-lg shadow-indigo-500/20">
                B</div>
            <span
                class="text-xl font-bold tracking-tight text-slate-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-300 transition-colors">Bayan
                Pro</span>
        </a>
    </div>

    <div class="flex flex-col justify-between flex-1 overflow-y-auto">
        <nav class="space-y-2">
            @php
                $navLinks = [
                    ['route' => 'dashboard', 'label' => 'Dashboard', 'icon' => 'M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17', 'active' => request()->routeIs('dashboard')],
                    ['route' => 'clients.index', 'label' => 'Clients', 'icon' => 'M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z', 'active' => request()->routeIs('clients.*')],
                    ['route' => 'projects.index', 'label' => 'Projects', 'icon' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z', 'active' => request()->routeIs('projects.*')],
                    ['route' => 'invoices.index', 'label' => 'Invoices', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'active' => request()->routeIs('invoices.*')],
                    ['route' => 'quotations.index', 'label' => 'Quotations', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01', 'active' => request()->routeIs('quotations.*')],
                    ['route' => 'settings.index', 'label' => 'Settings', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z', 'active' => request()->routeIs('settings.*')],
                ];
            @endphp

            @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}"
                        class="flex items-center px-4 py-3 transition-all duration-200 transform rounded-lg group
                                                  {{ $link['active']
                ? 'bg-indigo-50 dark:bg-transparent dark:bg-gradient-to-r dark:from-indigo-500/20 dark:to-purple-500/20 border-l-2 border-indigo-500 text-indigo-700 dark:text-white shadow-sm dark:shadow-indigo-500/10'
                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white' }}">
                        <svg class="w-5 h-5 transition-colors duration-200 {{ $link['active'] ? 'text-indigo-600 dark:text-indigo-400' : 'text-slate-500 dark:text-slate-500 group-hover:text-indigo-500 dark:group-hover:text-slate-300' }}"
                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="{{ $link['icon'] }}" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                        <span class="mx-4 font-medium">{{ $link['label'] }}</span>
                    </a>
            @endforeach
        </nav>
    </div>
</div>