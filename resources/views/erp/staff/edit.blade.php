<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Modifier le personnel</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.staff.update', $staff) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $staff->first_name) }}" class="mt-1 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $staff->last_name) }}" class="mt-1 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Poste</label>
                        <input type="text" name="position" value="{{ old('position', $staff->position) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email', $staff->email) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $staff->phone) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Date d'embauche</label>
                        <input type="date" name="hired_at" value="{{ old('hired_at', optional($staff->hired_at)->format('Y-m-d')) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Contrat (PDF)</label>
                        <input type="file" name="contract" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Actif</label>
                        <input type="checkbox" name="active" value="1" class="mt-2" @checked(old('active', $staff->active))>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Classes</label>
                        <select name="classes[]" multiple class="mt-1 w-full rounded">
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(collect(old('classes', $staff->classes->pluck('id')->all()))->contains($class->id))>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Matières</label>
                        <select name="subjects[]" multiple class="mt-1 w-full rounded">
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}" @selected(collect(old('subjects', $staff->subjects->pluck('id')->all()))->contains($subject->id))>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.staff.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
