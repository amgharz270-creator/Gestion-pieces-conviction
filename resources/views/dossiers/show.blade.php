@extends('layouts.admin')

@section('title', 'Détails Dossier - TPI Sidi Bennour')

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

    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-bar-right { display: flex; align-items: center; gap: 20px; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; position: relative; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }

    .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; flex-wrap: wrap; gap: 20px; }
    .page-header a { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; }
    .page-header a:hover { color: var(--accent-gold); }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-top: 15px; }
    .page-header p { color: var(--text-muted); font-size: 0.95rem; margin-top: 5px; }

    .action-buttons { display: flex; gap: 12px; flex-wrap: wrap; }
    .btn-gold { 
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); 
        color: #0a0e1a; 
        padding: 12px 25px; 
        border-radius: 12px; 
        font-weight: 700; 
        border: none; 
        transition: all 0.3s; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        cursor: pointer;
        text-decoration: none;
    }
    .btn-gold:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); 
        color: #0a0e1a;
    }
    .btn-outline { 
        background: transparent; 
        color: var(--text-muted); 
        border: 2px solid rgba(255,255,255,0.2); 
        padding: 12px 25px; 
        border-radius: 12px; 
        font-weight: 600; 
        text-decoration: none; 
        transition: all 0.3s; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
    }
    .btn-outline:hover { 
        border-color: var(--accent-gold); 
        color: var(--accent-gold); 
    }

    /* Detail Cards */
    .detail-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 35px; margin-bottom: 25px; }
    .detail-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); display: flex; align-items: center; gap: 12px; }
    .detail-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05); align-items: flex-start; }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-size: 0.9rem; min-width: 150px; }
    .detail-value { color: var(--text-light); font-weight: 600; font-size: 0.95rem; text-align: right; max-width: 60%; }
    .detail-value.description { text-align: left; max-width: 100%; line-height: 1.8; }

    /* Status Badge Large */
    .status-badge-lg { padding: 10px 25px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; }
    .status-en-cours { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-juge { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .status-appel { background: rgba(111, 66, 193, 0.15); color: #c8b5e8; }
    .status-cassation { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-clos { background: rgba(40, 167, 69, 0.15); color: var(--success); }

    /* Type Badge */
    .type-badge-lg { padding: 10px 25px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-flex; align-items: center; gap: 8px; }
    .type-penale { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; }
    .type-civile { background: rgba(23, 162, 184, 0.15); color: #6edff6; }
    .type-commerciale { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .type-administrative { background: rgba(111, 66, 193, 0.15); color: #c8b5e8; }

    /* Juge Card */
    .juge-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 25px; display: flex; align-items: center; gap: 20px; }
    .juge-avatar-lg { width: 60px; height: 60px; background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; color: var(--primary-dark); font-weight: 800; font-size: 1.5rem; }
    .juge-info h4 { color: var(--text-light); font-weight: 700; margin-bottom: 5px; }
    .juge-info p { color: var(--text-muted); font-size: 0.85rem; margin: 0; }
    .juge-info .role-badge { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block; margin-top: 8px; }

    /* Pieces Table */
    .pieces-section { margin-top: 30px; }
    .pieces-section h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; }
    .pieces-section h3 .count { background: var(--accent-gold); color: var(--primary-dark); padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; }

    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); vertical-align: middle; }
    .table-dark-custom tbody td:first-child { border-radius: 12px 0 0 12px; border-left: 1px solid rgba(255,255,255,0.05); }
    .table-dark-custom tbody td:last-child { border-radius: 0 12px 12px 0; border-right: 1px solid rgba(255,255,255,0.05); }

    .piece-ref { color: var(--text-light); font-weight: 700; font-size: 0.95rem; }
    .piece-cat { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .cat-arme { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; }
    .cat-document { background: rgba(23, 162, 184, 0.15); color: #6edff6; }
    .cat-objet { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .cat-argent { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .cat-default { background: rgba(255,255,255,0.1); color: var(--text-muted); }

    .status-badge-sm { padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; }
    .stat-depot { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .stat-saisie { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .stat-restituee { background: rgba(40, 167, 69, 0.15); color: var(--success); }

    .btn-icon-sm { width: 35px; height: 35px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; }
    .btn-icon-sm:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }

    /* Empty State */
    .empty-state { text-align: center; padding: 50px 20px; }
    .empty-state i { font-size: 3rem; color: rgba(255,255,255,0.1); margin-bottom: 15px; display: block; }
    .empty-state p { color: var(--text-muted); font-size: 0.9rem; }

    /* Timeline */
    .timeline { margin-top: 20px; }
    .timeline-item { display: flex; gap: 20px; margin-bottom: 25px; position: relative; }
    .timeline-item::before { content: ''; position: absolute; left: 20px; top: 45px; bottom: -25px; width: 2px; background: rgba(201, 162, 39, 0.2); }
    .timeline-item:last-child::before { display: none; }
    .timeline-icon { width: 42px; height: 42px; background: rgba(201, 162, 39, 0.15); border: 2px solid rgba(201, 162, 39, 0.3); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent-gold); font-size: 1.1rem; flex-shrink: 0; z-index: 2; }
    .timeline-content h4 { color: var(--text-light); font-size: 0.95rem; font-weight: 600; margin-bottom: 5px; }
    .timeline-content p { color: var(--text-muted); font-size: 0.85rem; margin: 0; }
    .timeline-content .time { color: rgba(255,255,255,0.3); font-size: 0.8rem; margin-top: 5px; display: block; }

    @media (max-width: 768px) {
        .admin-sidebar { transform: translateX(-100%); transition: transform 0.3s; }
        .admin-sidebar.active { transform: translateX(0); }
        .main-content { margin-left: 0; }
        .page-header { flex-direction: column; }
        .detail-row { flex-direction: column; gap: 5px; }
        .detail-value { text-align: left; max-width: 100%; }
    }
</style>
@endpush

@section('content')

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

<div class="admin-wrapper">
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

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px; font-size: 0.8rem;"></i>
                <a href="{{ route('dossiers.index') }}">Dossiers</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px; font-size: 0.8rem;"></i>
                <span>Détails</span>
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

        <div class="page-header">
            <div>
                <a href="{{ route('dossiers.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1><i class="bi bi-folder" style="color: var(--accent-gold); margin-right: 12px;"></i>Détails du Dossier</h1>
                <p>Informations complètes sur l'affaire judiciaire</p>
            </div>
            <div class="action-buttons">
                <a href="{{ route('dossiers.edit', $dossier) }}" class="btn-gold">
                    <i class="bi bi-pencil"></i>
                    Modifier
                </a>
                <a href="{{ route('pieces.create') }}?dossier_id={{ $dossier->id }}" class="btn-outline">
                    <i class="bi bi-plus-lg"></i>
                    Ajouter Pièce
                </a>
            </div>
        </div>

        <div class="row g-4">
            {{-- Left Column --}}
            <div class="col-lg-8">
                {{-- General Info --}}
                <div class="detail-card">
                    <h3><i class="bi bi-info-circle"></i> Informations Générales</h3>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-hash" style="color: var(--accent-gold); margin-right: 8px;"></i>Numéro</span>
                        <span class="detail-value">{{ $dossier->numero_dossier }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-tag" style="color: var(--accent-gold); margin-right: 8px;"></i>Type</span>
                        <span class="detail-value">
                            <span class="type-badge-lg {{ $typeClass }}">
                                <i class="bi {{ $typeIcon }}"></i>
                                {{ ucfirst($dossier->type_affaire) }}
                            </span>
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-activity" style="color: var(--accent-gold); margin-right: 8px;"></i>Statut</span>
                        <span class="detail-value">
                            <span class="status-badge-lg {{ $statutClass }}">
                                <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                                {{ ucfirst($dossier->statut) }}
                            </span>
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-people" style="color: var(--accent-gold); margin-right: 8px;"></i>Parties</span>
                        <span class="detail-value description">{{ $dossier->parties }}</span>
                    </div>
                </div>

                {{-- Dates --}}
                <div class="detail-card">
                    <h3><i class="bi bi-calendar3"></i> Dates</h3>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-calendar-plus" style="color: var(--accent-gold); margin-right: 8px;"></i>Date d'Ouverture</span>
                        <span class="detail-value">{{ $dossier->date_ouverture->format('d/m/Y') }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-calendar-check" style="color: var(--accent-gold); margin-right: 8px;"></i>Date de Clôture</span>
                        <span class="detail-value">
                            @if($dossier->date_cloture)
                                {{ $dossier->date_cloture->format('d/m/Y') }}
                            @else
                                <span style="color: var(--text-muted);"><i class="bi bi-dash-circle"></i> Non clôturé</span>
                            @endif
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-clock" style="color: var(--accent-gold); margin-right: 8px;"></i>Durée</span>
                        <span class="detail-value">
                            @php
                                $days = $dossier->date_ouverture->diffInDays($dossier->date_cloture ?? now());
                                $years = floor($days / 365);
                                $months = floor(($days % 365) / 30);
                                $remainingDays = $days % 30;
                            @endphp
                            @if($years > 0) {{ $years }} an{{ $years > 1 ? 's' : '' }} @endif
                            @if($months > 0) {{ $months }} mois @endif
                            @if($remainingDays > 0) {{ $remainingDays }} jour{{ $remainingDays > 1 ? 's' : '' }} @endif
                        </span>
                    </div>
                </div>

                {{-- Observations --}}
                @if($dossier->observations)
                <div class="detail-card">
                    <h3><i class="bi bi-chat-left-text"></i> Observations</h3>
                    <p style="color: var(--text-muted); line-height: 1.8; white-space: pre-wrap;">{{ $dossier->observations }}</p>
                </div>
                @endif

                {{-- Pieces --}}
                <div class="detail-card pieces-section">
                    <h3>
                        <i class="bi bi-box-seam"></i> 
                        Pièces à Conviction
                        <span class="count">{{ $dossier->pieces->count() }}</span>
                    </h3>

                    @if($dossier->pieces->count() > 0)
                    <div class="table-responsive">
                        <table class="table-dark-custom">
                            <thead>
                                <tr>
                                    <th>Référence</th>
                                    <th>Catégorie</th>
                                    <th>Description</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dossier->pieces as $piece)
                                @php
                                    $catClass = 'cat-' . $piece->categorie;
                                    $statClass = 'stat-' . $piece->statut;
                                @endphp
                                <tr>
                                    <td class="piece-ref">{{ $piece->reference }}</td>
                                    <td>
                                        <span class="piece-cat {{ $catClass }}">
                                            {{ ucfirst($piece->categorie) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($piece->description, 40) }}</td>
                                    <td>
                                        <span class="status-badge-sm {{ $statClass }}">
                                            {{ ucfirst($piece->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('pieces.show', $piece) }}" class="btn-icon-sm" title="Voir">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Aucune pièce à conviction associée à ce dossier</p>
                        <a href="{{ route('pieces.create') }}?dossier_id={{ $dossier->id }}" class="btn-gold mt-3">
                            <i class="bi bi-plus-lg"></i> Ajouter une Pièce
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Right Column --}}
            <div class="col-lg-4">
                {{-- Juge --}}
                <div class="detail-card">
                    <h3><i class="bi bi-person-badge"></i> Juge</h3>
                    @if($dossier->juge)
                    <div class="juge-card">
                        <div class="juge-avatar-lg">{{ substr($dossier->juge->name, 0, 1) }}</div>
                        <div class="juge-info">
                            <h4>{{ $dossier->juge->name }}</h4>
                            <p><i class="bi bi-envelope" style="margin-right: 5px;"></i>{{ $dossier->juge->email }}</p>
                            <span class="role-badge">{{ strtoupper($dossier->juge->role) }}</span>
                        </div>
                    </div>
                    @else
                    <div class="empty-state" style="padding: 30px;">
                        <i class="bi bi-person-x" style="font-size: 2.5rem;"></i>
                        <p>Aucun juge assigné</p>
                    </div>
                    @endif
                </div>

                {{-- Timeline --}}
                <div class="detail-card">
                    <h3><i class="bi bi-clock-history"></i> Historique</h3>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon"><i class="bi bi-plus-lg"></i></div>
                            <div class="timeline-content">
                                <h4>Création du dossier</h4>
                                <p>Dossier créé dans le système</p>
                                <span class="time"><i class="bi bi-clock"></i> {{ $dossier->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"><i class="bi bi-pencil"></i></div>
                            <div class="timeline-content">
                                <h4>Dernière modification</h4>
                                <p>Mise à jour des informations</p>
                                <span class="time"><i class="bi bi-clock"></i> {{ $dossier->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                        @if($dossier->date_cloture)
                        <div class="timeline-item">
                            <div class="timeline-icon"><i class="bi bi-check-lg"></i></div>
                            <div class="timeline-content">
                                <h4>Dossier clôturé</h4>
                                <p>Affaire terminée</p>
                                <span class="time"><i class="bi bi-clock"></i> {{ $dossier->date_cloture->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="detail-card">
                    <h3><i class="bi bi-graph-up"></i> Statistiques</h3>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-box-seam" style="color: var(--accent-gold); margin-right: 8px;"></i>Pièces</span>
                        <span class="detail-value">{{ $dossier->pieces->count() }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-arrow-return-left" style="color: var(--accent-gold); margin-right: 8px;"></i>Restitutions</span>
                        <span class="detail-value">{{ $dossier->pieces->where('statut', 'restituee')->count() }}</span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label"><i class="bi bi-check-circle" style="color: var(--accent-gold); margin-right: 8px;"></i>En Dépôt</span>
                        <span class="detail-value">{{ $dossier->pieces->where('statut', 'depot')->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

@endsection
