<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg font-medium text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700/60 focus:outline-none focus:ring-2 focus:ring-slate-400 dark:focus:ring-slate-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-150 shadow-xs active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer']) }}>
    {{ $slot }}
</button>

