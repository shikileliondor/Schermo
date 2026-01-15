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
                Sign in with your super admin credentials.
            </p>

            @if ($errors->any())
                <div class="mb-4 rounded-md border border-[#fca5a5] bg-[#fef2f2] p-3 text-sm text-[#b91c1c]">
                    <ul class="list-disc space-y-1 pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label class="text-sm font-medium" for="email">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required
                        class="w-full rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm text-[#1b1b18] shadow-sm focus:border-[#f53003] focus:outline-none focus:ring-1 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#1f1f1f] dark:text-white"
                    >
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium" for="password">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="current-password"
                        required
                        class="w-full rounded-md border border-[#e3e3e0] bg-white px-3 py-2 text-sm text-[#1b1b18] shadow-sm focus:border-[#f53003] focus:outline-none focus:ring-1 focus:ring-[#f53003] dark:border-[#3E3E3A] dark:bg-[#1f1f1f] dark:text-white"
                    >
                </div>

                <label class="flex items-center gap-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    <input
                        type="checkbox"
                        name="remember"
                        class="rounded border-[#e3e3e0] text-[#f53003] focus:ring-[#f53003] dark:border-[#3E3E3A]"
                    >
                    Remember me
                </label>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-[#f53003] px-4 py-2 text-sm font-medium text-white hover:bg-[#dd2a02]"
                >
                    Log in
                </button>
            </form>
        </main>
    </body>
</html>
