<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('ERP Scolaire') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
                    <p class="text-sm text-gray-500">Élèves</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['students'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
                    <p class="text-sm text-gray-500">Staff</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $stats['staff'] }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
                    <p class="text-sm text-gray-500">Total frais</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['payments_due'], 2, ',', ' ') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
                    <p class="text-sm text-gray-500">Total payé</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ number_format($stats['payments_paid'], 2, ',', ' ') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow rounded p-4">
                    <p class="text-sm text-gray-500">Moyenne générale</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ $stats['average_grade'] !== null ? number_format($stats['average_grade'], 2, ',', ' ') : 'N/A' }}
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Gestion rapide</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.students.index') }}">Élèves</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.staff.index') }}">Staff</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.classes.index') }}">Classes</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.subjects.index') }}">Matières</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.grades.index') }}">Bulletins / Notes</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.payments.index') }}">Paiements</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.documents.index') }}">Documents</a>
                    <a class="block border border-gray-200 dark:border-gray-700 rounded p-4 hover:bg-gray-50 dark:hover:bg-gray-700" href="{{ route('erp.messages.index') }}">Messages</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
