@extends('layouts.admin')

@section('title', 'Dossiers Judiciaires - TPI Sidi Bennour')

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
    .sidebar-logo {
        width: 70px; height: 70px;
        background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%);
        border-radius: 20px; display: flex; align-items: center; justify-content: center;
        margin: 0 auto 15px; font-size: 32px; color: var(--primary-dark);
    }
    .sidebar-header h3 { color: var(--text-light); font-weight: 700; font-size: 1.1rem; }

    .sidebar-menu { padding: 20px 15px; }
    .menu-section-title { color: var(--accent-gold); font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 2px; padding: 0 15px; margin-bottom: 12px; }
    .menu-item { display: flex; align-items: center; gap: 12px; padding: 14px 18px; border-radius: 12px; color: var(--text-muted); text-decoration: none; transition: all 0.3s; margin-bottom: 5px; font-size: 0.95rem; }
    .menu-item:hover, .menu-item.active { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); border: 1px solid rgba(201, 162, 39, 0.3); }
    .menu-item i { font-size: 1.2rem; width: 24px; text-align: center; }
    .badge-count { margin-left: auto; background: var(--accent-gold); color: var(--primary-dark); padding: 3px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }

    .sidebar-footer { padding: 20px 25px; border-top: 1px solid rgba(255,255,255,0.1); position: absolute; bottom: 0; width: 100%; background: linear-gradient(180deg, transparent 0%, var(--primary-dark) 100%); }
    .user-profile-mini { display: flex; align-items: center; gap: 12px; }
    .user-avatar { width: 45px; height: 45px; background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-weight: 700; font-size: 1.1rem; }
    .user-info-mini h4 { color: var(--text-light); font-size: 0.9rem; font-weight: 600; margin-bottom: 2px; }
    .user-info-mini span { color: var(--accent-gold); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; }

    .main-content { margin-left: 280px; flex: 1; background: linear-gradient(135deg, #0f1e3a 0%, #0a0e1a 100%); min-height: 100vh; padding: 30px; }

    /* Top Bar */
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-bar-right { display: flex; align-items: center; gap: 20px; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; position: relative; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }

    /* Page Header */
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; }
    .page-header p { color: var(--text-muted); font-size: 0.95rem; margin-top: 5px; }

    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; transition: all 0.3s; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); color: #0a0e1a; }

    /* Alert */
    .alert-success-custom { background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3); color: #75b798; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }

    /* Stats Cards */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px 20px; transition: all 0.3s; }
    .stat-card:hover { transform: translateY(-3px); border-color: rgba(201, 162, 39, 0.3); }
    .stat-card-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 15px; }
    .stat-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; }
    .stat-icon.total { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .stat-icon.active { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .stat-icon.closed { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .stat-icon.pending { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--text-light); margin-bottom: 5px; }
    .stat-label { color: var(--text-muted); font-size: 0.85rem; }

    /* Search & Filter */
    .search-filter-bar { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; margin-bottom: 25px; display: flex; gap: 15px; align-items: center; flex-wrap: wrap; }
    .search-input { background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 12px 18px 12px 45px; color: #fff; font-size: 0.9rem; transition: all 0.3s; flex: 1; min-width: 250px; position: relative; }
    .search-input:focus { background: rgba(255,255,255,0.08); border-color: var(--accent-gold); outline: none; }
    .search-input::placeholder { color: rgba(255,255,255,0.3); }
    .search-wrapper { position: relative; flex: 1; }
    .search-wrapper i { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: var(--accent-gold); font-size: 1rem; z-index: 2; }
    .filter-select { background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 12px 18px; color: #fff; font-size: 0.9rem; min-width: 180px; }
    .filter-select:focus { border-color: var(--accent-gold); outline: none; }
    .filter-select option { background: #1e3a5f; color: #fff; }

    /* Table */
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); transform: scale(1.005); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
    .table-dark-custom tbody td:first-child { border-radius: 12px 0 0 12px; border-left: 1px solid rgba(255,255,255,0.05); }
    .table-dark-custom tbody td:last-child { border-radius: 0 12px 12px 0; border-right: 1px solid rgba(255,255,255,0.05); }

    .dossier-num { color: var(--text-light); font-weight: 700; font-size: 1rem; }
    .dossier-type { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .type-penale { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; }
    .type-civile { background: rgba(23, 162, 184, 0.15); color: #6edff6; }
    .type-commerciale { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .type-administrative { background: rgba(111, 66, 193, 0.15); color: #c8b5e8; }

    .parties-text { max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .juge-name { display: flex; align-items: center; gap: 8px; }
    .juge-avatar { width: 30px; height: 30px; background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-weight: 700; font-size: 0.8rem; }

    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .status-en-cours { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-juge { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .status-appel { background: rgba(111, 66, 193, 0.15); color: #c8b5e8; }
    .status-cassation { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-clos { background: rgba(40, 167, 69, 0.15); color: var(--success); }

    .date-cell { font-family: monospace; font-size: 0.85rem; }
    .pieces-count { display: inline-flex; align-items: center; gap: 5px; background: rgba(201, 162, 39, 0.1); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; color: var(--accent-gold); }

    .action-btns { display: flex; gap: 8px; }
    .btn-icon-sm { width: 35px; height: 35px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; }
    .btn-icon-sm:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-icon-sm.view:hover { background: rgba(23, 162, 184, 0.15); border-color: var(--info); color: var(--info); }
    .btn-icon-sm.edit:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-icon-sm.delete:hover { background: rgba(220, 53, 69, 0.15); border-color: var(--danger); color: var(--danger); }

    /* Empty State */
    .empty-state { text-align: center; padding: 60px 20px; }
    .empty-state i { font-size: 4rem; color: rgba(255,255,255,0.1); margin-bottom: 20px; display: block; }
    .empty-state h4 { color: var(--text-muted); font-weight: 600; margin-bottom: 10px; }
    .empty-state p { color: rgba(255,255,255,0.3); font-size: 0.9rem; }

    /* Pagination */
    .pagination-custom { display: flex; justify-content: center; margin-top: 25px; }
    .pagination-custom .page-link { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: var(--text-muted); padding: 10px 18px; margin: 0 4px; border-radius: 10px; text-decoration: none; transition: all 0.3s; }
    .pagination-custom .page-link:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .pagination-custom .page-item.active .page-link { background: var(--accent-gold); border-color: var(--accent-gold); color: var(--primary-dark); font-weight: 700; }
    .pagination-custom .page-item.disabled .page-link { opacity: 0.3; cursor: not-allowed; }

    /* Responsive */
    @media (max-width: 1200px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) {
        .admin-sidebar { transform: translateX(-100%); transition: transform 0.3s; }
        .admin-sidebar.active { transform: translateX(0); }
        .main-content { margin-left: 0; }
        .stats-grid { grid-template-columns: 1fr; }
        .page-header { flex-direction: column; gap: 20px; align-items: flex-start; }
        .search-filter-bar { flex-direction: column; }
        .search-wrapper, .search-input { width: 100%; }
    }
</style>
@endpush

@section('content')

<div class="admin-wrapper">
    {{-- Sidebar --}}
    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo"><i class="bi bi-shield-lock-fill"></i></div>
            <h3>TPI Sidi Bennour</h3>
        </div>
        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Principal</div>
                <a href="{{ route('dashboard') }}" class="menu-item"><i class="bi bi-grid-fill"></i><span>Tableau de Bord</span></a>
                <a href="{{ route('pieces.index') }}" class="menu-item"><i class="bi bi-box-seam"></i><span>Pièces</span></a>
                <a href="{{ route('dossiers.index') }}" class="menu-item active"><i class="bi bi-folder"></i><span>Dossiers</span></a>
                <a href="{{ route('emplacements.index') }}" class="menu-item"><i class="bi bi-geo-alt"></i><span>Emplacements</span></a>
            </div>
            <div class="menu-section">
                <div class="menu-section-title">Gestion</div>
                <a href="{{ route('restitutions.index') }}" class="menu-item"><i class="bi bi-arrow-return-left"></i><span>Restitutions</span></a>
                <a href="{{ route('mouvements.index') }}" class="menu-item"><i class="bi bi-arrow-left-right"></i><span>Mouvements</span></a>
            </div>
        </nav>
        <div class="sidebar-footer">
            <div class="user-profile-mini">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div class="user-info-mini">
                    <h4>{{ Auth::user()->name }}</h4>
                    <span>{{ Auth::user()->role }}</span>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="main-content">
        {{-- Top Bar --}}
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px; font-size: 0.8rem;"></i>
                <span>Dossiers Judiciaires</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="top-icon-btn" title="Déconnexion">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="alert-success-custom">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- Page Header --}}
        <div class="page-header">
            <div>
                <h1><i class="bi bi-folder" style="color: var(--accent-gold); margin-right: 12px;"></i>Dossiers Judiciaires</h1>
                <p>Gestion des affaires et procédures judiciaires</p>
            </div>
            <a href="{{ route('dossiers.create') }}" class="btn-gold">
                <i class="bi bi-plus-lg"></i>
                Nouveau Dossier
            </a>
        </div>

        {{-- Stats --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon total"><i class="bi bi-folder"></i></div>
                </div>
                <div class="stat-number">{{ $dossiers->total() }}</div>
                <div class="stat-label">Total Dossiers</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon active"><i class="bi bi-folder-check"></i></div>
                </div>
                <div class="stat-number">{{ $dossiers->where('statut', 'en_cours')->count() }}</div>
                <div class="stat-label">En Cours</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon closed"><i class="bi bi-folder-x"></i></div>
                </div>
                <div class="stat-number">{{ $dossiers->where('statut', 'clos')->count() }}</div>
                <div class="stat-label">Clos</div>
            </div>
            <div class="stat-card">
                <div class="stat-card-header">
                    <div class="stat-icon pending"><i class="bi bi-folder-symlink"></i></div>
                </div>
                <div class="stat-number">{{ $dossiers->whereIn('statut', ['juge', 'appel', 'cassation'])->count() }}</div>
                <div class="stat-label">En Appel/Cassation</div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="search-filter-bar">
            <div class="search-wrapper">
                <i class="bi bi-search"></i>
                <input type="text" class="search-input" placeholder="Rechercher par numéro, parties..." id="searchDossier">
            </div>
            <select class="filter-select" id="filterType">
                <option value="">Tous les types</option>
                <option value="penale">Pénale</option>
                <option value="civile">Civile</option>
                <option value="commerciale">Commerciale</option>
                <option value="administrative">Administrative</option>
            </select>
            <select class="filter-select" id="filterStatut">
                <option value="">Tous les statuts</option>
                <option value="en_cours">En Cours</option>
                <option value="juge">Jugé</option>
                <option value="appel">En Appel</option>
                <option value="cassation">Cassation</option>
                <option value="clos">Clos</option>
            </select>
        </div>

        {{-- Table --}}
        <div class="table-card">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>N° Dossier</th>
                        <th>Type</th>
                        <th>Parties</th>
                        <th>Juge</th>
                        <th>Statut</th>
                        <th>Pièces</th>
                        <th>Date Ouverture</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dossiers as $dossier)
                    @php
                        $typeClass = 'type-' . $dossier->type_affaire;
                        $statutClass = 'status-' . $dossier->statut;
                        $typeIcon = [
                            'penale' => 'bi-shield-exclamation',
                            'civile' => 'bi-people',
                            'commerciale' => 'bi-briefcase',
                            'administrative' => 'bi-building'
                        ][$dossier->type_affaire] ?? 'bi-folder';
                    @endphp
                    <tr>
                        <td>
                            <span class="dossier-num">{{ $dossier->numero_dossier }}</span>
                        </td>
                        <td>
                            <span class="dossier-type {{ $typeClass }}">
                                <i class="bi {{ $typeIcon }}"></i>
                                {{ ucfirst($dossier->type_affaire) }}
                            </span>
                        </td>
                        <td>
                            <span class="parties-text" title="{{ $dossier->parties }}">
                                {{ Str::limit($dossier->parties, 30) }}
                            </span>
                        </td>
                        <td>
                            @if($dossier->juge)
                            <div class="juge-name">
                                <div class="juge-avatar">{{ substr($dossier->juge->name, 0, 1) }}</div>
                                <span>{{ $dossier->juge->name }}</span>
                            </div>
                            @else
                            <span style="color: rgba(255,255,255,0.3); font-size: 0.85rem;"><i class="bi bi-dash-circle"></i> Non assigné</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $statutClass }}">
                                {{ ucfirst($dossier->statut) }}
                            </span>
                        </td>
                        <td>
                            <span class="pieces-count">
                                <i class="bi bi-box-seam"></i>
                                {{ $dossier->pieces_count ?? $dossier->pieces->count() }}
                            </span>
                        </td>
                        <td class="date-cell">
                            <i class="bi bi-calendar3" style="color: var(--accent-gold); margin-right: 5px;"></i>
                            {{ $dossier->date_ouverture->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('dossiers.show', $dossier) }}" class="btn-icon-sm view" title="Voir détails">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('dossiers.edit', $dossier) }}" class="btn-icon-sm edit" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('dossiers.destroy', $dossier) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce dossier ? Cette action est irréversible.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon-sm delete" title="Supprimer" style="border: none;">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h4>Aucun dossier trouvé</h4>
                                <p>Commencez par créer un nouveau dossier judiciaire</p>
                                <a href="{{ route('dossiers.create') }}" class="btn-gold mt-3">
                                    <i class="bi bi-plus-lg"></i> Créer un Dossier
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($dossiers->hasPages())
            <div class="pagination-custom">
                {{ $dossiers->links() }}
            </div>
            @endif
        </div>
    </main>
</div>

@endsection

@push('scripts')
<script>
    // Search functionality
    document.getElementById('searchDossier').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('.table-dark-custom tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Filter by type
    document.getElementById('filterType').addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.table-dark-custom tbody tr');

        rows.forEach(row => {
            if (!filterValue) {
                row.style.display = '';
                return;
            }
            const typeCell = row.querySelector('.dossier-type');
            if (typeCell) {
                const typeText = typeCell.textContent.toLowerCase();
                row.style.display = typeText.includes(filterValue) ? '' : 'none';
            }
        });
    });

    // Filter by statut
    document.getElementById('filterStatut').addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('.table-dark-custom tbody tr');

        rows.forEach(row => {
            if (!filterValue) {
                row.style.display = '';
                return;
            }
            const statusCell = row.querySelector('.status-badge');
            if (statusCell) {
                const statusText = statusCell.textContent.toLowerCase().replace(/\s/g, '_');
                row.style.display = statusText.includes(filterValue) ? '' : 'none';
            }
        });
    });
</script>
@endpush