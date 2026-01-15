@extends('admin.layouts.app')

@section('content')
    <div class="max-w-2xl rounded-xl bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.schools.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-700">Nom de l'école</label>
                <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required />
                @error('name')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Code école</label>
                <input name="code" value="{{ old('code') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required />
                @error('code')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required />
                @error('email')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Téléphone</label>
                <input name="phone" value="{{ old('phone') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required />
                @error('phone')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Statut</label>
                <select name="status" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm">
                    <option value="active" @selected(old('status', 'active') === 'active')>Actif</option>
                    <option value="suspended" @selected(old('status') === 'suspended')>Suspendu</option>
                </select>
            </div>
            <div class="flex gap-3">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Créer l'école</button>
                <a href="{{ route('admin.schools.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Annuler</a>
            </div>
        </form>
    </div>
@endsection
