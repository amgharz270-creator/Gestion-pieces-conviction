@extends('layouts.admin')

@section('title', 'Nouveau Dossier - TPI Sidi Bennour')

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

    .page-header { margin-bottom: 30px; }
    .page-header a { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s; }
    .page-header a:hover { color: var(--accent-gold); }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-top: 15px; }
    .page-header p { color: var(--text-muted); font-size: 0.95rem; margin-top: 5px; }

    .form-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 40px; max-width: 900px; }
    .form-card-header { margin-bottom: 35px; padding-bottom: 25px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .form-card-header h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.3rem; display: flex; align-items: center; gap: 12px; }
    .form-card-header p { color: var(--text-muted); font-size: 0.9rem; margin-top: 8px; }

    .form-label { color: var(--text-light); font-weight: 600; font-size: 0.9rem; margin-bottom: 10px; display: block; }
    .form-label .required { color: var(--danger); margin-left: 4px; }

    .form-control-dark { 
        background: rgba(255,255,255,0.05); 
        border: 2px solid rgba(255,255,255,0.1); 
        border-radius: 12px; 
        padding: 14px 18px; 
        color: #fff; 
        font-size: 0.95rem; 
        transition: all 0.3s; 
        width: 100%;
        font-family: 'Poppins', sans-serif;
    }
    .form-control-dark:focus { 
        background: rgba(255,255,255,0.08); 
        border-color: var(--accent-gold); 
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15); 
        color: #fff; 
        outline: none; 
    }
    .form-control-dark::placeholder { color: rgba(255,255,255,0.3); }
    .form-control-dark.is-invalid { border-color: var(--danger) !important; }

    .form-select-dark { 
        background: rgba(255,255,255,0.05); 
        border: 2px solid rgba(255,255,255,0.1); 
        border-radius: 12px; 
        padding: 14px 18px; 
        color: #fff; 
        font-size: 0.95rem; 
        width: 100%;
        font-family: 'Poppins', sans-serif;
        cursor: pointer;
    }
    .form-select-dark:focus { 
        border-color: var(--accent-gold); 
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15); 
        outline: none; 
    }
    .form-select-dark option { background: #1e3a5f; color: #fff; }
    .form-select-dark.is-invalid { border-color: var(--danger) !important; }

    .form-textarea-dark { 
        background: rgba(255,255,255,0.05); 
        border: 2px solid rgba(255,255,255,0.1); 
        border-radius: 12px; 
        padding: 14px 18px; 
        color: #fff; 
        font-size: 0.95rem; 
        transition: all 0.3s; 
        width: 100%;
        font-family: 'Poppins', sans-serif;
        resize: vertical;
        min-height: 100px;
    }
    .form-textarea-dark:focus { 
        background: rgba(255,255,255,0.08); 
        border-color: var(--accent-gold); 
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15); 
        color: #fff; 
        outline: none; 
    }
    .form-textarea-dark::placeholder { color: rgba(255,255,255,0.3); }

    .input-group-dark { position: relative; }
    .input-group-dark .input-icon { 
        position: absolute; 
        left: 16px; 
        top: 50%; 
        transform: translateY(-50%); 
        color: var(--accent-gold); 
        font-size: 1.1rem; 
        z-index: 2;
    }
    .input-group-dark .form-control-dark,
    .input-group-dark .form-select-dark { padding-left: 48px; }

    .btn-gold { 
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); 
        color: #0a0e1a; 
        padding: 14px 35px; 
        border-radius: 12px; 
        font-weight: 700; 
        border: none; 
        transition: all 0.3s; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .btn-gold:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); 
    }

    .btn-outline { 
        background: transparent; 
        color: var(--text-muted); 
        border: 2px solid rgba(255,255,255,0.2); 
        padding: 14px 35px; 
        border-radius: 12px; 
        font-weight: 600; 
        text-decoration: none; 
        transition: all 0.3s; 
        display: inline-flex; 
        align-items: center; 
        gap: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.95rem;
    }
    .btn-outline:hover { 
        border-color: var(--accent-gold); 
        color: var(--accent-gold); 
    }

    .alert-error { 
        background: rgba(220, 53, 69, 0.15); 
        border: 1px solid rgba(220, 53, 69, 0.3); 
        color: #f5c6cb; 
        border-radius: 12px; 
        padding: 15px 20px; 
        margin-bottom: 25px; 
        display: flex; 
        align-items: center; 
        gap: 10px; 
    }
    .alert-error ul { margin: 0; padding-left: 20px; }
    .alert-error li { margin-bottom: 5px; }

    .invalid-feedback { 
        color: #f5c6cb; 
        font-size: 0.85rem; 
        margin-top: 8px; 
        display: flex; 
        align-items: center; 
        gap: 6px; 
    }

    .section-divider { 
        display: flex; 
        align-items: center; 
        gap: 15px; 
        margin: 40px 0 30px; 
        color: var(--accent-gold); 
        font-weight: 600; 
        font-size: 0.9rem; 
        text-transform: uppercase; 
        letter-spacing: 1px;
    }
    .section-divider::before,
    .section-divider::after { 
        content: ''; 
        flex: 1; 
        height: 1px; 
        background: rgba(255,255,255,0.1); 
    }

    @media (max-width: 768px) {
        .admin-sidebar { transform: translateX(-100%); transition: transform 0.3s; }
        .admin-sidebar.active { transform: translateX(0); }
        .main-content { margin-left: 0; }
        .form-card { padding: 25px; }
    }
</style>
@endpush

@section('content')

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
                <span>Nouveau</span>
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
                <h1><i class="bi bi-folder-plus" style="color: var(--accent-gold); margin-right: 12px;"></i>Nouveau Dossier Judiciaire</h1>
                <p>Créez un nouveau dossier pour une affaire judiciaire</p>
            </div>
        </div>

        @if($errors->any())
        <div class="alert-error">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-card">
            <form action="{{ route('dossiers.store') }}" method="POST" id="dossierForm">
                @csrf

                <div class="form-card-header">
                    <h3><i class="bi bi-info-circle"></i> Informations Générales</h3>
                    <p>Renseignez les informations de base du dossier</p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            Numéro de Dossier <span class="required">*</span>
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-hash input-icon"></i>
                            <input type="text" 
                                   name="numero_dossier" 
                                   class="form-control-dark {{ $errors->has('numero_dossier') ? 'is-invalid' : '' }}" 
                                   value="{{ old('numero_dossier') }}" 
                                   placeholder="Ex: 2026/001" 
                                   required>
                        </div>
                        @if($errors->has('numero_dossier'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('numero_dossier') }}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Type d'Affaire <span class="required">*</span>
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-tag input-icon"></i>
                            <select name="type_affaire" 
                                    class="form-select-dark {{ $errors->has('type_affaire') ? 'is-invalid' : '' }}" 
                                    required>
                                <option value="">Choisir le type...</option>
                                <option value="penale" {{ old('type_affaire') == 'penale' ? 'selected' : '' }}>Pénale</option>
                                <option value="civile" {{ old('type_affaire') == 'civile' ? 'selected' : '' }}>Civile</option>
                                <option value="commerciale" {{ old('type_affaire') == 'commerciale' ? 'selected' : '' }}>Commerciale</option>
                                <option value="administrative" {{ old('type_affaire') == 'administrative' ? 'selected' : '' }}>Administrative</option>
                            </select>
                        </div>
                        @if($errors->has('type_affaire'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('type_affaire') }}
                        </div>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="form-label">
                            Parties <span class="required">*</span>
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-people input-icon" style="top: 28px;"></i>
                            <textarea name="parties" 
                                      class="form-textarea-dark {{ $errors->has('parties') ? 'is-invalid' : '' }}" 
                                      rows="3" 
                                      placeholder="Nom des parties (demandeur / défendeur, accusé / victime...)" 
                                      required>{{ old('parties') }}</textarea>
                        </div>
                        @if($errors->has('parties'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('parties') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="section-divider">
                    <i class="bi bi-person-badge"></i> Affectation
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="bi bi-person" style="color: var(--accent-gold); margin-right: 5px;"></i>Juge Assigné
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-person-badge input-icon"></i>
                            <select name="juge_id" class="form-select-dark {{ $errors->has('juge_id') ? 'is-invalid' : '' }}">
                                <option value="">Non assigné</option>
                                @foreach($juges as $juge)
                                <option value="{{ $juge->id }}" {{ old('juge_id') == $juge->id ? 'selected' : '' }}>
                                    {{ $juge->name }} ({{ $juge->role }})
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @if($errors->has('juge_id'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('juge_id') }}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            Statut <span class="required">*</span>
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-activity input-icon"></i>
                            <select name="statut" 
                                    class="form-select-dark {{ $errors->has('statut') ? 'is-invalid' : '' }}" 
                                    required>
                                <option value="en_cours" {{ old('statut', 'en_cours') == 'en_cours' ? 'selected' : '' }}>En Cours</option>
                                <option value="juge" {{ old('statut') == 'juge' ? 'selected' : '' }}>Jugé</option>
                                <option value="appel" {{ old('statut') == 'appel' ? 'selected' : '' }}>En Appel</option>
                                <option value="cassation" {{ old('statut') == 'cassation' ? 'selected' : '' }}>Cassation</option>
                                <option value="clos" {{ old('statut') == 'clos' ? 'selected' : '' }}>Clos</option>
                            </select>
                        </div>
                        @if($errors->has('statut'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('statut') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="section-divider">
                    <i class="bi bi-calendar3"></i> Dates
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">
                            Date d'Ouverture <span class="required">*</span>
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-calendar-plus input-icon"></i>
                            <input type="date" 
                                   name="date_ouverture" 
                                   class="form-control-dark {{ $errors->has('date_ouverture') ? 'is-invalid' : '' }}" 
                                   value="{{ old('date_ouverture', now()->format('Y-m-d')) }}" 
                                   required>
                        </div>
                        @if($errors->has('date_ouverture'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('date_ouverture') }}
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">
                            <i class="bi bi-calendar-x" style="color: var(--text-muted); margin-right: 5px;"></i>Date de Clôture
                        </label>
                        <div class="input-group-dark">
                            <i class="bi bi-calendar-check input-icon"></i>
                            <input type="date" 
                                   name="date_cloture" 
                                   class="form-control-dark {{ $errors->has('date_cloture') ? 'is-invalid' : '' }}" 
                                   value="{{ old('date_cloture') }}">
                        </div>
                        @if($errors->has('date_cloture'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('date_cloture') }}
                        </div>
                        @endif
                        <small style="color: var(--text-muted); font-size: 0.8rem; margin-top: 5px; display: block;">
                            <i class="bi bi-info-circle"></i> Laisser vide si le dossier est toujours en cours
                        </small>
                    </div>
                </div>

                <div class="section-divider">
                    <i class="bi bi-chat-left-text"></i> Observations
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="form-label">
                            <i class="bi bi-pencil-square" style="color: var(--text-muted); margin-right: 5px;"></i>Observations
                        </label>
                        <textarea name="observations" 
                                  class="form-textarea-dark {{ $errors->has('observations') ? 'is-invalid' : '' }}" 
                                  rows="4" 
                                  placeholder="Notes, observations ou remarques sur le dossier...">{{ old('observations') }}</textarea>
                        @if($errors->has('observations'))
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $errors->first('observations') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-12">
                        <button type="submit" class="btn-gold">
                            <i class="bi bi-check-lg"></i>
                            Créer le Dossier
                        </button>
                        <a href="{{ route('dossiers.index') }}" class="btn-outline ms-3">
                            <i class="bi bi-x-lg"></i>
                            Annuler
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('dossierForm').addEventListener('submit', function(e) {
        const dateOuverture = new Date(document.querySelector('[name="date_ouverture"]').value);
        const dateCloture = document.querySelector('[name="date_cloture"]').value;

        if (dateCloture) {
            const cloture = new Date(dateCloture);
            if (cloture < dateOuverture) {
                e.preventDefault();
                alert("La date de clôture doit être postérieure à la date d'ouverture.");
            }
        }
    });

    const currentYear = new Date().getFullYear();
    const numeroInput = document.querySelector('[name="numero_dossier"]');
    if (!numeroInput.value) {
        numeroInput.placeholder = 'Ex: ' + currentYear + '/001';
    }
</script>
@endpush