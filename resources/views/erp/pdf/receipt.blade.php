<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu de paiement</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 18px; margin-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
    </style>
</head>
<body>
    <h1>Reçu de paiement</h1>
    <p><strong>Référence :</strong> {{ $payment->reference }}</p>
    <p><strong>Élève :</strong> {{ $payment->student?->last_name }} {{ $payment->student?->first_name }}</p>

    <table>
        <thead>
            <tr>
                <th>Type de frais</th>
                <th>Montant dû</th>
                <th>Montant payé</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $payment->fee_type }}</td>
                <td>{{ number_format($payment->amount_due, 2, ',', ' ') }}</td>
                <td>{{ number_format($payment->amount_paid, 2, ',', ' ') }}</td>
                <td>{{ $payment->status }}</td>
            </tr>
        </tbody>
    </table>

    <p style="margin-top: 12px;">Date : {{ $payment->paid_at?->format('d/m/Y') ?? now()->format('d/m/Y') }}</p>
</body>
</html>
