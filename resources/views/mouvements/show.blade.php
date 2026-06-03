@extends('layouts.admin')

@section('title', 'Détails Mouvement - TPI Sidi Bennour')

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
    .detail-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 35px; margin-bottom: 25px; }
    .detail-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .detail-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-size: 0.9rem; }
    .detail-value { color: var(--text-light); font-weight: 600; text-align: right; }
    .status-badge-lg { padding: 8px 20px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; }
    .status-en_cours { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .status-effectue { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .status-retourne { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-annule { background: rgba(220, 53, 69, 0.15); color: var(--danger); }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; cursor: pointer; transition: all 0.3s; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-danger-custom { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; border: 1px solid rgba(220, 53, 69, 0.3); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; }
    .type-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
    .type-transfert { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .type-sortie { background: rgba(220, 53, 69, 0.15); color: var(--danger); }
    .type-entree { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .type-prelevement { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .type-expertise { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .timeline { position: relative; padding-left: 30px; }
    .timeline::before { content: ''; position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background: linear-gradient(180deg, var(--accent-gold), rgba(201,162,39,0.2)); }
    .timeline-item { position: relative; padding-bottom: 25px; }
    .timeline-item::before { content: ''; position: absolute; left: -24px; top: 5px; width: 12px; height: 12px; border-radius: 50%; background: var(--accent-gold); border: 2px solid var(--primary-dark); }
    .timeline-date { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 5px; }
    .timeline-content { background: rgba(255,255,255,0.03); padding: 12px 15px; border-radius: 12px; }
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
                <a href="{{ route('mouvements.index') }}" class="menu-item active"><i class="bi bi-arrow-left-right"></i><span>Mouvements</span></a>
                <a href="{{ route('inventaires.index') }}" class="menu-item"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <a href="{{ route('mouvements.index') }}">Mouvements</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <span>Détails</span>
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
                <a href="{{ route('mouvements.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1><i class="bi bi-arrow-left-right" style="color: var(--accent-gold); margin-right: 12px;"></i>Détails du Mouvement</h1>
            </div>
            <div>
                <a href="{{ route('mouvements.edit', $mouvement) }}" class="btn-gold"><i class="bi bi-pencil"></i> Modifier</a>
                @if($mouvement->statut != 'retourne')
                <form action="{{ route('mouvements.retour', $mouvement) }}" method="POST" style="display: inline;">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn-outline" onclick="return confirm('Marquer comme retourné ?')">
                        <i class="bi bi-arrow-return-left"></i> Retour
                    </button>
                </form>
                @endif
                <form action="{{ route('mouvements.destroy', $mouvement) }}" method="POST" style="display: inline;" onsubmit="return confirm('Supprimer définitivement ce mouvement ?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger-custom"><i class="bi bi-trash"></i> Supprimer</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <!-- Informations générales -->
                <div class="detail-card">
                    <h3><i class="bi bi-info-circle me-2"></i>Informations Générales</h3>
                    <div class="detail-row">
                        <span class="detail-label">ID / Référence</span>
                        <span class="detail-value">#{{ $mouvement->id }} @if($mouvement->reference) ({{ $mouvement->reference }}) @endif</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Type de mouvement</span>
                        <span class="detail-value">
                            <span class="type-badge type-{{ $mouvement->type }}">
                                @if($mouvement->type == 'transfert') 🔄 Transfert
                                @elseif($mouvement->type == 'sortie') 📤 Sortie
                                @elseif($mouvement->type == 'entree') 📥 Entrée
                                @elseif($mouvement->type == 'prelevement') 🔬 Prélèvement
                                @elseif($mouvement->type == 'expertise') 🔍 Expertise
                                @endif
                            </span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Statut</span>
                        <span class="detail-value">
                            <span class="status-badge-lg status-{{ $mouvement->statut }}">
                                @if($mouvement->statut == 'en_cours') ⏳ En cours
                                @elseif($mouvement->statut == 'effectue') ✅ Effectué
                                @elseif($mouvement->statut == 'retourne') ↩️ Retourné
                                @elseif($mouvement->statut == 'annule') ❌ Annulé
                                @endif
                            </span>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date du mouvement</span>
                        <span class="detail-value">{{ $mouvement->date_mouvement->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Créé par</span>
                        <span class="detail-value">{{ $mouvement->createdBy->name ?? 'N/A' }}</span>
                    </div>
                    @if($mouvement->motif)
                    <div class="detail-row">
                        <span class="detail-label">Motif / Justification</span>
                        <span class="detail-value">{{ $mouvement->motif }}</span>
                    </div>
                    @endif
                    @if($mouvement->observations)
                    <div class="detail-row">
                        <span class="detail-label">Observations</span>
                        <span class="detail-value">{{ $mouvement->observations }}</span>
                    </div>
                    @endif
                </div>

                <!-- Détails de la pièce -->
                <div class="detail-card">
                    <h3><i class="bi bi-box-seam me-2"></i>Pièce concernée</h3>
                    <div class="detail-row">
                        <span class="detail-label">Référence</span>
                        <span class="detail-value">
                            <a href="{{ route('pieces.show', $mouvement->piece) }}" style="color: var(--accent-gold); text-decoration: none;">
                                {{ $mouvement->piece->reference ?? 'N/A' }}
                            </a>
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Description</span>
                        <span class="detail-value">{{ $mouvement->piece->description ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Catégorie</span>
                        <span class="detail-value">{{ ucfirst($mouvement->piece->categorie ?? 'N/A') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">QR Code</span>
                        <span class="detail-value" style="font-family: monospace;">{{ $mouvement->piece->qr_code ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Emplacements -->
                <div class="detail-card">
                    <h3><i class="bi bi-geo-alt me-2"></i>Emplacements</h3>
                    <div class="detail-row">
                        <span class="detail-label">Source</span>
                        <span class="detail-value">
                            @if($mouvement->fromEmplacement)
                            <i class="bi bi-box-arrow-right" style="color: var(--danger);"></i>
                            {{ $mouvement->fromEmplacement->salle }} - {{ $mouvement->fromEmplacement->armoire }}
                            @else
                            <span class="text-muted">Non spécifié</span>
                            @endif
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Destination</span>
                        <span class="detail-value">
                            @if($mouvement->toEmplacement)
                            <i class="bi bi-box-arrow-in-right" style="color: var(--success);"></i>
                            {{ $mouvement->toEmplacement->salle }} - {{ $mouvement->toEmplacement->armoire }}
                            @else
                            <span class="text-muted">Non spécifié</span>
                            @endif
                        </span>
                    </div>
                    @if($mouvement->destinataire)
                    <div class="detail-row">
                        <span class="detail-label">Destinataire</span>
                        <span class="detail-value">{{ $mouvement->destinataire }}</span>
                    </div>
                    @endif
                </div>

                <!-- Dates importantes -->
                <div class="detail-card">
                    <h3><i class="bi bi-calendar me-2"></i>Dates</h3>
                    <div class="detail-row">
                        <span class="detail-label">Créé le</span>
                        <span class="detail-value">{{ $mouvement->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Dernière modif</span>
                        <span class="detail-value">{{ $mouvement->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($mouvement->date_retour)
                    <div class="detail-row">
                        <span class="detail-label">Date de retour</span>
                        <span class="detail-value">{{ \Carbon\Carbon::parse($mouvement->date_retour)->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>

                <!-- Historique des retours -->
                @if($mouvement->retourMouvement)
                <div class="detail-card">
                    <h3><i class="bi bi-arrow-return-left me-2"></i>Retour associé</h3>
                    <div class="detail-row">
                        <span class="detail-label">Mouvement retour</span>
                        <span class="detail-value">
                            <a href="{{ route('mouvements.show', $mouvement->retourMouvement) }}" style="color: var(--accent-gold);">
                                #{{ $mouvement->retourMouvement->id }}
                            </a>
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Timeline des événements (optionnel) -->
        @if($mouvement->timeline ?? false)
        <div class="detail-card">
            <h3><i class="bi bi-clock-history me-2"></i>Chronologie</h3>
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-date">{{ $mouvement->created_at->format('d/m/Y H:i') }}</div>
                    <div class="timeline-content">
                        <strong>Mouvement créé</strong><br>
                        Par {{ $mouvement->createdBy->name ?? 'Système' }}
                    </div>
                </div>
                @if($mouvement->statut == 'effectue' || $mouvement->statut == 'retourne')
                <div class="timeline-item">
                    <div class="timeline-date">{{ $mouvement->date_mouvement->format('d/m/Y H:i') }}</div>
                    <div class="timeline-content">
                        <strong>Mouvement effectué</strong><br>
                        Pièce {{ $mouvement->type == 'transfert' ? 'transférée' : ($mouvement->type == 'sortie' ? 'sortie' : 'entrée') }}
                    </div>
                </div>
                @endif
                @if($mouvement->statut == 'retourne' && $mouvement->date_retour)
                <div class="timeline-item">
                    <div class="timeline-date">{{ \Carbon\Carbon::parse($mouvement->date_retour)->format('d/m/Y H:i') }}</div>
                    <div class="timeline-content">
                        <strong>Retour effectué</strong><br>
                        Pièce retournée à son emplacement source
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </main>
</div>
@endsection