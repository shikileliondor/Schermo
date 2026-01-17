<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schermo Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 text-slate-900">
<div class="min-h-screen flex">
    <aside class="w-64 bg-white border-r border-slate-200 px-6 py-8">
        <div class="text-xl font-semibold text-slate-900">Schermo Admin</div>
        <p class="text-sm text-slate-500 mt-1">Supervision des établissements</p>

        <nav class="mt-8 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.schools.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.schools.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Écoles
            </a>
            <a href="{{ route('admin.school-admins.index') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.school-admins.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Administrateurs
            </a>
            <a href="{{ route('admin.settings') }}" class="flex items-center px-3 py-2 rounded-lg text-sm font-medium {{ request()->routeIs('admin.settings') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}">
                Paramètres
            </a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white border-b border-slate-200 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold">{{ $pageTitle ?? 'Dashboard' }}</h1>
                <p class="text-sm text-slate-500">{{ $pageDescription ?? '' }}</p>
            </div>
            <div class="text-sm text-slate-600">
                {{ auth()->user()?->name }}
            </div>
        </header>

        <main class="flex-1 px-8 py-6">
            @include('admin.partials.flash')
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
