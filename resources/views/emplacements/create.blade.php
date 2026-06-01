@extends('layouts.admin')

@section('title', 'Nouvel Emplacement - TPI Sidi Bennour')

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
    .form-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 40px; max-width: 700px; }
    .form-label { color: var(--text-light); font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; display: block; }
    .form-label .required { color: var(--danger); margin-left: 4px; }
    .form-control-dark { background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 14px 18px; color: #fff; font-size: 0.95rem; transition: all 0.3s; width: 100%; font-family: 'Poppins', sans-serif; }
    .form-control-dark:focus { background: rgba(255,255,255,0.08); border-color: var(--accent-gold); box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15); color: #fff; outline: none; }
    .form-control-dark::placeholder { color: rgba(255,255,255,0.3); }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-size: 0.95rem; cursor: pointer; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 14px 35px; border-radius: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 10px; font-family: 'Poppins', sans-serif; font-size: 0.95rem; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .alert-error { background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #f5c6cb; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; }
    .invalid-feedback { color: #f5c6cb; font-size: 0.85rem; margin-top: 8px; }
    .is-invalid { border-color: #dc3545 !important; }
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
                <a href="{{ route('emplacements.index') }}" class="menu-item active"><i class="bi bi-geo-alt"></i><span>Emplacements</span></a>
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
                <a href="{{ route('emplacements.index') }}">Emplacements</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px; font-size: 0.8rem;"></i>
                <span>Nouveau</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="top-icon-btn" title="Deconnexion"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <div>
                <a href="{{ route('emplacements.index') }}"><i class="bi bi-arrow-left"></i> Retour a la liste</a>
                <h1><i class="bi bi-geo-alt" style="color: var(--accent-gold); margin-right: 12px;"></i>Nouvel Emplacement</h1>
            </div>
        </div>

        @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
        @endif

        <div class="form-card">
            <form action="{{ route('emplacements.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Local / Salle <span class="required">*</span></label>
                        <input type="text" name="local" class="form-control-dark {{ $errors->has('local') ? 'is-invalid' : '' }}" value="{{ old('local') }}" placeholder="Ex: Salle A" required>
                        @if($errors->has('local'))<div class="invalid-feedback">{{ $errors->first('local') }}</div>@endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Armoire <span class="required">*</span></label>
                        <input type="text" name="armoire" class="form-control-dark {{ $errors->has('armoire') ? 'is-invalid' : '' }}" value="{{ old('armoire') }}" placeholder="Ex: Armoire 1" required>
                        @if($errors->has('armoire'))<div class="invalid-feedback">{{ $errors->first('armoire') }}</div>@endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Etagere</label>
                        <input type="text" name="etagere" class="form-control-dark" value="{{ old('etagere') }}" placeholder="Ex: Haut">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Boite</label>
                        <input type="text" name="boite" class="form-control-dark" value="{{ old('boite') }}" placeholder="Ex: Boite 12">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Capacite Max <span class="required">*</span></label>
                        <input type="number" name="capacite_max" class="form-control-dark {{ $errors->has('capacite_max') ? 'is-invalid' : '' }}" value="{{ old('capacite_max', 50) }}" min="1" required>
                        @if($errors->has('capacite_max'))<div class="invalid-feedback">{{ $errors->first('capacite_max') }}</div>@endif
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Statut</label>
                        <select name="actif" class="form-control-dark" style="cursor: pointer;">
                            <option value="1" {{ old('actif', '1') == '1' ? 'selected' : '' }}>Actif</option>
                            <option value="0" {{ old('actif') == '0' ? 'selected' : '' }}>Inactif</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control-dark" rows="3" placeholder="Notes ou observations...">{{ old('notes') }}</textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn-gold"><i class="bi bi-check-lg me-2"></i>Creer l'Emplacement</button>
                        <a href="{{ route('emplacements.index') }}" class="btn-outline ms-3">Annuler</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection