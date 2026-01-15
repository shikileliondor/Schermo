@extends('admin.layouts.app')

@section('content')
    <div class="max-w-2xl rounded-xl bg-white p-6 shadow-sm">
        <form method="POST" action="{{ route('admin.school-admins.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm font-semibold text-slate-700">Nom</label>
                <input name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required />
                @error('name')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required />
                @error('email')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm font-semibold text-slate-700">École</label>
                <select name="school_id" class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm" required>
                    <option value="">Sélectionner</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" @selected(old('school_id') === $school->id)>{{ $school->name }}</option>
                    @endforeach
                </select>
                @error('school_id')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3">
                <button class="rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Créer l'admin</button>
                <a href="{{ route('admin.school-admins.index') }}" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700">Annuler</a>
            </div>
        </form>
    </div>
@endsection
