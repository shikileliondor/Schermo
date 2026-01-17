@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <form method="GET" class="flex flex-wrap gap-3">
            <input name="search" value="{{ request('search') }}" placeholder="Rechercher une école" class="w-64 rounded-lg border border-slate-200 px-3 py-2 text-sm" />
            <select name="status" class="rounded-lg border border-slate-200 px-3 py-2 text-sm">
                <option value="">Tous les statuts</option>
                <option value="active" @selected(request('status') === 'active')>Actif</option>
                <option value="suspended" @selected(request('status') === 'suspended')>Suspendu</option>
            </select>
            <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Filtrer</button>
        </form>
        <a href="{{ route('admin.schools.create') }}" class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Nouvelle école</a>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
            <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <th class="px-4 py-3">École</th>
                <th class="px-4 py-3">Contact</th>
                <th class="px-4 py-3">Statut</th>
                <th class="px-4 py-3">Actions</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm">
            @forelse ($schools as $school)
                <tr>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-slate-800">{{ $school->name }}</div>
                        <div class="text-xs text-slate-500">{{ $school->data['code'] ?? '—' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <div>{{ $school->data['email'] ?? '—' }}</div>
                        <div class="text-xs text-slate-500">{{ $school->data['phone'] ?? '—' }}</div>
                    </td>
                    <td class="px-4 py-3">
                        @php($status = $school->status())
                        <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $status === 'active' ? 'Actif' : 'Suspendu' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.schools.show', $school) }}" class="text-xs font-semibold text-slate-700">Détails</a>
                            <form method="POST" action="{{ route('admin.schools.toggle', $school) }}">
                                @csrf
                                @method('PATCH')
                                <button class="text-xs font-semibold text-indigo-600">{{ $school->isActive() ? 'Suspendre' : 'Activer' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.schools.destroy', $school) }}" onsubmit="return confirm('Supprimer cette école ?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs font-semibold text-rose-600">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500">Aucune école enregistrée.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $schools->links() }}</div>
@endsection
