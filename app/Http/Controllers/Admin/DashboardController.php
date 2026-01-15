<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $latestCreatedAt = School::latest('created_at')->value('created_at');

        $stats = [
            'total' => School::count(),
            'active' => School::where('data->status', 'active')->count(),
            'suspended' => School::where('data->status', 'suspended')->count(),
            'latest_created_at' => $latestCreatedAt ? Carbon::parse($latestCreatedAt)->format('d/m/Y H:i') : null,
        ];

        return view('admin.dashboard', [
            'stats' => $stats,
            'pageTitle' => 'Dashboard',
            'pageDescription' => 'Vue globale de la plateforme.',
        ]);
    }
}
