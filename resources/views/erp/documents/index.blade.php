<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Documents</h2>
            <a href="{{ route('erp.documents.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nouveau document</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="text-left px-4 py-2">Titre</th>
                            <th class="text-left px-4 py-2">Type</th>
                            <th class="text-left px-4 py-2">Élève</th>
                            <th class="text-left px-4 py-2">Staff</th>
                            <th class="text-right px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($documents as $document)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $document->title }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $document->type }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $document->student?->last_name ?? '—' }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $document->staff?->last_name ?? '—' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('erp.documents.download', $document) }}" class="text-indigo-600">Télécharger</a>
                                    <a href="{{ route('erp.documents.edit', $document) }}" class="text-blue-600">Modifier</a>
                                    <form action="{{ route('erp.documents.destroy', $document) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" onclick="return confirm('Supprimer ce document ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Aucun document.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $documents->links() }}
        </div>
    </div>
</x-app-layout>
