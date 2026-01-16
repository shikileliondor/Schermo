<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bulletin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Bulletin de notes</h1>
    <p><strong>Élève :</strong> {{ $student->last_name }} {{ $student->first_name }} ({{ $student->matricule }})</p>
    <p><strong>Classe :</strong> {{ $student->schoolClass?->name ?? '—' }}</p>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Trimestre</th>
                <th>Note</th>
                <th>Appréciation</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student->grades as $grade)
                <tr>
                    <td>{{ $grade->subject?->name }}</td>
                    <td>{{ $grade->term }}</td>
                    <td>{{ $grade->score }}/{{ $grade->max_score }}</td>
                    <td>{{ $grade->appreciation ?? '—' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 12px;"><strong>Moyenne générale :</strong> {{ $average !== null ? number_format($average, 2, ',', ' ') : 'N/A' }}</p>
</body>
</html>
