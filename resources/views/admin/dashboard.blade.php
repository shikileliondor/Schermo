@extends('admin.layouts.app')

@section('content')
    <div class="grid gap-6 md:grid-cols-4">
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase text-slate-500">Total écoles</p>
            <p class="mt-2 text-2xl font-semibold">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase text-slate-500">Écoles actives</p>
            <p class="mt-2 text-2xl font-semibold text-emerald-600">{{ $stats['active'] }}</p>
        </div>
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase text-slate-500">Écoles suspendues</p>
            <p class="mt-2 text-2xl font-semibold text-amber-600">{{ $stats['suspended'] }}</p>
        </div>
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <p class="text-xs uppercase text-slate-500">Dernière création</p>
            <p class="mt-2 text-sm font-semibold text-slate-700">
                {{ $stats['latest_created_at'] ?? '—' }}
            </p>
        </div>
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold">Actions rapides</h2>
            <p class="text-sm text-slate-500 mt-1">Créer une nouvelle école ou un administrateur.</p>

            <div class="mt-4 flex flex-wrap gap-3">
                <a href="{{ route('admin.schools.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Nouvelle école</a>
                <a href="{{ route('admin.school-admins.create') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Nouvel admin</a>
            </div>
        </div>
        <div class="rounded-xl bg-white p-6 shadow-sm">
            <h2 class="text-base font-semibold">Suivi technique</h2>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                <li>✅ Super Admin unique avec accès global.</li>
                <li>✅ Tenants gérés via stancl/tenancy.</li>
                <li>✅ Actions critiques journalisées.</li>
            </ul>
        </div>
    </div>
@endsection
