@extends('layouts.admin')

@section('title', 'Rapport des Mouvements - TPI Sidi Bennour')

@push('styles')
<style>
    :root { --primary-dark: #0a0e1a; --secondary-dark: #1e3a5f; --accent-gold: #c9a227; --text-light: #ffffff; --text-muted: rgba(255,255,255,0.6); --card-bg: rgba(255,255,255,0.05); --card-border: rgba(255,255,255,0.1); --success: #28a745; --warning: #ffc107; --danger: #dc3545; --info: #17a2b8; }
    body { font-family: 'Poppins', sans-serif; background: #0a0e1a; color: #fff; }
    .admin-wrapper { display: flex; min-height: 100vh; }
    .admin-sidebar { width: 280px; background: linear-gradient(180deg, var(--primary-dark) 0%, var(--secondary-dark) 100%); border-right: 1px solid rgba(201, 162, 39, 0.2); position: fixed; height: 100vh; overflow-y: auto; z-index: 1000; }
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
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer; }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .filter-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; margin-bottom: 25px; }
    .filter-select { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 10px 15px; color: #fff; width: 100%; }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
    .status-effectue { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .status-en_cours { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-retourne { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .pagination { display: flex; justify-content: center; margin-top: 20px; gap: 5px; }
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
                <div class="menu-section-title">Administration</div>
                <a href="{{ route('users.index') }}" class="menu-item"><i class="bi bi-people"></i><span>Utilisateurs</span></a>
                <a href="{{ route('roles.index') }}" class="menu-item"><i class="bi bi-shield-check"></i><span>Rôles & Permissions</span></a>
                <a href="{{ route('rapports.index') }}" class="menu-item active"><i class="bi bi-graph-up"></i><span>Rapports & Stats</span></a>
            </div>
        </nav>
    </aside>
    <main class="main-content">
        <div class="top-bar"><div class="breadcrumb-custom"><a href="{{ route('dashboard') }}">Accueil</a> / <a href="{{ route('rapports.index') }}">Rapports</a> / <span>Mouvements</span></div><div class="top-bar-right"><form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button></form></div></div>
        <div class="page-header"><div><a href="{{ route('rapports.index') }}"><i class="bi bi-arrow-left"></i> Retour</a><h1><i class="bi bi-arrow-left-right" style="color: var(--accent-gold);"></i> Rapport des Mouvements</h1></div><div><button onclick="window.print()" class="btn-outline"><i class="bi bi-printer"></i> Imprimer</button></div></div>
        <div class="filter-card">
    <form method="GET" action="{{ route('rapports.mouvements') }}" class="row g-3">
        <div class="col-md-4">
            <label>Type</label>
            <select name="type" class="filter-select">
                <option value="">Tous</option>
                @foreach($types as $type)
                <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label>Date début</label>
            <input type="date" name="date_debut" class="filter-select" value="{{ request('date_debut') }}">
        </div>
        <div class="col-md-3">
            <label>Date fin</label>
            <input type="date" name="date_fin" class="filter-select" value="{{ request('date_fin') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn-gold w-100"><i class="bi bi-search"></i> Filtrer</button>
        </div>
    </form>
</div>
            <table class="table-dark-custom">
    <thead>
        <tr>
            <th>Pièce</th>
            <th>Type</th>
            <th>Source</th>
            <th>Destination</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($mouvements as $mvt)
        <tr>
            <td style="color:var(--text-light);font-weight:600">{{ $mvt->piece->reference ?? 'N/A' }}</td>
            <td>{{ ucfirst($mvt->type) }}</td>
            <td>{{ $mvt->fromEmplacement->salle ?? 'N/A' }}</td>
            <td>{{ $mvt->toEmplacement->salle ?? 'N/A' }}</td>
            <td>{{ $mvt->date_mouvement->format('d/m/Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="5" style="text-align:center;">Aucun mouvement trouvé</td></tr>
        @endforelse
    </tbody>
</table>
            <div class="pagination">{{ $mouvements->appends(request()->query())->links() }}</div>
        </div>
    </main>
</div>
@endsection