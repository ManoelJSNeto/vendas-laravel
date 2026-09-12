@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-slate-100 focus:border-slate-900 dark:focus:border-slate-300 focus:ring-1 focus:ring-slate-900 dark:focus:ring-slate-300 rounded-lg shadow-xs text-sm placeholder:text-slate-400 dark:placeholder:text-slate-500 disabled:bg-slate-100 dark:disabled:bg-slate-800 disabled:text-slate-500 dark:disabled:text-slate-400 disabled:cursor-not-allowed transition-colors']) }}>

