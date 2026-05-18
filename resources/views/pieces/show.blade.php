@extends('layouts.admin')

@section('title', 'Détails Pièce - TPI Sidi Bennour')

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
    .page-header a { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; }
    .page-header a:hover { color: var(--accent-gold); }
    .detail-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 35px; margin-bottom: 25px; }
    .detail-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .detail-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-size: 0.9rem; }
    .detail-value { color: var(--text-light); font-weight: 600; font-size: 0.95rem; text-align: right; }
    .qr-box { background: rgba(255,255,255,0.03); border: 2px dashed rgba(201, 162, 39, 0.3); border-radius: 15px; padding: 30px; text-align: center; }
    .qr-box i { font-size: 4rem; color: var(--accent-gold); margin-bottom: 15px; }
    .qr-code-text { font-family: monospace; color: var(--accent-gold); font-size: 1.1rem; letter-spacing: 2px; }
    .status-badge-lg { padding: 10px 25px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; }
    .status-depot { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-saisie { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .status-restituee { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; }
    .btn-danger-custom { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; border: 1px solid rgba(220, 53, 69, 0.3); padding: 12px 25px; border-radius: 12px; font-weight: 600; }
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
                <a href="{{ route('pieces.index') }}" class="menu-item active"><i class="bi bi-box-seam"></i><span>Pièces</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <div>
                <a href="{{ route('pieces.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1 class="mt-2"><i class="bi bi-box-seam" style="color: var(--accent-gold); margin-right: 12px;"></i>Détails de la Pièce</h1>
            </div>
            <div>
                <a href="{{ route('pieces.edit', $piece) }}" class="btn-gold"><i class="bi bi-pencil"></i>Modifier</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="detail-card">
                    <h3><i class="bi bi-info-circle me-2"></i>Informations Générales</h3>
                    <div class="detail-row">
                        <span class="detail-label">Référence</span>
                        <span class="detail-value">{{ $piece->reference }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">QR Code</span>
                        <span class="detail-value" style="font-family: monospace; color: var(--accent-gold);">{{ $piece->qr_code }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Catégorie</span>
                        <span class="detail-value">{{ ucfirst($piece->categorie) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Description</span>
                        <span class="detail-value" style="max-width: 400px;">{{ $piece->description }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Quantité</span>
                        <span class="detail-value">{{ $piece->quantite }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">État</span>
                        <span class="detail-value">{{ ucfirst($piece->etat) }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Valeur Estimée</span>
                        <span class="detail-value">{{ $piece->valeur_estimee ? number_format($piece->valeur_estimee, 2) . ' DH' : 'Non estimée' }}</span>
                    </div>
                </div>

                <div class="detail-card">
                    <h3><i class="bi bi-folder me-2"></i>Dossier & Emplacement</h3>
                    <div class="detail-row">
                        <span class="detail-label">Numéro de Dossier</span>
                        <span class="detail-value">{{ $piece->dossier->numero_dossier ?? 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Type d'Affaire</span>
                        <span class="detail-value">{{ ucfirst($piece->dossier->type_affaire ?? 'N/A') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Emplacement</span>
                        <span class="detail-value">{{ $piece->emplacement ? $piece->emplacement->salle . ' - ' . $piece->emplacement->armoire : 'Non assigné' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date de Saisie</span>
                        <span class="detail-value">{{ $piece->date_saisie ? $piece->date_saisie->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Date de Péremption</span>
                        <span class="detail-value">{{ $piece->date_peremption ? $piece->date_peremption->format('d/m/Y') : 'Aucune' }}</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="detail-card text-center">
                    <h3>Statut</h3>
                    @php
                        $statusClass = 'status-depot';
                        if($piece->statut == 'saisie') $statusClass = 'status-saisie';
                        elseif($piece->statut == 'restituee') $statusClass = 'status-restituee';
                    @endphp
                    <span class="status-badge-lg {{ $statusClass }}">{{ ucfirst($piece->statut) }}</span>
                </div>

                <div class="detail-card">
                    <h3><i class="bi bi-qr-code me-2"></i>QR Code</h3>
                    <div class="qr-box">
                        <i class="bi bi-qr-code"></i>
                        <div class="qr-code-text">{{ $piece->qr_code }}</div>
                        <p class="mt-3" style="color: var(--text-muted); font-size: 0.85rem;">Scannez pour accéder aux détails</p>
                    </div>
                </div>

                <div class="detail-card">
                    <h3><i class="bi bi-clock-history me-2"></i>Historique</h3>
                    <div class="detail-row">
                        <span class="detail-label">Créée le</span>
                        <span class="detail-value">{{ $piece->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Dernière modif</span>
                        <span class="detail-value">{{ $piece->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                <form action="{{ route('pieces.destroy', $piece) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette pièce ?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-danger-custom w-100"><i class="bi bi-trash me-2"></i>Supprimer la Pièce</button>
                </form>
            </div>
        </div>
    </main>
</div>

@endsection
