@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 dark:bg-slate-900/50 border-slate-300 dark:border-white/10 text-slate-800 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm placeholder-slate-400 dark:placeholder-slate-500']) }}>