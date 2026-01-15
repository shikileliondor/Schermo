<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SchoolAdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = User::query()
            ->with('school')
            ->whereNotNull('school_id')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhereHas('school', function ($schoolQuery) use ($search) {
                            $schoolQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.school-admins.index', [
            'admins' => $admins,
            'pageTitle' => 'Administrateurs',
            'pageDescription' => 'Gérez les comptes administrateurs par école.',
        ]);
    }

    public function create()
    {
        return view('admin.school-admins.create', [
            'schools' => School::orderBy('name')->get(),
            'pageTitle' => 'Créer un administrateur',
            'pageDescription' => 'Associez un admin à une école.',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'school_id' => ['required', 'exists:schools,id'],
        ]);

        $temporaryPassword = Str::random(24);

        $admin = User::create([
            'name' => $payload['name'],
            'email' => $payload['email'],
            'password' => Hash::make($temporaryPassword),
            'school_id' => $payload['school_id'],
            'is_super_admin' => false,
            'is_active' => true,
        ]);

        Password::sendResetLink(['email' => $admin->email]);

        Log::info('School admin created', [
            'user_id' => $admin->id,
            'school_id' => $admin->school_id,
            'action' => 'create_admin',
        ]);

        return redirect()->route('admin.school-admins.index')
            ->with('success', "L'administrateur a été créé et un email de réinitialisation a été envoyé.");
    }

    public function toggleStatus(User $admin): RedirectResponse
    {
        if (! $admin->school_id) {
            abort(404);
        }

        $admin->is_active = ! $admin->is_active;
        $admin->save();

        Log::info('School admin status toggled', [
            'user_id' => $admin->id,
            'status' => $admin->is_active ? 'active' : 'suspended',
            'action' => 'toggle_admin_status',
        ]);

        return back()->with('success', "Le statut de l'administrateur a été mis à jour.");
    }

    public function resetPassword(User $admin): RedirectResponse
    {
        if (! $admin->school_id) {
            abort(404);
        }

        Password::sendResetLink(['email' => $admin->email]);

        Log::info('School admin password reset requested', [
            'user_id' => $admin->id,
            'action' => 'reset_password',
        ]);

        return back()->with('success', 'Email de réinitialisation envoyé.');
    }
}
