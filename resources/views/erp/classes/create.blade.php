<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Nouvelle classe</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.classes.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nom</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded" required>
                    @error('name')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Niveau</label>
                    <input type="text" name="level" value="{{ old('level') }}" class="mt-1 w-full rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" class="mt-1 w-full rounded" rows="3">{{ old('description') }}</textarea>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.classes.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
