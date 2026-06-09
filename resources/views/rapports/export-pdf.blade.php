<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport - TPI Sidi Bennour</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: white;
            color: #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #c9a227;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #c9a227;
            margin: 0;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
        }
        .date-info {
            text-align: right;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background: #c9a227;
            color: #0a0e1a;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>TPI Sidi Bennour</h1>
        <p>Rapport - {{ ucfirst($type) }}</p>
    </div>
    
    <div class="date-info">
        Généré le: {{ now()->format('d/m/Y H:i') }}
    </div>
    
    <table>
        <thead>
            <tr>
                @if($type == 'pieces')
                    <th>Référence</th>
                    <th>Description</th>
                    <th>Catégorie</th>
                    <th>Statut</th>
                    <th>Date saisie</th>
                @elseif($type == 'dossiers')
                    <th>N° Dossier</th>
                    <th>Parties</th>
                    <th>Statut</th>
                    <th>Date création</th>
                @elseif($type == 'restitutions')
                    <th>Demandeur</th>
                    <th>Pièce</th>
                    <th>Statut</th>
                    <th>Date</th>
                @elseif($type == 'inventaires')
                    <th>Référence</th>
                    <th>Type</th>
                    <th>Statut</th>
                    <th>Date</th>
                @else
                    <th>Pièce</th>
                    <th>Type</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Date</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($data as $item)
            <tr>
                @if($type == 'pieces')
                    <td>{{ $item->reference }}</td>
                    <td>{{ Str::limit($item->description, 50) }}</td>
                    <td>{{ $item->categorie }}</td>
                    <td>{{ $item->statut }}</td>
                    <td>{{ $item->date_saisie?->format('d/m/Y') }}</td>
                @elseif($type == 'dossiers')
                    <td>{{ $item->numero_dossier }}</td>
                    <td>{{ Str::limit($item->parties, 50) }}</td>
                    <td>{{ $item->statut }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                @elseif($type == 'restitutions')
                    <td>{{ $item->demandeur_nom }}</td>
                    <td>{{ $item->piece->reference ?? 'N/A' }}</td>
                    <td>{{ $item->statut }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                @elseif($type == 'inventaires')
                    <td>{{ $item->reference }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->statut }}</td>
                    <td>{{ $item->date_planifiee->format('d/m/Y') }}</td>
                @else
                    <td>{{ $item->piece->reference ?? 'N/A' }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->fromEmplacement->salle ?? 'N/A' }}</td>
                    <td>{{ $item->toEmplacement->salle ?? 'N/A' }}</td>
                    <td>{{ $item->date_mouvement->format('d/m/Y') }}</td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center;">Aucune donnée trouvée</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        TPI Sidi Bennour - Système de Gestion des Pièces à Conviction
    </div>
</body>
</html>