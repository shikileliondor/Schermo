<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        $schools = School::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('data->code', 'like', "%{$search}%")
                        ->orWhere('data->email', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $status = $request->string('status')->toString();
                if ($status === 'active') {
                    $query->where('status', true);
                } elseif ($status === 'suspended') {
                    $query->where('status', false);
                }
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.schools.index', [
            'schools' => $schools,
            'pageTitle' => 'Écoles',
            'pageDescription' => 'Gérez les établissements et leurs accès.',
        ]);
    }

    public function create()
    {
        return view('admin.schools.create', [
            'pageTitle' => 'Créer une école',
            'pageDescription' => 'Ajoutez un nouvel établissement à la plateforme.',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'status' => ['required', 'in:active,suspended'],
        ]);

        $school = School::create([
            'name' => $payload['name'],
            'status' => $payload['status'] === 'active',
            'data' => [
                'code' => $payload['code'],
                'email' => $payload['email'],
                'phone' => $payload['phone'],
            ],
        ]);

        Log::info('School created', [
            'school_id' => $school->id,
            'name' => $school->name,
            'action' => 'create',
        ]);

        return redirect()
            ->route('admin.schools.show', $school)
            ->with('success', "L'école a bien été créée.");
    }

    public function show(School $school)
    {
        return view('admin.schools.show', [
            'school' => $school,
            'pageTitle' => $school->name,
            'pageDescription' => 'Aperçu des informations de l’établissement.',
        ]);
    }

    public function toggleStatus(School $school): RedirectResponse
    {
        $school->status = ! $school->status;
        $school->save();

        Log::info('School status toggled', [
            'school_id' => $school->id,
            'status' => $school->status ? 'active' : 'suspended',
            'action' => 'toggle_status',
        ]);

        return back()->with('success', "Le statut de l'école a été mis à jour.");
    }

    public function destroy(School $school): RedirectResponse
    {
        $school->delete();

        Log::warning('School deleted', [
            'school_id' => $school->id,
            'action' => 'soft_delete',
        ]);

        return redirect()->route('admin.schools.index')->with('success', "L'école a été supprimée.");
    }
}
