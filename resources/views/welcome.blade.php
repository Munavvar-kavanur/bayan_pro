<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Bayan Pro') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-glow {
            background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.15) 0%, rgba(0, 0, 0, 0) 50%);
        }
    </style>
</head>

<body class="antialiased bg-slate-950 text-white min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Background Decoration -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl opacity-50 mix-blend-screen animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl opacity-50 mix-blend-screen">
        </div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full hero-glow z-0"></div>
    </div>

    <!-- Navbar -->
    @if (Route::has('login'))
        <nav class="relative z-50 w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-white">
                    B</div>
                <span class="text-xl font-bold tracking-tight">Bayan Pro</span>
            </div>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="px-5 py-2.5 rounded-full bg-white/10 hover:bg-white/20 transition backdrop-blur-md border border-white/10 text-sm font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white transition text-sm font-medium">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 rounded-full bg-indigo-600 hover:bg-indigo-500 transition shadow-lg shadow-indigo-500/25 text-sm font-medium">
                            Get Started
                        </a>
                    @endif
                @endauth
            </div>
        </nav>
    @endif

    <!-- Hero Section -->
    <main
        class="relative z-10 flex-grow flex flex-col justify-center items-center px-6 pt-10 pb-20 text-center max-w-5xl mx-auto">
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-950/50 border border-indigo-500/30 text-indigo-300 text-xs font-semibold uppercase tracking-wider mb-8 animate-fade-in-up">
            <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
            v1.0 Now Available
        </div>

        <h1 class="text-5xl md:text-7xl font-bold tracking-tight mb-6 leading-tight">
            Manage your <span class="gradient-text">Studio Business</span> <br class="hidden md:block" /> with
            confidence.
        </h1>

        <p class="text-lg md:text-xl text-slate-400 max-w-2xl mb-10 leading-relaxed">
            From client onboarding to final invoice, Bayan Pro streamlines your entire workflow.
            Track projects, manage tasks, and get paid faster.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
            <a href="{{ route('login') }}"
                class="px-8 py-4 rounded-xl bg-white text-slate-900 font-bold hover:bg-slate-200 transition shadow-xl shadow-white/10 flex items-center justify-center gap-2 group">
                Try Demo
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
            <a href="#features"
                class="px-8 py-4 rounded-xl glass hover:bg-white/10 transition font-medium text-white flex items-center justify-center">
                Learn more
            </a>
        </div>

        <!-- Dashboard Preview (Mockup) -->
        <div
            class="mt-20 relative rounded-xl border border-white/10 bg-slate-900/50 backdrop-blur-xl p-4 shadow-2xl shadow-indigo-500/10">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500/30 rounded-full blur-2xl"></div>
            <div
                class="relative rounded-lg overflow-hidden border border-white/5 bg-slate-900 aspect-video w-full max-w-4xl mx-auto flex items-center justify-center group">
                <!-- Placeholder for a dashboard screenshot -->
                <div class="text-center p-10">
                    <div class="grid grid-cols-3 gap-6 opacity-50 group-hover:opacity-100 transition duration-700">
                        <!-- Mockup Cards -->
                        <div class="h-32 bg-slate-800 rounded-lg border border-slate-700 w-48"></div>
                        <div class="h-32 bg-slate-800 rounded-lg border border-slate-700 w-48 mt-8"></div>
                        <div class="h-32 bg-slate-800 rounded-lg border border-slate-700 w-48"></div>
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-slate-500 font-mono text-sm">Dashboard Interface Preview</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section id="features" class="relative z-10 py-24 bg-slate-950/50 backdrop-blur-sm border-t border-white/5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold mb-4">Everything you need to run your business</h2>
                <p class="text-slate-400">Everything handled in one unified dashboard.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl glass hover:bg-white/5 transition group cursor-default">
                    <div
                        class="w-12 h-12 rounded-lg bg-indigo-500/20 text-indigo-400 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Client Management</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Keep track of all your clients in one place. Store contact details, notes, and project history
                        effortlessly.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl glass hover:bg-white/5 transition group cursor-default">
                    <div
                        class="w-12 h-12 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Project Tracking</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Manage tasks, set deadlines, and monitor progress. Never miss a milestone with our intuitive
                        project boards.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl glass hover:bg-white/5 transition group cursor-default">
                    <div
                        class="w-12 h-12 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center mb-6 group-hover:scale-110 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Invoicing & Quotes</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Generate professional invoices and quotations in seconds. Track payments and manage your
                        finances ease.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="relative z-10 py-12 border-t border-white/5 bg-slate-950 text-slate-500 text-sm">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
            <p>&copy; {{ date('Y') }} Bayan Pro. All rights reserved.</p>
            <div class="flex gap-6">
                <a href="#" class="hover:text-white transition">Privacy Policy</a>
                <a href="#" class="hover:text-white transition">Terms of Service</a>
                <a href="#" class="hover:text-white transition">Contact Support</a>
            </div>
        </div>
    </footer>

</body>

</html>