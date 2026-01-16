<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Élèves</h2>
            <a href="{{ route('erp.students.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nouvel élève</a>
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
                            <th class="text-left px-4 py-2">Matricule</th>
                            <th class="text-left px-4 py-2">Nom</th>
                            <th class="text-left px-4 py-2">Classe</th>
                            <th class="text-left px-4 py-2">Contact parent</th>
                            <th class="text-right px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($students as $student)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $student->matricule }}</td>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $student->last_name }} {{ $student->first_name }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $student->schoolClass?->name ?? '—' }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $student->parent_phone ?? '—' }}</td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    <a href="{{ route('erp.students.bulletin', $student) }}" class="text-indigo-600">PDF</a>
                                    <a href="{{ route('erp.students.edit', $student) }}" class="text-blue-600">Modifier</a>
                                    <form action="{{ route('erp.students.destroy', $student) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" onclick="return confirm('Supprimer cet élève ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Aucun élève.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>
