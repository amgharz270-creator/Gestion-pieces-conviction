@extends('layouts.admin')

@section('title', 'Détails Inventaire - TPI Sidi Bennour')

@push('styles')
<style>
    :root {
        --primary-dark: #0a0e1a;
        --secondary-dark: #1e3a5f;
        --accent-gold: #c9a227;
        --text-light: #ffffff;
        --text-muted: rgba(255,255,255,0.6);
        --card-bg: rgba(255,255,255,0.05);
        --card-border: rgba(255,255,255,0.1);
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
    }
    body { font-family: 'Poppins', sans-serif; background: #0a0e1a; color: #fff; }
    .admin-wrapper { display: flex; min-height: 100vh; }
    .admin-sidebar {
        width: 280px;
        background: linear-gradient(180deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        border-right: 1px solid rgba(201, 162, 39, 0.2);
        position: fixed; height: 100vh; overflow-y: auto; z-index: 1000;
    }
    .sidebar-header { padding: 30px 25px; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
    .sidebar-logo { width: 70px; height: 70px; background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 32px; color: var(--primary-dark); }
    .sidebar-header h3 { color: var(--text-light); font-weight: 700; font-size: 1.1rem; }
    .sidebar-menu { padding: 20px 15px; }
    .menu-section-title { color: var(--accent-gold); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; padding: 0 15px; margin-bottom: 12px; }
    .menu-item { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 12px; color: var(--text-muted); text-decoration: none; transition: all 0.3s; margin-bottom: 5px; font-size: 0.95rem; }
    .menu-item:hover, .menu-item.active { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); border: 1px solid rgba(201, 162, 39, 0.3); }
    .menu-item i { font-size: 1.2rem; width: 24px; text-align: center; }
    .main-content { margin-left: 280px; flex: 1; background: linear-gradient(135deg, #0f1e3a 0%, #0a0e1a 100%); min-height: 100vh; padding: 30px; }
    .page-header { margin-bottom: 30px; }
    .page-header a { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; }
    .page-header a:hover { color: var(--accent-gold); }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-top: 15px; }
    .detail-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; margin-bottom: 25px; }
    .detail-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .detail-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-size: 0.9rem; }
    .detail-value { color: var(--text-light); font-weight: 600; text-align: right; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; text-align: center; }
    .stat-number { font-size: 2rem; font-weight: 800; color: var(--text-light); }
    .stat-label { color: var(--text-muted); font-size: 0.8rem; }
    .status-badge-lg { padding: 8px 20px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; }
    .status-planifie { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-en_cours { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-termine { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .status-anomalie { background: rgba(220, 53, 69, 0.15); color: var(--danger); }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-danger-custom { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; border: 1px solid rgba(220, 53, 69, 0.3); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; margin-top: 20px; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 15px 20px; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .ligne-presente { border-left: 3px solid var(--success); }
    .ligne-manquante { border-left: 3px solid var(--danger); background: rgba(220, 53, 69, 0.05); }
    .ligne-endommagee { border-left: 3px solid var(--warning); background: rgba(255, 193, 7, 0.05); }
    .ligne-deplacee { border-left: 3px solid var(--info); background: rgba(23, 162, 184, 0.05); }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: repeat(2, 1fr); } }
</style>
@endpush

@section('content')
<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo"><i class="bi bi-shield-lock-fill"></i></div>
            <h3>TPI Sidi Bennour</h3>
        </div>
        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Principal</div>
                <a href="{{ route('dashboard') }}" class="menu-item"><i class="bi bi-grid-fill"></i><span>Tableau de Bord</span></a>
                <a href="{{ route('pieces.index') }}" class="menu-item"><i class="bi bi-box-seam"></i><span>Pièces</span></a>
                <a href="{{ route('dossiers.index') }}" class="menu-item"><i class="bi bi-folder"></i><span>Dossiers</span></a>
                <a href="{{ route('emplacements.index') }}" class="menu-item"><i class="bi bi-geo-alt"></i><span>Emplacements</span></a>
            </div>
            <div class="menu-section">
                <div class="menu-section-title">Gestion</div>
                <a href="{{ route('restitutions.index') }}" class="menu-item"><i class="bi bi-arrow-return-left"></i><span>Restitutions</span></a>
                <a href="{{ route('mouvements.index') }}" class="menu-item"><i class="bi bi-arrow-left-right"></i><span>Mouvements</span></a>
                <a href="{{ route('inventaires.index') }}" class="menu-item active"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <a href="{{ route('inventaires.index') }}">Inventaires</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <span>{{ $inventaire->reference }}</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="top-icon-btn" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <div>
                <a href="{{ route('inventaires.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1><i class="bi bi-clipboard-check" style="color: var(--accent-gold); margin-right: 12px;"></i>{{ $inventaire->reference }}</h1>
            </div>
            <div>
                @if($inventaire->statut == 'planifie')
                <form action="{{ route('inventaires.demarrer', $inventaire) }}" method="POST" style="display: inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-gold"><i class="bi bi-play-fill"></i> Démarrer</button>
                </form>
                @endif
                @if($inventaire->statut == 'en_cours')
                <a href="{{ route('inventaires.edit', $inventaire) }}" class="btn-gold"><i class="bi bi-pencil"></i> Continuer</a>
                @endif
                @if($inventaire->statut == 'termine' || $inventaire->statut == 'anomalie')
                <a href="{{ route('inventaires.export', $inventaire) }}" class="btn-outline"><i class="bi bi-download"></i> Exporter</a>
                @endif
            </div>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total'] ?? $inventaire->lignes->count() }}</div>
                <div class="stat-label">Total Pièces</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--success);">{{ $stats['presentes'] ?? 0 }}</div>
                <div class="stat-label">Présentes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--danger);">{{ $stats['manquantes'] ?? 0 }}</div>
                <div class="stat-label">Manquantes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: var(--warning);">{{ ($stats['endommagees'] ?? 0) + ($stats['deplacees'] ?? 0) }}</div>
                <div class="stat-label">Anomalies</div>
            </div>
        </div>

        <!-- Informations générales -->
        <div class="detail-card">
            <h3><i class="bi bi-info-circle me-2"></i>Informations Générales</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-row">
                        <span class="detail-label">Référence</span>
                        <span class="detail-value">{{ $inventaire->reference }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Type</span>
                        <span class="detail-value">{{ ucfirst($inventaire->type) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Statut</span>
                        <span class="detail-value">
                            <span class="status-badge-lg status-{{ $inventaire->statut }}">
                                {{ ucfirst(str_replace('_', ' ', $inventaire->statut)) }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <span class="detail-label">Réalisé par</span>
                        <span class="detail-value">{{ $inventaire->realisePar->name ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Vérifié par</span>
                        <span class="detail-value">{{ $inventaire->verifiePar->name ?? 'Non assigné' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date planifiée</span>
                        <span class="detail-value">{{ $inventaire->date_planifiee->format('d/m/Y') }}</span>
                    </div>
                    @if($inventaire->date_debut)
                    <div class="detail-row">
                        <span class="detail-label">Date début</span>
                        <span class="detail-value">{{ $inventaire->date_debut->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                    @if($inventaire->date_fin)
                    <div class="detail-row">
                        <span class="detail-label">Date fin</span>
                        <span class="detail-value">{{ $inventaire->date_fin->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @if($inventaire->observations)
            <div class="detail-row mt-3">
                <span class="detail-label">Observations</span>
                <span class="detail-value">{{ $inventaire->observations }}</span>
            </div>
            @endif
        </div>

        <!-- Liste des pièces -->
        <div class="table-card">
            <h3 style="color: var(--accent-gold); margin-bottom: 20px;"><i class="bi bi-box-seam me-2"></i>Pièces inventoriées</h3>
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Description</th>
                        <th>Emplacement système</th>
                        <th>Emplacement constaté</th>
                        <th>Statut</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventaire->lignes as $ligne)
                    @php
                        $rowClass = '';
                        if($ligne->statut == 'manquante') $rowClass = 'ligne-manquante';
                        elseif($ligne->statut == 'endommagee') $rowClass = 'ligne-endommagee';
                        elseif($ligne->statut == 'deplacee') $rowClass = 'ligne-deplacee';
                        else $rowClass = 'ligne-presente';
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td style="color: var(--text-light); font-weight: 600;">{{ $ligne->piece->reference ?? 'N/A' }}</td>
                        <td>{{ Str::limit($ligne->piece->description ?? 'N/A', 50) }}</td>
                        <td>{{ $ligne->piece->emplacement->salle ?? 'N/A' }} - {{ $ligne->piece->emplacement->armoire ?? '' }}</td>
                        <td>{{ $ligne->emplacementConstate->salle ?? 'Non constaté' }} {{ $ligne->emplacementConstate->armoire ?? '' }}</td>
                        <td>
                            @if($ligne->statut == 'presente')
                            <span style="color: var(--success);"><i class="bi bi-check-circle"></i> Présente</span>
                            @elseif($ligne->statut == 'manquante')
                            <span style="color: var(--danger);"><i class="bi bi-x-circle"></i> Manquante</span>
                            @elseif($ligne->statut == 'endommagee')
                            <span style="color: var(--warning);"><i class="bi bi-exclamation-triangle"></i> Endommagée</span>
                            @elseif($ligne->statut == 'deplacee')
                            <span style="color: var(--info);"><i class="bi bi-arrow-left-right"></i> Déplacée</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($ligne->observations, 50) ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 50px;">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <div>Aucune ligne d'inventaire</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection