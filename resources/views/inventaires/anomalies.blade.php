@extends('layouts.admin')

@section('title', 'Anomalies Inventaire - TPI Sidi Bennour')

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
        --danger: #dc3545;
        --warning: #ffc107;
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
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .anomalie-manquante { border-left: 3px solid var(--danger); }
    .anomalie-endommagee { border-left: 3px solid var(--warning); }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
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
                <a href="{{ route('inventaires.index') }}" class="menu-item"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
            </div>
            <div class="menu-section">
                <div class="menu-section-title">Rapports</div>
                <a href="{{ route('inventaires.anomalies') }}" class="menu-item active"><i class="bi bi-exclamation-triangle"></i><span>Anomalies</span></a>
                <a href="{{ route('inventaires.statistiques') }}" class="menu-item"><i class="bi bi-graph-up"></i><span>Statistiques</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <span>Anomalies d'inventaire</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <h1><i class="bi bi-exclamation-triangle" style="color: var(--danger); margin-right: 12px;"></i>Anomalies d'inventaire</h1>
        </div>

        <div class="table-card">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Inventaire</th>
                        <th>Date</th>
                        <th>Pièce</th>
                        <th>Type d'anomalie</th>
                        <th>Emplacement constaté</th>
                        <th>Observations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anomalies as $inventaire)
                        @foreach($inventaire->lignes as $ligne)
                            @if($ligne->statut != 'presente')
                            <tr class="anomalie-{{ $ligne->statut }}">
                                <td style="color: var(--text-light); font-weight: 600;">
                                    <a href="{{ route('inventaires.show', $inventaire) }}" style="color: var(--accent-gold); text-decoration: none;">
                                        {{ $inventaire->reference }}
                                    </a>
                                </td>
                                <td>{{ $inventaire->date_planifiee->format('d/m/Y') }}</td>
                                <td>
                                    <strong>{{ $ligne->piece->reference ?? 'N/A' }}</strong><br>
                                    <small>{{ Str::limit($ligne->piece->description ?? '', 30) }}</small>
                                </td>
                                <td>
                                    @if($ligne->statut == 'manquante')
                                        <span style="color: var(--danger);"><i class="bi bi-x-circle"></i> Manquante</span>
                                    @elseif($ligne->statut == 'endommagee')
                                        <span style="color: var(--warning);"><i class="bi bi-exclamation-triangle"></i> Endommagée</span>
                                    @elseif($ligne->statut == 'deplacee')
                                        <span style="color: var(--info);"><i class="bi bi-arrow-left-right"></i> Déplacée</span>
                                    @endif
                                </td>
                                <td>{{ $ligne->emplacementConstate->salle ?? 'N/A' }}</td>
                                <td>{{ Str::limit($ligne->observations, 50) ?? '-' }}</td>
                            </tr>
                            @endif
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 50px;">
                            <i class="bi bi-check-circle" style="font-size: 4rem; color: var(--success);"></i>
                            <div style="margin-top: 15px;">Aucune anomalie détectée !</div>
                            <div style="color: var(--text-muted);">Tous les inventaires sont conformes</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $anomalies->links() }}</div>
        </div>
    </main>
</div>
@endsection