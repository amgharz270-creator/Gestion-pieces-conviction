@extends('layouts.admin')

@section('title', 'Modifier Utilisateur - TPI Sidi Bennour')

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
        --warning: #ffc107;
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
    .form-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 40px; max-width: 800px; margin: 0 auto; }
    .form-control-dark {
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 14px 18px;
        color: #fff;
        width: 100%;
        transition: all 0.3s;
    }
    .form-control-dark:focus {
        background: rgba(255,255,255,0.08);
        border-color: var(--accent-gold);
        outline: none;
    }
    .page-header { margin-bottom: 30px; }
    .page-header a { color: var(--text-muted); text-decoration: none; }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-top: 15px; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 14px 35px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 10px; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 14px 35px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    .top-icon-btn:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .role-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px; }
    .role-admin { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    hr { border-color: rgba(255,255,255,0.1); margin: 30px 0; }
    .info-box { background: rgba(201, 162, 39, 0.1); border: 1px solid rgba(201, 162, 39, 0.2); border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 10px; }
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
                <a href="{{ route('users.index') }}" class="menu-item active"><i class="bi bi-people"></i><span>Utilisateurs</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right"></i>
                <a href="{{ route('users.index') }}">Utilisateurs</a>
                <i class="bi bi-chevron-right"></i>
                <span>Modifier</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header">
            <div>
                <a href="{{ route('users.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1><i class="bi bi-pencil" style="color: var(--accent-gold); margin-right: 12px;"></i>Modifier l'utilisateur</h1>
            </div>
        </div>

        <div class="form-card">
            <div class="info-box">
                <i class="bi bi-info-circle-fill" style="color: var(--accent-gold);"></i>
                Modification de l'utilisateur <strong>{{ $user->name }}</strong> ({{ $user->email }})
            </div>

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    <div class="col-12">
                        <label style="color: var(--text-light); font-weight: 600;">Nom complet *</label>
                        <input type="text" name="name" class="form-control-dark" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="col-12">
                        <label style="color: var(--text-light); font-weight: 600;">Email *</label>
                        <input type="email" name="email" class="form-control-dark" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="col-12">
                        <label style="color: var(--text-light); font-weight: 600;">Rôle spécial *</label>
                        <select name="role_special" class="form-control-dark" required>
                            <option value="admin" {{ old('role_special', $user->role_special) == 'admin' ? 'selected' : '' }}>👑 Administrateur</option>
                            <option value="responsable_argent" {{ old('role_special', $user->role_special) == 'responsable_argent' ? 'selected' : '' }}>💰 Responsable المحجوز النقدي</option>
                            <option value="responsable_destruction" {{ old('role_special', $user->role_special) == 'responsable_destruction' ? 'selected' : '' }}>🔥 Responsable المحجوز للإتلاف</option>
                            <option value="responsable_conservation" {{ old('role_special', $user->role_special) == 'responsable_conservation' ? 'selected' : '' }}>📦 Responsable محجوزات يتم الاحتفاظ بها</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn-gold"><i class="bi bi-save"></i> Mettre à jour</button>
                        <a href="{{ route('users.index') }}" class="btn-outline ms-3">Annuler</a>
                    </div>
                </div>
            </form>

            <hr>

            <h4 style="color: var(--accent-gold); margin-bottom: 20px;"><i class="bi bi-key"></i> Changer le mot de passe</h4>
            <form action="{{ route('users.updatePassword', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label style="color: var(--text-light); font-weight: 600;">Nouveau mot de passe</label>
                        <input type="password" name="password" class="form-control-dark" required>
                    </div>
                    <div class="col-md-6">
                        <label style="color: var(--text-light); font-weight: 600;">Confirmer</label>
                        <input type="password" name="password_confirmation" class="form-control-dark" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-gold"><i class="bi bi-key"></i> Changer le mot de passe</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection