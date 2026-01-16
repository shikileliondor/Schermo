<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Staff</h2>
            <a href="{{ route('erp.staff.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Nouveau personnel</a>
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
                            <th class="text-left px-4 py-2">Nom</th>
                            <th class="text-left px-4 py-2">Poste</th>
                            <th class="text-left px-4 py-2">Classes</th>
                            <th class="text-left px-4 py-2">Matières</th>
                            <th class="text-right px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($staff as $member)
                            <tr>
                                <td class="px-4 py-2 text-gray-900 dark:text-gray-100">{{ $member->last_name }} {{ $member->first_name }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">{{ $member->position ?? '—' }}</td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">
                                    {{ $member->classes->pluck('name')->implode(', ') ?: '—' }}
                                </td>
                                <td class="px-4 py-2 text-gray-600 dark:text-gray-300">
                                    {{ $member->subjects->pluck('name')->implode(', ') ?: '—' }}
                                </td>
                                <td class="px-4 py-2 text-right space-x-2">
                                    @if ($member->contract_path)
                                        <a href="{{ route('erp.staff.contract', $member) }}" class="text-indigo-600">Contrat</a>
                                    @endif
                                    <a href="{{ route('erp.staff.edit', $member) }}" class="text-blue-600">Modifier</a>
                                    <form action="{{ route('erp.staff.destroy', $member) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600" onclick="return confirm('Supprimer ce membre ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Aucun personnel.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $staff->links() }}
        </div>
    </div>
</x-app-layout>
