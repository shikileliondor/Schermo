<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Nouveau document</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.documents.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Titre</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="mt-1 w-full rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Type</label>
                    <input type="text" name="type" value="{{ old('type') }}" class="mt-1 w-full rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Élève</label>
                    <select name="student_id" class="mt-1 w-full rounded">
                        <option value="">Aucun</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->last_name }} {{ $student->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Staff</label>
                    <select name="staff_id" class="mt-1 w-full rounded">
                        <option value="">Aucun</option>
                        @foreach ($staff as $member)
                            <option value="{{ $member->id }}" @selected(old('staff_id') == $member->id)>
                                {{ $member->last_name }} {{ $member->first_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Fichier</label>
                    <input type="file" name="file" class="mt-1 w-full rounded" required>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.documents.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
