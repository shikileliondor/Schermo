<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        return view('erp.students.index', [
            'students' => Student::with('schoolClass')->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.students.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => ['nullable', 'exists:classes,id'],
            'matricule' => ['required', 'string', 'max:255', 'unique:students,matricule'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:50'],
            'parent_email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('students/photos');
        }

        Student::create($validated);

        return redirect()->route('erp.students.index')->with('status', 'Élève créé avec succès.');
    }

    public function edit(Student $student): View
    {
        return view('erp.students.edit', [
            'student' => $student,
            'classes' => SchoolClass::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => ['nullable', 'exists:classes,id'],
            'matricule' => ['required', 'string', 'max:255', 'unique:students,matricule,' . $student->id],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'gender' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:255'],
            'parent_name' => ['nullable', 'string', 'max:255'],
            'parent_phone' => ['nullable', 'string', 'max:50'],
            'parent_email' => ['nullable', 'email', 'max:255'],
            'photo' => ['nullable', 'file', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::delete($student->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('students/photos');
        }

        $student->update($validated);

        return redirect()->route('erp.students.index')->with('status', 'Élève mis à jour.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        if ($student->photo_path) {
            Storage::delete($student->photo_path);
        }

        $student->delete();

        return redirect()->route('erp.students.index')->with('status', 'Élève supprimé.');
    }
}
