<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2.5 bg-slate-900 dark:bg-slate-100 border border-transparent rounded-lg font-medium text-sm text-white dark:text-slate-900 hover:bg-slate-800 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-slate-900 dark:focus:ring-slate-300 focus:ring-offset-2 dark:focus:ring-offset-slate-900 transition-all duration-150 shadow-xs active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer']) }}>
    {{ $slot }}
</button>

