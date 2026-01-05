<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bayan Pro') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        /* Light Mode Defaults */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            /* slate-200 */
        }

        /* Dark Mode Overrides */
        .dark .glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased bg-slate-50 dark:bg-slate-950 transition-colors duration-300">
    <!-- Background Decoration (Dark Mode Only) -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden hidden dark:block">
        <div class="absolute top-0 left-0 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl opacity-30 mix-blend-screen">
        </div>
        <div
            class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl opacity-30 mix-blend-screen">
        </div>
    </div>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
        <div>
            <a href="/" class="flex flex-col items-center">
                <div
                    class="w-16 h-16 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white text-3xl shadow-lg shadow-indigo-500/30 mb-4">
                    B
                </div>
                <span class="text-2xl font-bold tracking-tight text-slate-800 dark:text-white">Bayan Pro</span>
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-8 glass shadow-2xl overflow-hidden sm:rounded-3xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>