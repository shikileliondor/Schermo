<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SchoolClassController extends Controller
{
    public function index(): View
    {
        return view('erp.classes.index', [
            'classes' => SchoolClass::latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.classes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        SchoolClass::create($validated);

        return redirect()->route('erp.classes.index')->with('status', 'Classe créée.');
    }

    public function edit(SchoolClass $class): View
    {
        return view('erp.classes.edit', [
            'class' => $class,
        ]);
    }

    public function update(Request $request, SchoolClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $class->update($validated);

        return redirect()->route('erp.classes.index')->with('status', 'Classe mise à jour.');
    }

    public function destroy(SchoolClass $class): RedirectResponse
    {
        $class->delete();

        return redirect()->route('erp.classes.index')->with('status', 'Classe supprimée.');
    }
}
