@extends('layouts.admin')

@section('title', 'Détails Restitution - TPI Sidi Bennour')

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
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; gap: 15px; }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin: 0; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: all 0.3s; border: none; cursor: pointer; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .detail-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 35px; max-width: 700px; margin: 0 auto; }
    .detail-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-size: 0.9rem; }
    .detail-value { color: var(--text-light); font-weight: 600; text-align: right; }
    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
    .status-en_attente { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-approuvee { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-effectuee { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .status-refusee { background: rgba(220, 53, 69, 0.15); color: var(--danger); }
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
                <a href="{{ route('restitutions.index') }}" class="menu-item active"><i class="bi bi-arrow-return-left"></i><span>Restitutions</span></a>
                <a href="{{ route('mouvements.index') }}" class="menu-item"><i class="bi bi-arrow-left-right"></i><span>Mouvements</span></a>
                <a href="{{ route('inventaires.index') }}" class="menu-item"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <a href="{{ route('restitutions.index') }}">Restitutions</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <span>Détails</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <h1><i class="bi bi-arrow-return-left" style="color: var(--accent-gold); margin-right: 12px;"></i>Restitution #{{ $restitution->id }}</h1>
            <div>
                <a href="{{ route('restitutions.edit', $restitution) }}" class="btn-gold"><i class="bi bi-pencil"></i> Modifier</a>
                <a href="{{ route('restitutions.index') }}" class="btn-outline"><i class="bi bi-arrow-left"></i> Retour</a>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-row">
                <span class="detail-label">Demandeur</span>
                <span class="detail-value">{{ $restitution->demandeur_nom }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">CIN</span>
                <span class="detail-value">{{ $restitution->demandeur_cin ?? 'N/A' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Type de demandeur</span>
                <span class="detail-value">{{ ucfirst($restitution->type_demandeur) }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Pièce concernée</span>
                <span class="detail-value">{{ $restitution->piece->reference ?? 'N/A' }} - {{ $restitution->piece->description ?? '' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Motif de la demande</span>
                <span class="detail-value">{{ $restitution->motif_demande }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Statut</span>
                <span class="detail-value">
                    @php
                        $statusClass = '';
                        if($restitution->statut == 'en_attente') $statusClass = 'status-en_attente';
                        elseif($restitution->statut == 'approuvee') $statusClass = 'status-approuvee';
                        elseif($restitution->statut == 'effectuee') $statusClass = 'status-effectuee';
                        elseif($restitution->statut == 'refusee') $statusClass = 'status-refusee';
                    @endphp
                    <span class="status-badge {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $restitution->statut)) }}</span>
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Date de la demande</span>
                <span class="detail-value">{{ $restitution->created_at->format('d/m/Y H:i') }}</span>
            </div>
            @if($restitution->jugement_reference)
            <div class="detail-row">
                <span class="detail-label">Référence jugement</span>
                <span class="detail-value">{{ $restitution->jugement_reference }}</span>
            </div>
            @endif
            @if($restitution->date_jugement)
            <div class="detail-row">
                <span class="detail-label">Date jugement</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($restitution->date_jugement)->format('d/m/Y') }}</span>
            </div>
            @endif
        </div>
    </main>
</div>
@endsection