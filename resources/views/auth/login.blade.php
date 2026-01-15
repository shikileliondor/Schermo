<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex items-center justify-center min-h-screen">
        <main class="w-full max-w-md rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] p-8 shadow-sm">
            <h1 class="text-xl font-semibold mb-2">Login</h1>
            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mb-6">
                Authentication is not configured yet. Please contact an administrator to enable sign-in.
            </p>
            <a
                href="{{ url('/') }}"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-[#f53003] px-4 py-2 text-sm font-medium text-white hover:bg-[#dd2a02]"
            >
                Return to home
            </a>
        </main>
    </body>
</html>
