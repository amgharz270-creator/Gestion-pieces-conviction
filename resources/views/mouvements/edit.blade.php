@extends('layouts.admin')

@section('title', 'Modifier Mouvement - TPI Sidi Bennour')

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
        --danger: #dc3545;
        --warning: #ffc107;
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
    .form-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 40px; max-width: 800px; }
    .form-label { color: var(--text-light); font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; display: block; }
    .form-label .required { color: var(--danger); margin-left: 4px; }
    .form-control-dark, .form-select-dark {
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 14px 18px;
        color: #fff;
        font-size: 0.95rem;
        width: 100%;
        transition: all 0.3s;
    }
    .form-control-dark:focus, .form-select-dark:focus {
        background: rgba(255,255,255,0.08);
        border-color: var(--accent-gold);
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15);
        outline: none;
    }
    .form-select-dark option { background: #1e3a5f; color: #fff; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; transition: all 0.3s; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 14px 35px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .btn-danger-custom { background: rgba(220, 53, 69, 0.15); color: #f5c6cb; border: 1px solid rgba(220, 53, 69, 0.3); padding: 14px 35px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .alert-error { background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #f5c6cb; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; }
    .invalid-feedback { color: #f5c6cb; font-size: 0.85rem; margin-top: 8px; }
    .is-invalid { border-color: #dc3545 !important; }
    .info-box { background: rgba(201, 162, 39, 0.1); border: 1px solid rgba(201, 162, 39, 0.2); border-radius: 12px; padding: 20px; margin-bottom: 25px; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .form-card { padding: 25px; } }
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
                <span>Modifier</span>
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
                <h1><i class="bi bi-pencil" style="color: var(--accent-gold); margin-right: 12px;"></i>Modifier le Mouvement</h1>
            </div>
        </div>

        @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif

        <div class="form-card">
            <div class="info-box">
                <i class="bi bi-info-circle-fill" style="color: var(--accent-gold); margin-right: 10px;"></i>
                <strong>Information:</strong> Modification du mouvement #{{ $mouvement->reference ?? $mouvement->id }}
            </div>

            <form action="{{ route('mouvements.update', $mouvement) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Pièce <span class="required">*</span></label>
                        <select name="piece_id" class="form-select-dark {{ $errors->has('piece_id') ? 'is-invalid' : '' }}" required>
                            <option value="">Choisir une pièce</option>
                            @foreach($pieces ?? [] as $piece)
                            <option value="{{ $piece->id }}" {{ old('piece_id', $mouvement->piece_id) == $piece->id ? 'selected' : '' }}>
                                {{ $piece->reference }} - {{ Str::limit($piece->description, 40) }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('piece_id'))<div class="invalid-feedback">{{ $errors->first('piece_id') }}</div>@endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Type de mouvement <span class="required">*</span></label>
                        <select name="type" class="form-select-dark {{ $errors->has('type') ? 'is-invalid' : '' }}" required>
                            <option value="">Choisir le type</option>
                            <option value="transfert" {{ old('type', $mouvement->type) == 'transfert' ? 'selected' : '' }}>🔄 Transfert</option>
                            <option value="sortie" {{ old('type', $mouvement->type) == 'sortie' ? 'selected' : '' }}>📤 Sortie</option>
                            <option value="entree" {{ old('type', $mouvement->type) == 'entree' ? 'selected' : '' }}>📥 Entrée</option>
                            <option value="prelevement" {{ old('type', $mouvement->type) == 'prelevement' ? 'selected' : '' }}>🔬 Prélèvement</option>
                            <option value="expertise" {{ old('type', $mouvement->type) == 'expertise' ? 'selected' : '' }}>🔍 Expertise</option>
                        </select>
                        @if($errors->has('type'))<div class="invalid-feedback">{{ $errors->first('type') }}</div>@endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Emplacement source</label>
                        <select name="from_emplacement_id" class="form-select-dark {{ $errors->has('from_emplacement_id') ? 'is-invalid' : '' }}">
                            <option value="">Aucun (optionnel)</option>
                            @foreach($emplacements ?? [] as $emplacement)
                            <option value="{{ $emplacement->id }}" {{ old('from_emplacement_id', $mouvement->from_emplacement_id) == $emplacement->id ? 'selected' : '' }}>
                                {{ $emplacement->salle }} - {{ $emplacement->armoire }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('from_emplacement_id'))<div class="invalid-feedback">{{ $errors->first('from_emplacement_id') }}</div>@endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Emplacement destination</label>
                        <select name="to_emplacement_id" class="form-select-dark {{ $errors->has('to_emplacement_id') ? 'is-invalid' : '' }}">
                            <option value="">Aucun (optionnel)</option>
                            @foreach($emplacements ?? [] as $emplacement)
                            <option value="{{ $emplacement->id }}" {{ old('to_emplacement_id', $mouvement->to_emplacement_id) == $emplacement->id ? 'selected' : '' }}>
                                {{ $emplacement->salle }} - {{ $emplacement->armoire }}
                            </option>
                            @endforeach
                        </select>
                        @if($errors->has('to_emplacement_id'))<div class="invalid-feedback">{{ $errors->first('to_emplacement_id') }}</div>@endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Destinataire</label>
                        <input type="text" name="destinataire" class="form-control-dark" value="{{ old('destinataire', $mouvement->destinataire) }}" placeholder="Nom du destinataire (optionnel)">
                        @if($errors->has('destinataire'))<div class="invalid-feedback">{{ $errors->first('destinataire') }}</div>@endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date du mouvement <span class="required">*</span></label>
                        <input type="date" name="date_mouvement" class="form-control-dark {{ $errors->has('date_mouvement') ? 'is-invalid' : '' }}" value="{{ old('date_mouvement', $mouvement->date_mouvement->format('Y-m-d')) }}" required>
                        @if($errors->has('date_mouvement'))<div class="invalid-feedback">{{ $errors->first('date_mouvement') }}</div>@endif
                    </div>

                    <div class="col-12">
                        <label class="form-label">Motif / Justification</label>
                        <textarea name="motif" class="form-control-dark" rows="3" placeholder="Raison du mouvement...">{{ old('motif', $mouvement->motif) }}</textarea>
                        @if($errors->has('motif'))<div class="invalid-feedback">{{ $errors->first('motif') }}</div>@endif
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observations</label>
                        <textarea name="observations" class="form-control-dark" rows="2" placeholder="Observations supplémentaires...">{{ old('observations', $mouvement->observations) }}</textarea>
                        @if($errors->has('observations'))<div class="invalid-feedback">{{ $errors->first('observations') }}</div>@endif
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn-gold"><i class="bi bi-save"></i> Mettre à jour</button>
                        <a href="{{ route('mouvements.index') }}" class="btn-outline ms-3">Annuler</a>
                        @if($mouvement->statut != 'retourne')
                        <button type="button" class="btn-danger-custom ms-3" onclick="confirmRetour()" style="background: rgba(23, 162, 184, 0.15); border-color: rgba(23, 162, 184, 0.3); color: var(--info);">
                            <i class="bi bi-arrow-return-left"></i> Marquer comme retourné
                        </button>
                        @endif
                    </div>
                </div>
            </form>

            @if($mouvement->statut != 'retourne')
            <form id="retourForm" action="{{ route('mouvements.retour', $mouvement) }}" method="POST" style="display: none;">
                @csrf
                @method('PATCH')
            </form>
            @endif
        </div>
    </main>
</div>

<script>
function confirmRetour() {
    if (confirm('Êtes-vous sûr de vouloir marquer ce mouvement comme retourné ? La pièce sera remise à son emplacement source.')) {
        document.getElementById('retourForm').submit();
    }
}
</script>
@endsection