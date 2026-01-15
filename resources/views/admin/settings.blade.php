@extends('admin.layouts.app')

@section('content')
    <div class="rounded-xl bg-white p-6 shadow-sm">
        <h2 class="text-base font-semibold">Paramètres généraux</h2>
        <p class="mt-2 text-sm text-slate-500">Cet espace est prêt pour accueillir la configuration avancée du dashboard.</p>
        <div class="mt-4 grid gap-4 md:grid-cols-2 text-sm text-slate-600">
            <div class="rounded-lg border border-slate-200 p-4">
                <p class="font-semibold text-slate-800">Sécurité</p>
                <p class="text-xs text-slate-500 mt-1">Accès réservé au Super Admin avec middleware dédié.</p>
            </div>
            <div class="rounded-lg border border-slate-200 p-4">
                <p class="font-semibold text-slate-800">Tenants</p>
                <p class="text-xs text-slate-500 mt-1">Gestion centralisée des connexions et de la configuration.</p>
            </div>
        </div>
    </div>
@endsection
