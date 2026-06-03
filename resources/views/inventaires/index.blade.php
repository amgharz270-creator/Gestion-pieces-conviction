@extends('layouts.admin')

@section('title', 'Inventaires - TPI Sidi Bennour')

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
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin: 0; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; transition: all 0.3s; cursor: pointer; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); color: #0a0e1a; }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s; cursor: pointer; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
    .table-dark-custom tbody td:first-child { border-radius: 12px 0 0 12px; border-left: 1px solid rgba(255,255,255,0.05); }
    .table-dark-custom tbody td:last-child { border-radius: 0 12px 12px 0; border-right: 1px solid rgba(255,255,255,0.05); }
    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
    .status-planifie { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-en_cours { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-termine { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .status-anomalie { background: rgba(220, 53, 69, 0.15); color: var(--danger); }
    .type-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
    .type-complet { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .type-partiel { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .type-surprise { background: rgba(111, 66, 193, 0.15); color: #c8b5e8; }
    .action-btns { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-icon-sm { width: 35px; height: 35px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; }
    .btn-icon-sm:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-start { background: rgba(40, 167, 69, 0.15); color: var(--success); border: 1px solid rgba(40, 167, 69, 0.3); padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px; cursor: pointer; }
    .btn-start:hover { background: rgba(40, 167, 69, 0.25); }
    .alert-success-custom { background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3); color: #75b798; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
    .alert-error-custom { background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #f5c6cb; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px 20px; transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-3px); border-color: rgba(201, 162, 39, 0.3); }
    .stat-number { font-size: 2rem; font-weight: 800; color: var(--text-light); margin-bottom: 8px; }
    .stat-label { color: var(--text-muted); font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; }
    .filters-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; margin-bottom: 25px; }
    .filter-select { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 10px 15px; color: #fff; width: 100%; }
    .filter-select:focus { border-color: var(--accent-gold); outline: none; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .pagination { display: flex; justify-content: center; margin-top: 20px; gap: 5px; }
    .pagination .page-item .page-link { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); border-radius: 8px; padding: 8px 15px; }
    .pagination .page-item.active .page-link { background: var(--accent-gold); border-color: var(--accent-gold); color: #0a0e1a; }
    .badge-count { background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 20px; font-size: 0.7rem; margin-left: 5px; }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: repeat(2, 1fr); } .page-header { flex-direction: column; align-items: flex-start; } }
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
            <div class="menu-section">
                <div class="menu-section-title">Rapports</div>
                <a href="{{ route('inventaires.anomalies') }}" class="menu-item"><i class="bi bi-exclamation-triangle"></i><span>Anomalies</span></a>
                <a href="{{ route('inventaires.statistiques') }}" class="menu-item"><i class="bi bi-graph-up"></i><span>Statistiques</span></a>
            </div>
        </nav>
        <div class="sidebar-footer" style="padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1);">
            <div class="user-profile-mini" style="display: flex; align-items: center; gap: 12px;">
                <div class="user-avatar" style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-weight: 700;">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div>
                    <h4 style="color: var(--text-light); font-size: 0.9rem; margin-bottom: 2px;">{{ Auth::user()->name }}</h4>
                    <span style="color: var(--accent-gold); font-size: 0.75rem;">{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px; font-size: 0.8rem;"></i>
                <span>Inventaires</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="top-icon-btn" title="Déconnexion"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert-error-custom">
            <i class="bi bi-exclamation-triangle-fill"></i>
            {{ session('error') }}
        </div>
        @endif

        <div class="page-header">
            <div>
                <h1><i class="bi bi-clipboard-check" style="color: var(--accent-gold); margin-right: 12px;"></i>Inventaires</h1>
            </div>
            <a href="{{ route('inventaires.create') }}" class="btn-gold">
                <i class="bi bi-plus-lg"></i> Nouvel Inventaire
            </a>
        </div>

        <!-- Statistiques -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $inventaires->total() }}</div>
                <div class="stat-label">Total Inventaires</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $inventaires->where('statut', 'planifie')->count() }}</div>
                <div class="stat-label">Planifiés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $inventaires->where('statut', 'en_cours')->count() }}</div>
                <div class="stat-label">En Cours</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $inventaires->whereIn('statut', ['termine', 'anomalie'])->count() }}</div>
                <div class="stat-label">Terminés</div>
            </div>
        </div>

        <!-- Filtres -->
        <div class="filters-card">
            <form method="GET" action="{{ route('inventaires.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label" style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 5px;">Statut</label>
                    <select name="statut" class="filter-select">
                        <option value="">Tous les statuts</option>
                        <option value="planifie" {{ request('statut') == 'planifie' ? 'selected' : '' }}>Planifiés</option>
                        <option value="en_cours" {{ request('statut') == 'en_cours' ? 'selected' : '' }}>En Cours</option>
                        <option value="termine" {{ request('statut') == 'termine' ? 'selected' : '' }}>Terminés</option>
                        <option value="anomalie" {{ request('statut') == 'anomalie' ? 'selected' : '' }}>Anomalies</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label" style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 5px;">Type</label>
                    <select name="type" class="filter-select">
                        <option value="">Tous les types</option>
                        <option value="complet" {{ request('type') == 'complet' ? 'selected' : '' }}>Complet</option>
                        <option value="partiel" {{ request('type') == 'partiel' ? 'selected' : '' }}>Partiel</option>
                        <option value="surprise" {{ request('type') == 'surprise' ? 'selected' : '' }}>Surprise</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn-gold" style="width: 100%;">
                        <i class="bi bi-search"></i> Filtrer
                    </button>
                    <a href="{{ route('inventaires.index') }}" class="btn-outline ms-2" style="padding: 10px 20px;">
                        <i class="bi bi-arrow-repeat"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Tableau des inventaires -->
        <div class="table-card">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Type</th>
                        <th>Réalisé Par</th>
                        <th>Statut</th>
                        <th>Date Planifiée</th>
                        <th>Pièces</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventaires as $inv)
                    @php
                        $statusClass = 'status-' . $inv->statut;
                        $typeClass = 'type-' . $inv->type;
                    @endphp
                    <tr>
                        <td style="color: var(--text-light); font-weight: 600;">
                            <i class="bi bi-clipboard-data" style="color: var(--accent-gold); margin-right: 8px;"></i>
                            {{ $inv->reference }}
                        </td>
                        <td>
                            <span class="type-badge {{ $typeClass }}">
                                @if($inv->type == 'complet') <i class="bi bi-check-all"></i> @endif
                                @if($inv->type == 'partiel') <i class="bi bi-collection"></i> @endif
                                @if($inv->type == 'surprise') <i class="bi bi-star"></i> @endif
                                {{ ucfirst($inv->type) }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <div style="width: 32px; height: 32px; background: rgba(201,162,39,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-person" style="color: var(--accent-gold); font-size: 0.9rem;"></i>
                                </div>
                                <div>
                                    <div style="color: var(--text-light); font-weight: 500;">{{ $inv->realisePar->name ?? 'N/A' }}</div>
                                    @if($inv->verifiePar)
                                    <div style="font-size: 0.75rem; color: var(--text-muted);">
                                        <i class="bi bi-check-circle"></i> Vérif: {{ $inv->verifiePar->name }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="status-badge {{ $statusClass }}">
                                @if($inv->statut == 'planifie') <i class="bi bi-calendar"></i> @endif
                                @if($inv->statut == 'en_cours') <i class="bi bi-play-circle"></i> @endif
                                @if($inv->statut == 'termine') <i class="bi bi-check-circle"></i> @endif
                                @if($inv->statut == 'anomalie') <i class="bi bi-exclamation-triangle"></i> @endif
                                {{ ucfirst(str_replace('_', ' ', $inv->statut)) }}
                            </span>
                        </td>
                        <td>
                            <i class="bi bi-calendar" style="margin-right: 5px; color: var(--text-muted);"></i>
                            {{ $inv->date_planifiee->format('d/m/Y') }}
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="font-weight: 600; color: var(--text-light);">
                                    {{ $inv->lignes_count ?? $inv->pieces_trouvees ?? 0 }}/{{ $inv->pieces_attendues ?? 0 }}
                                </div>
                                @php
                                    $pourcentage = ($inv->pieces_attendues > 0) ? round((($inv->pieces_trouvees ?? 0) / $inv->pieces_attendues) * 100) : 0;
                                @endphp
                                <div class="progress" style="width: 60px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                    <div class="progress-bar" style="width: {{ $pourcentage }}%; height: 4px; background: var(--accent-gold); border-radius: 4px;"></div>
                                </div>
                            </div>
                            @if(($inv->pieces_manquantes ?? 0) > 0)
                            <div style="color: var(--danger); font-size: 0.75rem; margin-top: 5px;">
                                <i class="bi bi-exclamation-triangle"></i> {{ $inv->pieces_manquantes }} anomalies
                            </div>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('inventaires.show', $inv) }}" class="btn-icon-sm" title="Voir détails">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                @if($inv->statut == 'planifie')
                                <form action="{{ route('inventaires.demarrer', $inv) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-start" title="Démarrer l'inventaire">
                                        <i class="bi bi-play-fill"></i> Démarrer
                                    </button>
                                </form>
                                @endif
                                
                                @if($inv->statut == 'en_cours')
                                <a href="{{ route('inventaires.edit', $inv) }}" class="btn-icon-sm" title="Continuer l'inventaire">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endif
                                
                                @if($inv->statut == 'termine' || $inv->statut == 'anomalie')
                                <a href="{{ route('inventaires.export', $inv) }}" class="btn-icon-sm" title="Exporter">
                                    <i class="bi bi-download"></i>
                                </a>
                                @endif
                                
                                @if($inv->statut != 'en_cours')
                                <form action="{{ route('inventaires.destroy', $inv) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet inventaire ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon-sm" title="Supprimer" style="border:none;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 60px;">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: var(--text-muted); display: block; margin-bottom: 15px;"></i>
                            <div style="color: var(--text-muted); font-size: 1rem;">Aucun inventaire trouvé</div>
                            <a href="{{ route('inventaires.create') }}" class="btn-gold mt-3" style="display: inline-block;">
                                <i class="bi bi-plus-lg"></i> Créer le premier inventaire
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            
            @if($inventaires->hasPages())
            <div class="pagination">
                {{ $inventaires->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </main>
</div>
@endsection