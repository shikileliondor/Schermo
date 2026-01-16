<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(): View
    {
        return view('erp.subjects.index', [
            'subjects' => Subject::latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.subjects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'coefficient' => ['nullable', 'integer', 'min:1'],
        ]);

        Subject::create($validated);

        return redirect()->route('erp.subjects.index')->with('status', 'Matière créée.');
    }

    public function edit(Subject $subject): View
    {
        return view('erp.subjects.edit', [
            'subject' => $subject,
        ]);
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:50'],
            'coefficient' => ['nullable', 'integer', 'min:1'],
        ]);

        $subject->update($validated);

        return redirect()->route('erp.subjects.index')->with('status', 'Matière mise à jour.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('erp.subjects.index')->with('status', 'Matière supprimée.');
    }
}
