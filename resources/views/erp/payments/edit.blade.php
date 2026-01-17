<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Modifier le paiement</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('erp.payments.update', $payment) }}" method="POST" class="bg-white dark:bg-gray-800 shadow rounded p-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium">Élève</label>
                    <select name="student_id" class="mt-1 w-full rounded" required>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id', $payment->student_id) == $student->id)>
                                {{ $student->last_name }} {{ $student->first_name }} ({{ $student->matricule }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Référence</label>
                    <input type="text" name="reference" value="{{ old('reference', $payment->reference) }}" class="mt-1 w-full rounded" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Type de frais</label>
                    <input type="text" name="fee_type" value="{{ old('fee_type', $payment->fee_type) }}" class="mt-1 w-full rounded" required>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Montant dû</label>
                        <input type="number" step="0.01" name="amount_due" value="{{ old('amount_due', $payment->amount_due) }}" class="mt-1 w-full rounded" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Montant payé</label>
                        <input type="number" step="0.01" name="amount_paid" value="{{ old('amount_paid', $payment->amount_paid) }}" class="mt-1 w-full rounded">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium">Statut</label>
                    <select name="status" class="mt-1 w-full rounded" required>
                        <option value="pending" @selected(old('status', $payment->status) === 'pending')>En attente</option>
                        <option value="partial" @selected(old('status', $payment->status) === 'partial')>Partiel</option>
                        <option value="paid" @selected(old('status', $payment->status) === 'paid')>Payé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Date de paiement</label>
                    <input type="date" name="paid_at" value="{{ old('paid_at', optional($payment->paid_at)->format('Y-m-d')) }}" class="mt-1 w-full rounded">
                </div>
                <div class="flex justify-end gap-2">
                    <a href="{{ route('erp.payments.index') }}" class="px-4 py-2">Annuler</a>
                    <button class="bg-blue-600 text-white px-4 py-2 rounded" type="submit">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
