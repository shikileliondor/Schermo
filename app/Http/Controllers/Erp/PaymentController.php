<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        return view('erp.payments.index', [
            'payments' => Payment::with('student')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.payments.create', [
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'reference' => ['required', 'string', 'max:50', 'unique:payments,reference'],
            'fee_type' => ['required', 'string', 'max:255'],
            'amount_due' => ['required', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
            'paid_at' => ['nullable', 'date'],
        ]);

        $validated['amount_paid'] = $validated['amount_paid'] ?? 0;

        Payment::create($validated);

        return redirect()->route('erp.payments.index')->with('status', 'Paiement enregistré.');
    }

    public function edit(Payment $payment): View
    {
        return view('erp.payments.edit', [
            'payment' => $payment,
            'students' => Student::orderBy('last_name')->get(),
        ]);
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'reference' => ['required', 'string', 'max:50', 'unique:payments,reference,' . $payment->id],
            'fee_type' => ['required', 'string', 'max:255'],
            'amount_due' => ['required', 'numeric', 'min:0'],
            'amount_paid' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
            'paid_at' => ['nullable', 'date'],
        ]);

        $validated['amount_paid'] = $validated['amount_paid'] ?? 0;

        $payment->update($validated);

        return redirect()->route('erp.payments.index')->with('status', 'Paiement mis à jour.');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('erp.payments.index')->with('status', 'Paiement supprimé.');
    }

    public function receipt(Payment $payment)
    {
        $payment->load('student');

        $pdf = Pdf::loadView('erp.pdf.receipt', [
            'payment' => $payment,
        ]);

        return $pdf->download('recu-' . $payment->reference . '.pdf');
    }
}
