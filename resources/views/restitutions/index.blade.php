@extends('layouts.admin')

@section('title', 'Restitutions - TPI Sidi Bennour')

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
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; transition: all 0.3s; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); color: #0a0e1a; }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
    .table-dark-custom tbody td:first-child { border-radius: 12px 0 0 12px; border-left: 1px solid rgba(255,255,255,0.05); }
    .table-dark-custom tbody td:last-child { border-radius: 0 12px 12px 0; border-right: 1px solid rgba(255,255,255,0.05); }
    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .status-en-attente { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-approuvee { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-refusee { background: rgba(220, 53, 69, 0.15); color: var(--danger); }
    .status-effectuee { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .action-btns { display: flex; gap: 8px; }
    .btn-icon-sm { width: 35px; height: 35px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; }
    .btn-icon-sm:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-approve { background: rgba(40, 167, 69, 0.15); color: var(--success); border: 1px solid rgba(40, 167, 69, 0.3); padding: 6px 14px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; text-decoration: none; }
    .btn-approve:hover { background: rgba(40, 167, 69, 0.25); }
    .alert-success-custom { background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3); color: #75b798; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px 20px; }
    .stat-number { font-size: 1.8rem; font-weight: 800; color: var(--text-light); margin-bottom: 5px; }
    .stat-label { color: var(--text-muted); font-size: 0.85rem; }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: repeat(2, 1fr); } 
    }
    .status-refusee {
    background: rgba(220, 53, 69, 0.15);
    color: var(--danger);
}
.status-effectuee {
    background: rgba(40, 167, 69, 0.15);
    color: var(--success);
}
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
                <a href="{{ route('restitutions.index') }}" class="menu-item active"><i class="bi bi-arrow-return-left"></i><span>Restitutions</span></a>
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

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px; font-size: 0.8rem;"></i>
                <span>Restitutions</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="top-icon-btn" title="Deconnexion"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        @if(session('success'))
        <div class="alert-success-custom"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div>
                <h1><i class="bi bi-arrow-return-left" style="color: var(--accent-gold); margin-right: 12px;"></i>Restitutions</h1>
            </div>
            <a href="{{ route('restitutions.create') }}" class="btn-gold"><i class="bi bi-plus-lg"></i>Nouvelle Demande</a>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $restitutions->total() }}</div>
                <div class="stat-label">Total Demandes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $restitutions->where('statut', 'en_attente')->count() }}</div>
                <div class="stat-label">En Attente</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $restitutions->where('statut', 'approuvee')->count() }}</div>
                <div class="stat-label">Approuvees</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $restitutions->where('statut', 'effectuee')->count() }}</div>
                <div class="stat-label">Effectuees</div>
            </div>
        </div>

        <div class="table-card">
            <table class="table-dark-custom">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Demandeur</th>
                        <th>Type</th>
                        <th>Pièce</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($restitutions as $rest)
                    @php
                        $statusClass = 'status-' . str_replace('_', '-', $rest->statut);
                    @endphp
                    <tr>
                        <td style="color: var(--text-light); font-weight: 600;">#{{ $rest->id }}</td>
                        <td>
                            <div style="color: var(--text-light); font-weight: 600;">{{ $rest->demandeur_nom }}</div>
                            <div style="font-size: 0.8rem;">{{ $rest->demandeur_cin }}</div>
                        </td>
                        <td>{{ ucfirst($rest->type_demandeur) }}</td>
                        <td>{{ $rest->piece->reference ?? 'N/A' }}</td>
                        <td><span class="status-badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $rest->statut)) }}</span></td>
                        <td>{{ $rest->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('restitutions.show', $rest) }}" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                @if($rest->statut == 'en_attente')
                                <form action="{{ route('restitutions.approuver', $rest) }}" method="POST" style="display:inline;">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn-approve" title="Approuver"><i class="bi bi-check-lg"></i></button>
                                </form>
                                @endif
                                <a href="{{ route('restitutions.edit', $rest) }}" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align: center; padding: 50px; color: var(--text-muted);"><i class="bi bi-inbox" style="font-size: 3rem; display: block; margin-bottom: 15px;"></i>Aucune restitution</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $restitutions->links() }}</div>
        </div>
    </main>
</div>
@endsection