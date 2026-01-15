<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Services\SchoolProvisioningService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
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
                $query->where('data->status', $request->string('status')->toString());
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.schools.index', [
            'schools' => $schools,
            'pageTitle' => 'Écoles',
            'pageDescription' => 'Gérez les tenants et leurs accès.',
        ]);
    }

    public function create()
    {
        return view('admin.schools.create', [
            'pageTitle' => 'Créer une école',
            'pageDescription' => 'Ajoutez un nouveau tenant à la plateforme.',
        ]);
    }

    public function store(Request $request, SchoolProvisioningService $provisioningService): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'status' => ['required', 'in:active,suspended'],
        ]);

        $school = $provisioningService->createSchool($payload);

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
        $connection = config('database.connections.'.(config('schermo.core_connection') ?: config('database.default')));

        return view('admin.schools.show', [
            'school' => $school,
            'connection' => $connection,
            'pageTitle' => $school->name,
            'pageDescription' => 'Détails techniques et actions rapides.',
        ]);
    }

    public function toggleStatus(School $school): RedirectResponse
    {
        $data = $school->data ?? [];
        $current = $data['status'] ?? 'suspended';
        $data['status'] = $current === 'active' ? 'suspended' : 'active';
        $school->data = $data;
        $school->save();

        Log::info('School status toggled', [
            'school_id' => $school->id,
            'status' => $data['status'],
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

    public function runMigrations(School $school): RedirectResponse
    {
        Artisan::call('tenants:migrate', [
            '--tenants' => [$school->id],
            '--force' => true,
        ]);

        Log::info('Tenant migrations executed', [
            'school_id' => $school->id,
            'action' => 'migrate',
        ]);

        return back()->with('success', 'Migrations exécutées avec succès.');
    }

    public function runSeeders(School $school): RedirectResponse
    {
        Artisan::call('tenants:seed', [
            '--tenants' => [$school->id],
            '--force' => true,
        ]);

        Log::info('Tenant seeders executed', [
            'school_id' => $school->id,
            'action' => 'seed',
        ]);

        return back()->with('success', 'Seeders relancés avec succès.');
    }
}
