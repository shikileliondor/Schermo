<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradeController extends Controller
{
    public function index(): View
    {
        return view('erp.grades.index', [
            'grades' => Grade::with(['student', 'subject'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.grades.create', [
            'students' => Student::orderBy('last_name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'term' => ['required', 'string', 'max:50'],
            'score' => ['required', 'numeric', 'min:0'],
            'max_score' => ['nullable', 'numeric', 'min:1'],
            'appreciation' => ['nullable', 'string'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $validated['max_score'] = $validated['max_score'] ?? 20;

        Grade::create($validated);

        return redirect()->route('erp.grades.index')->with('status', 'Note ajoutée.');
    }

    public function edit(Grade $grade): View
    {
        return view('erp.grades.edit', [
            'grade' => $grade,
            'students' => Student::orderBy('last_name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Grade $grade): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'term' => ['required', 'string', 'max:50'],
            'score' => ['required', 'numeric', 'min:0'],
            'max_score' => ['nullable', 'numeric', 'min:1'],
            'appreciation' => ['nullable', 'string'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $validated['max_score'] = $validated['max_score'] ?? 20;

        $grade->update($validated);

        return redirect()->route('erp.grades.index')->with('status', 'Note mise à jour.');
    }

    public function destroy(Grade $grade): RedirectResponse
    {
        $grade->delete();

        return redirect()->route('erp.grades.index')->with('status', 'Note supprimée.');
    }
}
