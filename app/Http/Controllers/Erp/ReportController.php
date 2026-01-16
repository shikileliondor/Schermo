<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function bulletin(Student $student)
    {
        $student->load(['grades.subject', 'schoolClass']);

        $average = $student->grades->avg(function ($grade) {
            if ($grade->max_score == 0) {
                return 0;
            }

            return ($grade->score / $grade->max_score) * 20;
        });

        $pdf = Pdf::loadView('erp.pdf.bulletin', [
            'student' => $student,
            'average' => $average,
        ]);

        return $pdf->download('bulletin-' . $student->matricule . '.pdf');
    }
}
