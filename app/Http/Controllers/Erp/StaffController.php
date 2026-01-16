<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Staff;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(): View
    {
        return view('erp.staff.index', [
            'staff' => Staff::with(['classes', 'subjects'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('erp.staff.create', [
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'hired_at' => ['nullable', 'date'],
            'active' => ['nullable', 'boolean'],
            'contract' => ['nullable', 'file', 'max:4096'],
            'classes' => ['nullable', 'array'],
            'classes.*' => ['exists:classes,id'],
            'subjects' => ['nullable', 'array'],
            'subjects.*' => ['exists:subjects,id'],
        ]);

        $validated['active'] = $request->boolean('active');

        if ($request->hasFile('contract')) {
            $validated['contract_path'] = $request->file('contract')->store('staff/contracts');
            $validated['contract_original_name'] = $request->file('contract')->getClientOriginalName();
        }

        $staff = Staff::create($validated);
        $staff->classes()->sync($request->input('classes', []));
        $staff->subjects()->sync($request->input('subjects', []));

        return redirect()->route('erp.staff.index')->with('status', 'Personnel créé.');
    }

    public function edit(Staff $staff): View
    {
        return view('erp.staff.edit', [
            'staff' => $staff,
            'classes' => SchoolClass::orderBy('name')->get(),
            'subjects' => Subject::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Staff $staff): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'hired_at' => ['nullable', 'date'],
            'active' => ['nullable', 'boolean'],
            'contract' => ['nullable', 'file', 'max:4096'],
            'classes' => ['nullable', 'array'],
            'classes.*' => ['exists:classes,id'],
            'subjects' => ['nullable', 'array'],
            'subjects.*' => ['exists:subjects,id'],
        ]);

        $validated['active'] = $request->boolean('active');

        if ($request->hasFile('contract')) {
            if ($staff->contract_path) {
                Storage::delete($staff->contract_path);
            }
            $validated['contract_path'] = $request->file('contract')->store('staff/contracts');
            $validated['contract_original_name'] = $request->file('contract')->getClientOriginalName();
        }

        $staff->update($validated);
        $staff->classes()->sync($request->input('classes', []));
        $staff->subjects()->sync($request->input('subjects', []));

        return redirect()->route('erp.staff.index')->with('status', 'Personnel mis à jour.');
    }

    public function destroy(Staff $staff): RedirectResponse
    {
        if ($staff->contract_path) {
            Storage::delete($staff->contract_path);
        }

        $staff->delete();

        return redirect()->route('erp.staff.index')->with('status', 'Personnel supprimé.');
    }

    public function downloadContract(Staff $staff)
    {
        if (! $staff->contract_path || ! Storage::exists($staff->contract_path)) {
            abort(404);
        }

        return Storage::download($staff->contract_path, $staff->contract_original_name ?? 'contrat.pdf');
    }
}
