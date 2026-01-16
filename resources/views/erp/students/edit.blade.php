<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Modifier l'élève</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.students.update', $student) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Matricule</label>
                        <input type="text" name="matricule" value="{{ old('matricule', $student->matricule) }}" class="mt-1 w-full rounded" required>
                        @error('matricule')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Classe</label>
                        <select name="class_id" class="mt-1 w-full rounded">
                            <option value="">Aucune</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id) == $class->id)>{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name) }}" class="mt-1 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name) }}" class="mt-1 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Date de naissance</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', optional($student->birth_date)->format('Y-m-d')) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Genre</label>
                        <input type="text" name="gender" value="{{ old('gender', $student->gender) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $student->phone) }}" class="mt-1 w-full rounded">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium">Adresse</label>
                        <input type="text" name="address" value="{{ old('address', $student->address) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Nom du parent</label>
                        <input type="text" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Téléphone parent</label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email parent</label>
                        <input type="email" name="parent_email" value="{{ old('parent_email', $student->parent_email) }}" class="mt-1 w-full rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Photo</label>
                        <input type="file" name="photo" class="mt-1 w-full rounded">
                    </div>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.students.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
