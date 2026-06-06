@extends('layouts.admin')

@section('title', 'Rapports & Statistiques - TPI Sidi Bennour')

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
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px 20px; text-align: center; transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-3px); border-color: rgba(201,162,39,0.3); }
    .stat-number { font-size: 2rem; font-weight: 800; color: var(--text-light); }
    .stat-label { color: var(--text-muted); font-size: 0.85rem; margin-top: 5px; }
    .chart-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 25px; margin-bottom: 25px; }
    .chart-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.1rem; margin-bottom: 20px; }
    .rapports-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px; }
    .rapport-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px; text-align: center; text-decoration: none; transition: all 0.3s; display: block; }
    .rapport-card:hover { transform: translateY(-5px); border-color: var(--accent-gold); background: rgba(255,255,255,0.08); }
    .rapport-icon { width: 60px; height: 60px; background: rgba(201,162,39,0.15); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.8rem; color: var(--accent-gold); }
    .rapport-card h4 { color: var(--text-light); font-weight: 600; margin-bottom: 10px; }
    .rapport-card p { color: var(--text-muted); font-size: 0.85rem; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: repeat(2, 1fr); } .rapports-grid { grid-template-columns: 1fr; } }
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
                <div class="menu-section-title">Administration</div>
                <a href="{{ route('users.index') }}" class="menu-item"><i class="bi bi-people"></i><span>Utilisateurs</span></a>
                <a href="{{ route('roles.index') }}" class="menu-item"><i class="bi bi-shield-check"></i><span>Rôles & Permissions</span></a>
                <a href="{{ route('rapports.index') }}" class="menu-item active"><i class="bi bi-graph-up"></i><span>Rapports & Stats</span></a>
                <a href="#" class="menu-item"><i class="bi bi-gear"></i><span>Paramètres</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right"></i>
                <span>Rapports & Statistiques</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <h1><i class="bi bi-graph-up" style="color: var(--accent-gold);"></i> Rapports & Statistiques</h1>
        </div>

        <!-- Statistiques globales -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_pieces'] }}</div>
                <div class="stat-label">Total Pièces</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_dossiers'] }}</div>
                <div class="stat-label">Total Dossiers</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['utilisateurs_actifs'] }}</div>
                <div class="stat-label">Utilisateurs Actifs</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['taux_occupation'] }}%</div>
                <div class="stat-label">Occupation Emplacements</div>
            </div>
        </div>

        <!-- Graphiques -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="chart-card">
                    <h3><i class="bi bi-pie-chart"></i> Pièces par Catégorie</h3>
                    <canvas id="piecesParCategorie" style="height: 250px;"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-card">
                    <h3><i class="bi bi-bar-chart"></i> Pièces par Statut</h3>
                    <canvas id="piecesParStatut" style="height: 250px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Rapports rapides -->
        <h3 style="color: var(--accent-gold); margin: 30px 0 20px;">Rapports détaillés</h3>
        <div class="rapports-grid">
            <a href="{{ route('rapports.pieces') }}" class="rapport-card">
                <div class="rapport-icon"><i class="bi bi-box-seam"></i></div>
                <h4>Rapport des Pièces</h4>
                <p>Liste détaillée de toutes les pièces avec filtres</p>
            </a>
            <a href="{{ route('rapports.dossiers') }}" class="rapport-card">
                <div class="rapport-icon"><i class="bi bi-folder"></i></div>
                <h4>Rapport des Dossiers</h4>
                <p>Liste détaillée de tous les dossiers</p>
            </a>
            <a href="{{ route('rapports.restitutions') }}" class="rapport-card">
                <div class="rapport-icon"><i class="bi bi-arrow-return-left"></i></div>
                <h4>Rapport des Restitutions</h4>
                <p>Historique des restitutions effectuées</p>
            </a>
            <a href="{{ route('rapports.inventaires') }}" class="rapport-card">
                <div class="rapport-icon"><i class="bi bi-clipboard-check"></i></div>
                <h4>Rapport des Inventaires</h4>
                <p>Liste des inventaires réalisés</p>
            </a>
            <a href="{{ route('rapports.mouvements') }}" class="rapport-card">
                <div class="rapport-icon"><i class="bi bi-arrow-left-right"></i></div>
                <h4>Rapport des Mouvements</h4>
                <p>Traçabilité des mouvements de pièces</p>
            </a>
            <div class="rapport-card" style="opacity: 0.5;">
                <div class="rapport-icon"><i class="bi bi-file-pdf"></i></div>
                <h4>Exports</h4>
                <p>Export PDF / Excel (Bientôt)</p>
            </div>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Pièces par catégorie
    const catLabels = @json($stats['pieces_par_categorie']->pluck('categorie'));
    const catData = @json($stats['pieces_par_categorie']->pluck('total'));
    
    new Chart(document.getElementById('piecesParCategorie'), {
        type: 'pie',
        data: {
            labels: catLabels,
            datasets: [{
                data: catData,
                backgroundColor: ['#c9a227', '#28a745', '#dc3545', '#17a2b8', '#ffc107', '#6f42c1', '#fd7e14', '#20c997', '#e83e8c', '#6610f2']
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { labels: { color: '#fff' } } } }
    });

    // Pièces par statut
    const statLabels = @json($stats['pieces_par_statut']->pluck('statut'));
    const statData = @json($stats['pieces_par_statut']->pluck('total'));
    
    new Chart(document.getElementById('piecesParStatut'), {
        type: 'bar',
        data: {
            labels: statLabels,
            datasets: [{
                label: 'Nombre de pièces',
                data: statData,
                backgroundColor: '#c9a227',
                borderRadius: 8
            }]
        },
        options: { responsive: true, maintainAspectRatio: true, scales: { y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#fff' } }, x: { ticks: { color: '#fff' } } } }
    });
</script>
@endsection