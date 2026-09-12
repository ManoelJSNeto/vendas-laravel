<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script>
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 dark:text-slate-100 bg-slate-50 dark:bg-slate-950 min-h-screen">
        <div class="min-h-screen flex flex-col sm:justify-center items-center px-4 py-8 sm:px-6">
            <div class="mb-6 flex flex-col items-center">
                <a href="/" class="flex items-center gap-2 group">
                    <x-application-logo class="w-12 h-12 text-navy-800 dark:text-sky-400 group-hover:scale-105 transition-transform" />
                    <span class="text-xl font-bold tracking-tight text-slate-900 dark:text-white">Vendas Laravel</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm rounded-xl p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
