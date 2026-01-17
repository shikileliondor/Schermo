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
        </div>

        <div class="space-y-6">
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
