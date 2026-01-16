<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Matières</h2>
            <a href="{{ route('erp.subjects.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nouvelle matière</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if (session('status'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow rounded">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        <tr>
                            <th class="text-left px-4 py-2">Nom</th>
                            <th class="text-left px-4 py-2">Code</th>
                            <th class="text-left px-4 py-2">Coefficient</th>
                            <th class="text-right px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($subjects as $subject)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $subject->name }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $subject->code ?? '—' }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $subject->coefficient }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('erp.subjects.edit', $subject) }}" class="text-blue-600">Modifier</a>
                                    <form action="{{ route('erp.subjects.destroy', $subject) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 ml-2" onclick="return confirm('Supprimer cette matière ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500">Aucune matière.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $subjects->links() }}
        </div>
    </div>
</x-app-layout>
