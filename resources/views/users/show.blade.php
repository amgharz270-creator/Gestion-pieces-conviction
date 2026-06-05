@extends('layouts.admin')

@section('title', 'Détails Utilisateur - TPI Sidi Bennour')

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
    .detail-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 35px; margin-bottom: 25px; }
    .detail-card h3 { color: var(--accent-gold); font-weight: 700; font-size: 1.2rem; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .detail-row { display: flex; justify-content: space-between; padding: 15px 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
    .detail-row:last-child { border-bottom: none; }
    .detail-label { color: var(--text-muted); font-size: 0.9rem; }
    .detail-value { color: var(--text-light); font-weight: 600; text-align: right; }
    .role-badge-lg { padding: 8px 20px; border-radius: 25px; font-size: 0.9rem; font-weight: 600; display: inline-block; }
    .role-admin { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .role-responsable_argent { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .role-responsable_destruction { background: rgba(220, 53, 69, 0.15); color: #dc3545; }
    .role-responsable_conservation { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 25px; }
    .stat-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 16px; padding: 25px 20px; text-align: center; }
    .stat-number { font-size: 2rem; font-weight: 800; color: var(--text-light); }
    .stat-label { color: var(--text-muted); font-size: 0.8rem; margin-top: 5px; }
    .avatar-large { width: 100px; height: 100px; background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: 700; color: var(--primary-dark); margin: 0 auto 20px; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; }
    .top-bar { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border-bottom: 1px solid rgba(255,255,255,0.08); padding: 15px 30px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100; margin: -30px -30px 30px -30px; }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .stats-grid { grid-template-columns: repeat(2, 1fr); } }
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
                <span>{{ $user->name }}</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div class="page-header" style="margin-bottom: 30px;">
            <div>
                <a href="{{ route('users.index') }}"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
                <h1 style="color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-top: 15px;">
                    <i class="bi bi-person-circle" style="color: var(--accent-gold);"></i> {{ $user->name }}
                </h1>
            </div>
            <div>
                <a href="{{ route('users.edit', $user) }}" class="btn-gold"><i class="bi bi-pencil"></i> Modifier</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="detail-card text-center">
                    <div class="avatar-large">{{ substr($user->name, 0, 1) }}</div>
                    <h3 style="color: var(--text-light); margin-bottom: 10px;">{{ $user->name }}</h3>
                    <span class="role-badge-lg role-{{ $user->role_special }}">
                        @if($user->role_special == 'admin') 👑 Administrateur
                        @elseif($user->role_special == 'responsable_argent') 💰 المحجوز النقدي
                        @elseif($user->role_special == 'responsable_destruction') 🔥 المحجوز للإتلاف
                        @elseif($user->role_special == 'responsable_conservation') 📦 محجوزات يتم الاحتفاظ بها
                        @endif
                    </span>
                    <div style="margin-top: 20px;">
                        @if($user->actif)
                            <span style="color: #28a745;"><i class="bi bi-check-circle-fill"></i> Compte actif</span>
                        @else
                            <span style="color: #dc3545;"><i class="bi bi-x-circle-fill"></i> Compte inactif</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="detail-card">
                    <h3><i class="bi bi-info-circle me-2"></i>Informations personnelles</h3>
                    <div class="detail-row">
                        <span class="detail-label">Nom complet</span>
                        <span class="detail-value">{{ $user->name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Adresse email</span>
                        <span class="detail-value">{{ $user->email }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Rôle spécial</span>
                        <span class="detail-value">
                            @if($user->role_special == 'admin') 👑 Administrateur
                            @elseif($user->role_special == 'responsable_argent') 💰 Responsable المحجوز النقدي
                            @elseif($user->role_special == 'responsable_destruction') 🔥 Responsable المحجوز للإتلاف
                            @elseif($user->role_special == 'responsable_conservation') 📦 Responsable محجوزات يتم الاحتفاظ بها
                            @endif
                        </span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Compte créé le</span>
                        <span class="detail-value">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Dernière modification</span>
                        <span class="detail-value">{{ $user->updated_at->format('d/m/Y à H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Pièces créées</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Inventaires réalisés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Mouvements effectués</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">0</div>
                <div class="stat-label">Restitutions effectuées</div>
            </div>
        </div>
    </main>
</div>
@endsection