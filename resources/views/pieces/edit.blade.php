@extends('layouts.admin')

@section('title', 'Modifier Pièce - TPI Sidi Bennour')

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
    .form-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 40px; max-width: 900px; }
    .form-label { color: var(--text-light); font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; }
    .form-control-dark { background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 14px 18px; color: #fff; font-size: 0.95rem; }
    .form-control-dark:focus { background: rgba(255,255,255,0.08); border-color: var(--accent-gold); box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15); color: #fff; }
    .form-select-dark { background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 14px 18px; color: #fff; }
    .form-select-dark:focus { border-color: var(--accent-gold); }
    .form-select-dark option { background: #1e3a5f; color: #fff; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 14px 35px; border-radius: 12px; font-weight: 600; text-decoration: none; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .alert-error { background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #f5c6cb; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; }
    .info-badge { background: rgba(201, 162, 39, 0.15); border: 1px solid rgba(201, 162, 39, 0.3); color: var(--accent-gold); padding: 10px 20px; border-radius: 12px; margin-bottom: 25px; font-size: 0.9rem; }
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
                <a href="{{ route('dossiers.index') }}" class="menu-item"><i class="bi bi-folder"></i><span>Dossiers</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="page-header">
            <div>
                <a href="{{ route('pieces.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1 class="mt-2"><i class="bi bi-pencil" style="color: var(--accent-gold); margin-right: 12px;"></i>Modifier la Pièce</h1>
            </div>
        </div>

        <div class="info-badge">
            <i class="bi bi-info-circle me-2"></i>Référence: <strong>{{ $piece->reference }}</strong> | QR Code: <strong>{{ $piece->qr_code }}</strong>
        </div>

        @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif

        <div class="form-card">
            <form action="{{ route('pieces.update', $piece) }}" method="POST">
                @csrf @method('PUT')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Dossier *</label>
                        <select name="dossier_id" class="form-select form-select-dark" required>
                            @foreach($dossiers as $dossier)
                            <option value="{{ $dossier->id }}" {{ old('dossier_id', $piece->dossier_id) == $dossier->id ? 'selected' : '' }}>{{ $dossier->numero_dossier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Catégorie *</label>
                        <select name="categorie" class="form-select form-select-dark" required>
                            @foreach(['arme','document','objet','argent','drogue','vehicule','electronique','bijou','liquide','autre'] as $cat)
                            <option value="{{ $cat }}" {{ old('categorie', $piece->categorie) == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control form-control-dark" rows="3" required>{{ old('description', $piece->description) }}</textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantité *</label>
                        <input type="number" name="quantite" class="form-control form-control-dark" value="{{ old('quantite', $piece->quantite) }}" min="1" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">État *</label>
                        <select name="etat" class="form-select form-select-dark" required>
                            @foreach(['neuf','bon','use','endommage','perissable','dangereux'] as $e)
                            <option value="{{ $e }}" {{ old('etat', $piece->etat) == $e ? 'selected' : '' }}>{{ ucfirst($e) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Valeur Estimée (DH)</label>
                        <input type="number" name="valeur_estimee" class="form-control form-control-dark" value="{{ old('valeur_estimee', $piece->valeur_estimee) }}" step="0.01" min="0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Emplacement</label>
                        <select name="emplacement_id" class="form-select form-select-dark">
                            <option value="">Aucun</option>
                            @foreach($emplacements as $empl)
                            <option value="{{ $empl->id }}" {{ old('emplacement_id', $piece->emplacement_id) == $empl->id ? 'selected' : '' }}>{{ $empl->salle }} - {{ $empl->armoire }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Statut *</label>
                        <select name="statut" class="form-select form-select-dark" required>
                            @foreach(['saisie','depot','restituee','detruite','vendue','archivee','expertise'] as $s)
                            <option value="{{ $s }}" {{ old('statut', $piece->statut) == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date de Saisie *</label>
                        <input type="date" name="date_saisie" class="form-control form-control-dark" value="{{ old('date_saisie', $piece->date_saisie->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Date de Péremption</label>
                        <input type="date" name="date_peremption" class="form-control form-control-dark" value="{{ old('date_peremption', $piece->date_peremption ? $piece->date_peremption->format('Y-m-d') : '') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Observations</label>
                        <textarea name="observations" class="form-control form-control-dark" rows="2">{{ old('observations', $piece->observations) }}</textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn-gold"><i class="bi bi-check-lg me-2"></i>Mettre à jour</button>
                        <a href="{{ route('pieces.index') }}" class="btn-outline ms-3">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

@endsection