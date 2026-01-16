<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $averageGrade = Grade::query()->avg(DB::raw('score / NULLIF(max_score, 0)'));

        $stats = [
            'students' => Student::count(),
            'staff' => Staff::count(),
            'payments_due' => Payment::sum('amount_due'),
            'payments_paid' => Payment::sum('amount_paid'),
            'average_grade' => $averageGrade ? round($averageGrade * 20, 2) : null,
        ];

        return view('erp.dashboard', [
            'stats' => $stats,
        ]);
    }
}
