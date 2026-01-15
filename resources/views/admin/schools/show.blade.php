@extends('admin.layouts.app')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold">Informations générales</h2>
                <div class="mt-4 grid gap-4 md:grid-cols-2 text-sm text-slate-600">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Nom</p>
                        <p class="font-semibold text-slate-800">{{ $school->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Code</p>
                        <p class="font-semibold text-slate-800">{{ $school->data['code'] ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Email</p>
                        <p class="font-semibold text-slate-800">{{ $school->data['email'] ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Téléphone</p>
                        <p class="font-semibold text-slate-800">{{ $school->data['phone'] ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold">Actions techniques</h2>
                <p class="mt-2 text-sm text-slate-500">Lancez les opérations techniques sans exposer le mot de passe.</p>
                <div class="mt-4 flex flex-wrap gap-3">
                    <form method="POST" action="{{ route('admin.schools.migrations', $school) }}">
                        @csrf
                        <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Exécuter les migrations</button>
                    </form>
                    <form method="POST" action="{{ route('admin.schools.seeders', $school) }}">
                        @csrf
                        <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Relancer les seeders</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold">Connexion base</h2>
                <div class="mt-4 space-y-3 text-sm text-slate-600">
                    <div>
                        <p class="text-xs uppercase text-slate-400">Hôte</p>
                        <p class="font-semibold text-slate-800">{{ $connection['host'] ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Port</p>
                        <p class="font-semibold text-slate-800">{{ $connection['port'] ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Base</p>
                        <p class="font-semibold text-slate-800">{{ $school->database }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-slate-400">Utilisateur</p>
                        <p class="font-semibold text-slate-800">{{ $connection['username'] ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow-sm">
                <h2 class="text-base font-semibold">Statut</h2>
                <div class="mt-4">
                    <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $school->isActive() ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                        {{ $school->isActive() ? 'Actif' : 'Suspendu' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
