@extends('layouts.admin')

@section('title', 'Paramètres - TPI Sidi Bennour')

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
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; }
    .settings-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-bottom: 30px; }
    .settings-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; overflow: hidden; }
    .settings-card-header { padding: 20px 25px; border-bottom: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.03); }
    .settings-card-header h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin: 0; display: flex; align-items: center; gap: 10px; }
    .settings-card-body { padding: 25px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; color: var(--text-light); font-weight: 500; margin-bottom: 8px; font-size: 0.9rem; }
    .form-control, .form-select {
        width: 100%;
        padding: 12px 15px;
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        color: #fff;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: var(--accent-gold);
        background: rgba(255,255,255,0.08);
    }
    .form-check { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
    .form-check input { width: 18px; height: 18px; cursor: pointer; accent-color: var(--accent-gold); }
    .form-check label { color: var(--text-light); cursor: pointer; margin: 0; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: all 0.3s; width: 100%; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s; width: 100%; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .alert-success { background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3); color: #75b798; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
    .alert-error { background: rgba(220, 53, 69, 0.15); border: 1px solid rgba(220, 53, 69, 0.3); color: #f5c6cb; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
    .alert-info { background: rgba(23, 162, 184, 0.15); border: 1px solid rgba(23, 162, 184, 0.3); color: #9ee7f5; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    hr { border-color: rgba(255,255,255,0.1); margin: 20px 0; }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .settings-grid { grid-template-columns: 1fr; } }
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
                <a href="{{ route('rapports.index') }}" class="menu-item"><i class="bi bi-graph-up"></i><span>Rapports & Stats</span></a>
                <a href="{{ route('parametres.index') }}" class="menu-item active"><i class="bi bi-gear"></i><span>Paramètres</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right"></i>
                <span>Paramètres</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <h1><i class="bi bi-gear" style="color: var(--accent-gold);"></i> Paramètres du système</h1>
        </div>

        @if(session('success'))
        <div class="alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert-error"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
        @endif
        @if(session('info'))
        <div class="alert-info"><i class="bi bi-info-circle-fill"></i> {{ session('info') }}</div>
        @endif

        <div class="settings-grid">
            <!-- Carte 1: Paramètres généraux -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3><i class="bi bi-building"></i> Général</h3>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updateGeneral') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nom de l'application</label>
                            <input type="text" name="app_name" class="form-control" value="{{ $params['general']['app_name'] }}">
                        </div>
                        <div class="form-group">
                            <label>Email de contact</label>
                            <input type="email" name="app_email" class="form-control" value="{{ $params['general']['app_email'] }}">
                        </div>
                        <div class="form-group">
                            <label>Téléphone</label>
                            <input type="text" name="app_phone" class="form-control" value="{{ $params['general']['app_phone'] }}">
                        </div>
                        <div class="form-group">
                            <label>Adresse</label>
                            <input type="text" name="app_address" class="form-control" value="{{ $params['general']['app_address'] }}">
                        </div>
                        <div class="form-group">
                            <label>Éléments par page</label>
                            <select name="items_per_page" class="form-select">
                                <option value="10" {{ $params['general']['items_per_page'] == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ $params['general']['items_per_page'] == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ $params['general']['items_per_page'] == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ $params['general']['items_per_page'] == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Format de date</label>
                            <select name="date_format" class="form-select">
                                <option value="d/m/Y" {{ $params['general']['date_format'] == 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                                <option value="m/d/Y" {{ $params['general']['date_format'] == 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                                <option value="Y-m-d" {{ $params['general']['date_format'] == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-gold">Enregistrer</button>
                    </form>
                </div>
            </div>

            <!-- Carte 2: Sécurité -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3><i class="bi bi-shield-lock"></i> Sécurité</h3>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updateSecurite') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Timeout session (minutes)</label>
                            <input type="number" name="session_timeout" class="form-control" value="{{ $params['securite']['session_timeout'] }}" min="5" max="480">
                        </div>
                        <div class="form-group">
                            <label>Expiration mot de passe (jours)</label>
                            <input type="number" name="password_expiry" class="form-control" value="{{ $params['securite']['password_expiry'] }}" min="30" max="365">
                        </div>
                        <div class="form-group">
                            <label>Tentatives max de connexion</label>
                            <input type="number" name="max_login_attempts" class="form-control" value="{{ $params['securite']['max_login_attempts'] }}" min="3" max="10">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="two_factor_auth" value="1" id="two_factor" {{ $params['securite']['two_factor_auth'] ? 'checked' : '' }}>
                            <label for="two_factor">Activer l'authentification à deux facteurs</label>
                        </div>
                        <hr>
                        <button type="submit" class="btn-gold">Enregistrer</button>
                    </form>
                </div>
            </div>

            <!-- Carte 3: Notifications -->
            <div class="settings-card">
                <div class="settings-card-header">
                    <h3><i class="bi bi-bell"></i> Notifications</h3>
                </div>
                <div class="settings-card-body">
                    <form action="{{ route('parametres.updateNotifications') }}" method="POST">
                        @csrf
                        <div class="form-check">
                            <input type="checkbox" name="email_notifications" value="1" id="email_notif" {{ $params['notifications']['email_notifications'] ? 'checked' : '' }}>
                            <label for="email_notif">Activer les notifications par email</label>
                        </div>
                        <div class="form-group">
                            <label>Alerte d'expiration (jours avant)</label>
                            <input type="number" name="expiration_alert_days" class="form-control" value="{{ $params['notifications']['expiration_alert_days'] }}" min="1" max="90">
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="inventory_reminder" value="1" id="inventory_reminder" {{ $params['notifications']['inventory_reminder'] ? 'checked' : '' }}>
                            <label for="inventory_reminder">Rappel d'inventaire mensuel</label>
                        </div>
                        <hr>
                        <button type="submit" class="btn-gold">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Carte Sauvegarde -->
        <div class="settings-card" style="margin-top: 25px;">
            <div class="settings-card-header">
                <h3><i class="bi bi-database"></i> Sauvegarde & Restauration</h3>
            </div>
            <div class="settings-card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <form action="{{ route('parametres.sauvegarde') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-gold" style="background: linear-gradient(135deg, #28a745, #1e7e34);">
                                <i class="bi bi-download"></i> Créer une sauvegarde
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('parametres.restaurer') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-2">
                                <div class="col-8">
                                    <input type="file" name="backup_file" class="form-control" accept=".sql">
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn-outline" style="width: 100%;">Restaurer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <small class="text-muted" style="display: block; margin-top: 15px; color: var(--text-muted);">
                    <i class="bi bi-info-circle"></i> Les sauvegardes sont stockées dans le dossier storage/backups/
                </small>
            </div>
        </div>
    </main>
</div>
@endsection