@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-900/50 border-white/10 text-white focus:border-indigo-500 focus:ring-indigo-500 rounded-lg shadow-sm placeholder-slate-500']) }}>