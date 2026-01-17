<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Modifier la matière</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.subjects.update', $subject) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium">Nom</label>
                    <input type="text" name="name" value="{{ old('name', $subject->name) }}" class="mt-1 w-full rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Code</label>
                    <input type="text" name="code" value="{{ old('code', $subject->code) }}" class="mt-1 w-full rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Coefficient</label>
                    <input type="number" name="coefficient" value="{{ old('coefficient', $subject->coefficient) }}" class="mt-1 w-full rounded">
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.subjects.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
