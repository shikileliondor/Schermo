<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Nouvelle note</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.grades.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Élève</label>
                    <select name="student_id" class="mt-1 w-full rounded" required>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->last_name }} {{ $student->first_name }} ({{ $student->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Matière</label>
                    <select name="subject_id" class="mt-1 w-full rounded" required>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}" @selected(old('subject_id') == $subject->id)>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Trimestre</label>
                    <input type="text" name="term" value="{{ old('term') }}" class="mt-1 w-full rounded" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Note</label>
                        <input type="number" step="0.01" name="score" value="{{ old('score') }}" class="mt-1 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Barème</label>
                        <input type="number" step="0.01" name="max_score" value="{{ old('max_score', 20) }}" class="mt-1 w-full rounded">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Appréciation</label>
                    <textarea name="appreciation" class="mt-1 w-full rounded" rows="3">{{ old('appreciation') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Date de saisie</label>
                    <input type="date" name="recorded_at" value="{{ old('recorded_at') }}" class="mt-1 w-full rounded">
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.grades.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
