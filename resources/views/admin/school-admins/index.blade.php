@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <input name="search" value="{{ request('search') }}" placeholder="Rechercher un admin" class="w-64 rounded-lg border border-slate-200 px-3 py-2 text-sm" />
            <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Filtrer</button>
        </form>
        <a href="{{ route('admin.school-admins.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Nouvel admin</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <th class="px-4 py-3">Admin</th>
                <th class="px-4 py-3">École</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm">
            @forelse ($admins as $admin)
                <tr>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-slate-800">{{ $admin->name }}</div>
                        <div class="text-xs text-slate-500">{{ $admin->email }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-slate-800">{{ $admin->school?->name ?? '—' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $admin->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $admin->is_active ? 'Actif' : 'Suspendu' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('admin.school-admins.toggle', $admin) }}">
                                @csrf
                                @method('PATCH')
                                <button class="text-xs font-semibold text-indigo-600">{{ $admin->is_active ? 'Désactiver' : 'Activer' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.school-admins.reset', $admin) }}">
                                @csrf
                                <button class="text-xs font-semibold text-slate-600">Réinitialiser le mot de passe</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Aucun administrateur enregistré.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $admins->links() }}</div>
@endsection
