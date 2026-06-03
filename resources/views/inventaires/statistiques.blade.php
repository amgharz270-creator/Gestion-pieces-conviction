@extends('layouts.admin')

@section('title', 'Statistiques Inventaires - TPI Sidi Bennour')

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
    .stat-card:hover { transform: translateY(-3px); border-color: rgba(201, 162, 39, 0.3); }
    .stat-number { font-size: 2.2rem; font-weight: 800; color: var(--text-light); margin-bottom: 8px; }
    .stat-label { color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
    .chart-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; margin-bottom: 25px; }
    .chart-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 15px 20px; color: var(--text-muted); font-size: 0.9rem; }
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
                <a href="{{ route('inventaires.index') }}" class="menu-item"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
            </div>
            <div class="menu-section">
                <div class="menu-section-title">Rapports</div>
                <a href="{{ route('inventaires.anomalies') }}" class="menu-item"><i class="bi bi-exclamation-triangle"></i><span>Anomalies</span></a>
                <a href="{{ route('inventaires.statistiques') }}" class="menu-item active"><i class="bi bi-graph-up"></i><span>Statistiques</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <span>Statistiques inventaires</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <h1><i class="bi bi-graph-up" style="color: var(--accent-gold); margin-right: 12px;"></i>Statistiques des inventaires</h1>
        </div>

        <!-- Stats globales -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total'] ?? 0 }}</div>
                <div class="stat-label">Total inventaires</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['planifies'] ?? 0 }}</div>
                <div class="stat-label">Planifiés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['en_cours'] ?? 0 }}</div>
                <div class="stat-label">En cours</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['termines'] ?? 0 }}</div>
                <div class="stat-label">Terminés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['anomalies'] ?? 0 }}</div>
                <div class="stat-label">Avec anomalies</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_pieces_inventoriees'] ?? 0 }}</div>
                <div class="stat-label">Pièces inventoriées</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['total_anomalies_detectees'] ?? 0 }}</div>
                <div class="stat-label">Anomalies détectées</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $stats['termines'] > 0 ? round(($stats['termines'] / max($stats['total'], 1)) * 100) : 0 }}%</div>
                <div class="stat-label">Taux complétion</div>
            </div>
        </div>

        <!-- Évolution par mois -->
        <div class="chart-card">
            <h3><i class="bi bi-calendar-week me-2"></i>Évolution des inventaires (12 derniers mois)</h3>
            <canvas id="inventairesChart" style="height: 300px; width: 100%;"></canvas>
        </div>

        <!-- Détails par mois -->
        <div class="table-card">
            <h3 style="color: var(--accent-gold); margin-bottom: 20px;"><i class="bi bi-table me-2"></i>Détail par mois</h3>
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Mois</th>
                        <th>Total inventaires</th>
                        <th>Terminés</th>
                        <th>Avec anomalies</th>
                        <th>Taux succès</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($statsParMois ?? [] as $stat)
                    <tr>
                        <td>{{ $stat->mois }}</td>
                        <td>{{ $stat->total }}</td>
                        <td>{{ $stat->termines }}</td>
                        <td>{{ $stat->anomalies }}</td>
                        <td>
                            @php $taux = $stat->total > 0 ? round(($stat->termines / $stat->total) * 100) : 0; @endphp
                            <div class="progress" style="height: 6px; width: 100px; background: rgba(255,255,255,0.1); border-radius: 3px;">
                                <div class="progress-bar" style="width: {{ $taux }}%; height: 6px; background: var(--success); border-radius: 3px;"></div>
                            </div>
                            <small>{{ $taux }}%</small>
                         </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Aucune donnée disponible</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('inventairesChart').getContext('2d');
        
        const labels = @json(collect($statsParMois ?? [])->pluck('mois')->reverse()->values());
        const totalData = @json(collect($statsParMois ?? [])->pluck('total')->reverse()->values());
        const terminesData = @json(collect($statsParMois ?? [])->pluck('termines')->reverse()->values());
        const anomaliesData = @json(collect($statsParMois ?? [])->pluck('anomalies')->reverse()->values());
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total inventaires',
                        data: totalData,
                        borderColor: '#c9a227',
                        backgroundColor: 'rgba(201, 162, 39, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Terminés sans anomalie',
                        data: terminesData,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.05)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Avec anomalies',
                        data: anomaliesData,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.05)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: { color: '#fff', font: { family: 'Poppins' } },
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: 'rgba(255,255,255,0.6)' },
                        title: { display: true, text: 'Nombre d\'inventaires', color: '#fff' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.6)' }
                    }
                }
            }
        });
    });
</script>
@endsection