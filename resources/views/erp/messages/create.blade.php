<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Nouveau message</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.messages.store') }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Canal</label>
                    <select name="channel" class="mt-1 w-full rounded" required>
                        <option value="email" @selected(old('channel') === 'email')>Email</option>
                        <option value="sms" @selected(old('channel') === 'sms')>SMS</option>
                    </select>
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
                    <label class="block text-sm font-medium">Sujet</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" class="mt-1 w-full rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Contenu</label>
                    <textarea name="content" class="mt-1 w-full rounded" rows="4" required>{{ old('content') }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Statut</label>
                    <select name="status" class="mt-1 w-full rounded" required>
                        <option value="draft" @selected(old('status') === 'draft')>Brouillon</option>
                        <option value="sent" @selected(old('status') === 'sent')>Envoyé</option>
                    </select>
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.messages.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
