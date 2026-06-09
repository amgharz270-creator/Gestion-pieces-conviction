@extends('layouts.admin')

@section('title', 'Tableau de Bord Admin - TPI Sidi Bennour')

@push('styles')
<style>
    /* ===== VARIABLES ===== */
    :root {
        --primary-dark: #0a0e1a;
        --secondary-dark: #1e3a5f;
        --accent-gold: #c9a227;
        --accent-gold-light: #e8d5a3;
        --text-light: #ffffff;
        --text-muted: rgba(255,255,255,0.6);
        --card-bg: rgba(255,255,255,0.05);
        --card-border: rgba(255,255,255,0.1);
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
    }

    /* ===== SIDEBAR ===== */
    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 280px;
        height: 100vh;
        background: linear-gradient(180deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
        border-right: 1px solid rgba(201, 162, 39, 0.2);
        z-index: 1000;
        transition: all 0.3s ease;
        overflow-y: auto;
    }

    .sidebar-header {
        padding: 30px 25px;
        text-align: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }

    .sidebar-logo {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 32px;
        color: var(--primary-dark);
        box-shadow: 0 5px 20px rgba(201, 162, 39, 0.3);
    }

    .sidebar-header h3 {
        color: var(--text-light);
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .sidebar-header p {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .sidebar-menu {
        padding: 20px 15px;
    }

    .menu-section {
        margin-bottom: 25px;
    }

    .menu-section-title {
        color: var(--accent-gold);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        padding: 0 15px;
        margin-bottom: 12px;
    }

    .menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: 12px;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.3s ease;
        margin-bottom: 5px;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .menu-item i {
        font-size: 1.2rem;
        width: 24px;
        text-align: center;
    }

    .menu-item:hover,
    .menu-item.active {
        background: rgba(201, 162, 39, 0.15);
        color: var(--accent-gold);
        border: 1px solid rgba(201, 162, 39, 0.3);
    }

    .menu-item.active {
        background: linear-gradient(135deg, rgba(201, 162, 39, 0.2) 0%, rgba(201, 162, 39, 0.1) 100%);
        border-color: var(--accent-gold);
    }

    .badge-count {
        margin-left: auto;
        background: var(--accent-gold);
        color: var(--primary-dark);
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .sidebar-footer {
        padding: 20px 25px;
        border-top: 1px solid rgba(255,255,255,0.1);
        position: absolute;
        bottom: 0;
        width: 100%;
        background: linear-gradient(180deg, transparent 0%, var(--primary-dark) 100%);
    }

    .user-profile-mini {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, var(--accent-gold) 0%, #b8941f 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .user-info-mini h4 {
        color: var(--text-light);
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .user-info-mini span {
        color: var(--accent-gold);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ===== MAIN CONTENT ===== */
    .main-content {
        margin-left: 280px;
        min-height: 100vh;
        background: linear-gradient(135deg, #0f1e3a 0%, #0a0e1a 100%);
        transition: all 0.3s ease;
    }

    /* Top Bar */
    .top-bar {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid rgba(255,255,255,0.08);
        padding: 15px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .top-bar-left {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .menu-toggle {
        background: none;
        border: none;
        color: var(--text-light);
        font-size: 1.5rem;
        cursor: pointer;
        display: none;
    }

    .breadcrumb-custom {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .breadcrumb-custom a {
        color: var(--accent-gold);
        text-decoration: none;
    }

    .top-bar-right {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .top-icon-btn {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.1rem;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
    }

    .top-icon-btn:hover {
        background: rgba(201, 162, 39, 0.15);
        border-color: var(--accent-gold);
        color: var(--accent-gold);
    }

    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: var(--danger);
        color: white;
        border-radius: 50%;
        font-size: 0.7rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ===== STATS CARDS ===== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
        margin-bottom: 35px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 30px 25px;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-gold), var(--accent-gold-light));
        opacity: 0;
        transition: opacity 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(201, 162, 39, 0.3);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    .stat-card:hover::before {
        opacity: 1;
    }

    .stat-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .stat-icon.pieces { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .stat-icon.dossiers { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .stat-icon.restitutions { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .stat-icon.users { background: rgba(255, 193, 7, 0.15); color: var(--warning); }

    .stat-trend {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
    }

    .trend-up {
        background: rgba(40, 167, 69, 0.15);
        color: var(--success);
    }

    .trend-down {
        background: rgba(220, 53, 69, 0.15);
        color: var(--danger);
    }

    .stat-number {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--text-light);
        margin-bottom: 8px;
        line-height: 1;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* ===== CHARTS SECTION ===== */
    .charts-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
        margin-bottom: 35px;
    }

    .chart-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 30px;
    }

    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .chart-header h3 {
        color: var(--text-light);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .chart-filter {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        color: var(--text-muted);
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 0.85rem;
        cursor: pointer;
    }

    .chart-placeholder {
        height: 300px;
        background: linear-gradient(135deg, rgba(30, 58, 95, 0.3) 0%, rgba(21, 41, 66, 0.3) 100%);
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        border: 2px dashed rgba(255,255,255,0.1);
    }

    /* ===== RECENT ACTIVITY ===== */
    .activity-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 30px;
    }

    .activity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 25px;
    }

    .activity-header h3 {
        color: var(--text-light);
        font-weight: 700;
        font-size: 1.2rem;
    }

    .view-all-btn {
        color: var(--accent-gold);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s;
    }

    .view-all-btn:hover {
        color: var(--accent-gold-light);
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 15px;
        padding: 18px;
        background: rgba(255,255,255,0.03);
        border-radius: 15px;
        border: 1px solid rgba(255,255,255,0.05);
        transition: all 0.3s;
    }

    .activity-item:hover {
        background: rgba(255,255,255,0.05);
        border-color: rgba(201, 162, 39, 0.2);
        transform: translateX(5px);
    }

    .activity-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .activity-icon.saisie { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .activity-icon.transfert { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .activity-icon.restitution { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .activity-icon.alert { background: rgba(220, 53, 69, 0.15); color: var(--danger); }

    .activity-content h4 {
        color: var(--text-light);
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .activity-content p {
        color: var(--text-muted);
        font-size: 0.85rem;
        margin-bottom: 5px;
    }

    .activity-time {
        color: rgba(255,255,255,0.3);
        font-size: 0.75rem;
    }

    /* ===== QUICK ACTIONS ===== */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 35px;
    }

    .quick-action-btn {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 16px;
        padding: 25px 20px;
        text-align: center;
        text-decoration: none;
        color: var(--text-light);
        transition: all 0.4s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .quick-action-btn:hover {
        background: rgba(201, 162, 39, 0.1);
        border-color: var(--accent-gold);
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
    }

    .quick-action-btn i {
        width: 55px;
        height: 55px;
        background: linear-gradient(135deg, rgba(30, 58, 95, 0.6) 0%, rgba(21, 41, 66, 0.6) 100%);
        border: 2px solid rgba(201, 162, 39, 0.3);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--accent-gold);
        transition: all 0.3s;
    }

    .quick-action-btn:hover i {
        background: linear-gradient(135deg, rgba(201, 162, 39, 0.2) 0%, rgba(201, 162, 39, 0.1) 100%);
        border-color: var(--accent-gold);
        transform: scale(1.1);
    }

    .quick-action-btn span {
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* ===== TABLES ===== */
    .table-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 30px;
        overflow-x: auto;
    }

    .table-dark-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-dark-custom thead th {
        color: var(--accent-gold);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px 20px;
        text-align: left;
        border-bottom: 2px solid rgba(201, 162, 39, 0.2);
    }

    .table-dark-custom tbody tr {
        background: rgba(255,255,255,0.03);
        transition: all 0.3s;
    }

    .table-dark-custom tbody tr:hover {
        background: rgba(255,255,255,0.06);
        transform: scale(1.01);
    }

    .table-dark-custom tbody td {
        padding: 18px 20px;
        color: var(--text-muted);
        font-size: 0.9rem;
        border-top: 1px solid rgba(255,255,255,0.05);
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .table-dark-custom tbody td:first-child {
        border-radius: 12px 0 0 12px;
        border-left: 1px solid rgba(255,255,255,0.05);
    }

    .table-dark-custom tbody td:last-child {
        border-radius: 0 12px 12px 0;
        border-right: 1px solid rgba(255,255,255,0.05);
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-depot {
        background: rgba(23, 162, 184, 0.15);
        color: var(--info);
    }

    .status-saisie {
        background: rgba(201, 162, 39, 0.15);
        color: var(--accent-gold);
    }

    .status-restituee {
        background: rgba(40, 167, 69, 0.15);
        color: var(--success);
    }

    .status-en-cours {
        background: rgba(255, 193, 7, 0.15);
        color: var(--warning);
    }

    .action-btns {
        display: flex;
        gap: 8px;
    }

    .btn-icon-sm {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        border: 1px solid rgba(255,255,255,0.1);
        background: rgba(255,255,255,0.05);
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }

    .btn-icon-sm:hover {
        background: rgba(201, 162, 39, 0.15);
        border-color: var(--accent-gold);
        color: var(--accent-gold);
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .charts-grid {
            grid-template-columns: 1fr;
        }
        .quick-actions-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .admin-sidebar {
            transform: translateX(-100%);
        }
        .admin-sidebar.active {
            transform: translateX(0);
        }
        .main-content {
            margin-left: 0;
        }
        .menu-toggle {
            display: block;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .quick-actions-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')

<div class="admin-wrapper">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="admin-sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h3>TPI Sidi Bennour</h3>
            <p>Système de Gestion Judiciaire</p>
        </div>

        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">Principal</div>
                <a href="{{ route('dashboard') }}" class="menu-item active">
                    <i class="bi bi-grid-fill"></i>
                    <span>Tableau de Bord</span>
                </a>
                <a href="{{ route('pieces.index') }}" class="menu-item">
                    <i class="bi bi-box-seam"></i>
                    <span>Pièces à Conviction</span>
                    <span class="badge-count">{{ $piecesCount ?? 0 }}</span>
                </a>
                <a href="{{ route('dossiers.index') }}" class="menu-item">
                    <i class="bi bi-folder"></i>
                    <span>Dossiers</span>
                    <span class="badge-count">{{ $dossiersCount ?? 0 }}</span>
                </a>
                <a href="{{ route('emplacements.index') }}" class="menu-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>Emplacements</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Gestion</div>
                <a href="{{ route('restitutions.index') }}" class="menu-item">
                    <i class="bi bi-arrow-return-left"></i>
                    <span>Restitutions</span>
                    <span class="badge-count">8</span>
                </a>
                <a href="{{ route('inventaires.index') }}" class="menu-item">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Inventaires</span>
                </a>
                <a href="{{ route('mouvements.index') }}" class="menu-item">
                    <i class="bi bi-arrow-left-right"></i>
                    <span>Mouvements</span>
                </a>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">Administration</div>
                <a href="{{ route('users.index') }}" class="menu-item">
                    <i class="bi bi-people"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="{{ route('roles.index') }}" class="menu-item">
                    <i class="bi bi-shield-check"></i>
                    <span>Rôles & Permissions</span>
                </a>
                <a href="{{ route('rapports.index') }}" class="menu-item">
                    <i class="bi bi-graph-up"></i>
                    <span>Rapports & Stats</span>
                </a>
                <a href="{{ route('parametres.index') }}" class="menu-item">
                    <i class="bi bi-gear"></i>
                    <span>Paramètres</span>
                </a>
            </div>
        </nav>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="main-content">

        {{-- Top Bar --}}
        <div class="top-bar">
            <div class="top-bar-left">
                <button class="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="breadcrumb-custom">
                    <a href="{{ route('dashboard') }}">Accueil</a> / Tableau de Bord
                </div>
            </div>
            <div class="top-bar-right">
                <div class="top-icon-btn" onclick="toggleSearch()">
                    <i class="bi bi-search"></i>
                </div>
                <div class="top-icon-btn" onclick="toggleNotifications()">
                    <i class="bi bi-bell-fill"></i>
                    <span class="notification-badge">3</span>
                </div>
                <div class="top-icon-btn" onclick="toggleMessages()">
                    <i class="bi bi-envelope-fill"></i>
                    <span class="notification-badge">0</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <!-- Modal Search -->
        <div id="searchModal" style="display: none; position: fixed; top: 70px; right: 20px; width: 350px; background: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border); z-index: 1001;">
            <div style="padding: 20px;">
                <input type="text" id="searchInput" placeholder="Rechercher..." style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 8px; color: #fff;">
                <div id="searchResults" style="margin-top: 15px; max-height: 300px; overflow-y: auto;"></div>
            </div>
        </div>

        <!-- Modal Notifications -->
        <div id="notifModal" style="display: none; position: fixed; top: 70px; right: 20px; width: 350px; background: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border); z-index: 1001;">
            <div style="padding: 20px;">
                <h4 style="color: var(--accent-gold); margin-bottom: 15px;">Notifications</h4>
                <div id="notificationsList">
                    <div class="notif-item" style="padding: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <i class="bi bi-box-seam" style="color: #c9a227;"></i>
                        <span>Nouvelle pièce ajoutée</span>
                        <small style="display: block; color: var(--text-muted);">Il y a 5 min</small>
                    </div>
                    <div class="notif-item" style="padding: 10px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                        <i class="bi bi-arrow-return-left" style="color: #28a745;"></i>
                        <span>Demande de restitution #8</span>
                        <small style="display: block; color: var(--text-muted);">Il y a 2 heures</small>
                    </div>
                    <div class="notif-item" style="padding: 10px;">
                        <i class="bi bi-exclamation-triangle" style="color: #ffc107;"></i>
                        <span>Inventaire planifié demain</span>
                        <small style="display: block; color: var(--text-muted);">Il y a 1 jour</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Messages -->
        <div id="msgModal" style="display: none; position: fixed; top: 70px; right: 20px; width: 350px; background: var(--card-bg); border-radius: 16px; border: 1px solid var(--card-border); z-index: 1001;">
            <div style="padding: 20px;">
                <h4 style="color: var(--accent-gold); margin-bottom: 15px;">Messages</h4>
                <div id="messagesList">
                    <div style="text-align: center; color: var(--text-muted); padding: 20px;">
                        <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                        <p>Aucun message</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Dashboard Content --}}
        <div style="padding: 30px;">

            {{-- Page Title --}}
            <div style="margin-bottom: 30px;">
                <h1 style="color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-bottom: 8px;">
                    Tableau de Bord
                </h1>
                <p style="color: var(--text-muted); font-size: 0.95rem;">
                    Bienvenue {{ Auth::user()->name }}, voici un aperçu de l'activité du système
                </p>
            </div>

            {{-- Stats Cards --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon pieces">
                            <i class="bi bi-box-seam"></i>
                        </div>
                        <span class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-short"></i> 12%
                        </span>
                    </div>
                    <div class="stat-number">156</div>
                    <div class="stat-label">Pièces à Conviction</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon dossiers">
                            <i class="bi bi-folder"></i>
                        </div>
                        <span class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-short"></i> 5%
                        </span>
                    </div>
                    <div class="stat-number">45</div>
                    <div class="stat-label">Dossiers Actifs</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon restitutions">
                            <i class="bi bi-arrow-return-left"></i>
                        </div>
                        <span class="stat-trend trend-down">
                            <i class="bi bi-arrow-down-short"></i> 2%
                        </span>
                    </div>
                    <div class="stat-number">12</div>
                    <div class="stat-label">Restitutions ce Mois</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-icon users">
                            <i class="bi bi-people"></i>
                        </div>
                        <span class="stat-trend trend-up">
                            <i class="bi bi-arrow-up-short"></i> 8%
                        </span>
                    </div>
                    <div class="stat-number">8</div>
                    <div class="stat-label">Utilisateurs Actifs</div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div style="margin-bottom: 10px;">
                <h3 style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin-bottom: 20px;">
                    <i class="bi bi-lightning-charge" style="color: var(--accent-gold); margin-right: 8px;"></i>
                    Actions Rapides
                </h3>
            </div>
            <div class="quick-actions-grid">
                <a href="{{ route('pieces.create') }}" class="quick-action-btn">
                    <i class="bi bi-plus-lg"></i>
                    <span>Nouvelle Pièce</span>
                </a>
                <a href="{{ route('dossiers.create') }}" class="quick-action-btn">
                    <i class="bi bi-folder-plus"></i>
                    <span>Nouveau Dossier</span>
                </a>
                <a href="{{ route('qr-scanner') }}" class="quick-action-btn">
    <i class="bi bi-qr-code"></i>
    <span>Scanner QR Code</span>
</a>
                <a href="{{ route('generer.rapport') }}" class="quick-action-btn">
    <i class="bi bi-file-earmark-text"></i>
    <span>Générer Rapport</span>
</a>
            </div>

            {{-- Charts & Activity --}}
            <div class="charts-grid">
                {{-- Main Chart --}}
                <div class="chart-card">
                    <div class="chart-header">
                        <h3><i class="bi bi-graph-up" style="color: var(--accent-gold); margin-right: 10px;"></i>Évolution des Pièces</h3>
                        <select class="chart-filter">
                            <option>Cette Année</option>
                            <option>Ce Mois</option>
                            <option>Cette Semaine</option>
                        </select>
                    </div>
                    <div class="chart-placeholder" style="padding: 0; background: none;">
                        <canvas id="evolutionChart" style="max-height: 300px; width: 100%;"></canvas>
                    </div>
                </div>

                {{-- Activity Feed --}}
                <div class="activity-card">
                    <div class="activity-header">
                        <h3><i class="bi bi-clock-history" style="color: var(--accent-gold); margin-right: 10px;"></i>Activité Récente</h3>
                        <a href="#" class="view-all-btn">Voir tout <i class="bi bi-arrow-right-short"></i></a>
                    </div>
                    <div class="activity-list">
                        <div class="activity-item">
                            <div class="activity-icon saisie">
                                <i class="bi bi-plus-lg"></i>
                            </div>
                            <div class="activity-content">
                                <h4>Nouvelle saisie enregistrée</h4>
                                <p>Pièce PC-2026-0156 ajoutée au dossier 2026/45</p>
                                <span class="activity-time"><i class="bi bi-clock"></i> Il y a 15 min</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon transfert">
                                <i class="bi bi-arrow-left-right"></i>
                            </div>
                            <div class="activity-content">
                                <h4>Transfert de pièce</h4>
                                <p>PC-2026-0142 déplacée vers Salle B - Armoire 3</p>
                                <span class="activity-time"><i class="bi bi-clock"></i> Il y a 45 min</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon restitution">
                                <i class="bi bi-check-lg"></i>
                            </div>
                            <div class="activity-content">
                                <h4>Restitution approuvée</h4>
                                <p>Demande #R-2026-008 approuvée par le Juge</p>
                                <span class="activity-time"><i class="bi bi-clock"></i> Il y a 2h</span>
                            </div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon alert">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div class="activity-content">
                                <h4>Alerte inventaire</h4>
                                <p>Pièce PC-2026-0098 non localisée lors du dernier contrôle</p>
                                <span class="activity-time"><i class="bi bi-clock"></i> Il y a 3h</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Pieces Table --}}
            <div style="margin-bottom: 15px;">
                <h3 style="color: var(--text-light); font-weight: 700; font-size: 1.1rem; margin-bottom: 20px;">
                    <i class="bi bi-box-seam" style="color: var(--accent-gold); margin-right: 8px;"></i>
                    Pièces Récentes
                </h3>
            </div>
            <div class="table-card">
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Catégorie</th>
                            <th>Dossier</th>
                            <th>Emplacement</th>
                            <th>Statut</th>
                            <th>Date Saisie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="color: var(--text-light); font-weight: 600;">PC-2026-0156</td>
                            <td><i class="bi bi-phone" style="color: var(--info); margin-right: 5px;"></i> Électronique</td>
                            <td>2026/45</td>
                            <td><i class="bi bi-geo-alt" style="color: var(--accent-gold); margin-right: 5px;"></i> Salle A - Armoire 2</td>
                            <td><span class="status-badge status-depot">En Dépôt</span></td>
                            <td>15/05/2026</td>
                            <td>
                                <div class="action-btns">
                                    <a href="#" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn-icon-sm" title="QR Code"><i class="bi bi-qr-code"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: var(--text-light); font-weight: 600;">PC-2026-0155</td>
                            <td><i class="bi bi-file-text" style="color: var(--warning); margin-right: 5px;"></i> Document</td>
                            <td>2026/44</td>
                            <td><i class="bi bi-geo-alt" style="color: var(--accent-gold); margin-right: 5px;"></i> Salle B - Armoire 1</td>
                            <td><span class="status-badge status-saisie">Saisie</span></td>
                            <td>14/05/2026</td>
                            <td>
                                <div class="action-btns">
                                    <a href="#" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn-icon-sm" title="QR Code"><i class="bi bi-qr-code"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: var(--text-light); font-weight: 600;">PC-2026-0154</td>
                            <td><i class="bi bi-cash" style="color: var(--success); margin-right: 5px;"></i> Argent</td>
                            <td>2026/43</td>
                            <td><i class="bi bi-geo-alt" style="color: var(--accent-gold); margin-right: 5px;"></i> Coffre Fort</td>
                            <td><span class="status-badge status-depot">En Dépôt</span></td>
                            <td>13/05/2026</td>
                            <td>
                                <div class="action-btns">
                                    <a href="#" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn-icon-sm" title="QR Code"><i class="bi bi-qr-code"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: var(--text-light); font-weight: 600;">PC-2026-0153</td>
                            <td><i class="bi bi-car-front" style="color: var(--danger); margin-right: 5px;"></i> Véhicule</td>
                            <td>2026/42</td>
                            <td><i class="bi bi-geo-alt" style="color: var(--accent-gold); margin-right: 5px;"></i> Parking</td>
                            <td><span class="status-badge status-restituee">Restituée</span></td>
                            <td>12/05/2026</td>
                            <td>
                                <div class="action-btns">
                                    <a href="#" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn-icon-sm" title="QR Code"><i class="bi bi-qr-code"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: var(--text-light); font-weight: 600;">PC-2026-0152</td>
                            <td><i class="bi bi-gem" style="color: var(--accent-gold); margin-right: 5px;"></i> Bijou</td>
                            <td>2026/41</td>
                            <td><i class="bi bi-geo-alt" style="color: var(--accent-gold); margin-right: 5px;"></i> Salle A - Armoire 1</td>
                            <td><span class="status-badge status-en-cours">Expertise</span></td>
                            <td>11/05/2026</td>
                            <td>
                                <div class="action-btns">
                                    <a href="#" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                    <a href="#" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                                    <a href="#" class="btn-icon-sm" title="QR Code"><i class="bi bi-qr-code"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Graphique
    const chartCanvas = document.getElementById('evolutionChart');
    if (chartCanvas) {
        const chartCtx = chartCanvas.getContext('2d');
        const chartLabels = @json(array_column($chartData ?? [], 'mois'));
        const piecesData = @json(array_column($chartData ?? [], 'pieces'));
        const restitutionsData = @json(array_column($chartData ?? [], 'restitutions'));

        new Chart(chartCtx, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [
                    {
                        label: 'Pièces à Conviction',
                        data: piecesData,
                        borderColor: '#c9a227',
                        backgroundColor: 'rgba(201, 162, 39, 0.1)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#c9a227',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Restitutions',
                        data: restitutionsData,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.05)',
                        borderWidth: 3,
                        tension: 0.3,
                        fill: true,
                        pointBackgroundColor: '#28a745',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        labels: {
                            color: '#fff',
                            font: { family: 'Poppins', size: 12 }
                        },
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        titleColor: '#c9a227',
                        bodyColor: '#fff'
                    }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: 'rgba(255,255,255,0.6)' },
                        title: { display: true, text: 'Nombre', color: '#fff' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: 'rgba(255,255,255,0.6)' }
                    }
                }
            }
        });
    }

    // Toggle Sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('active');
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.menu-toggle');
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('active');
            }
        }
    });

    // Toggle Search
    function toggleSearch() {
        var modal = document.getElementById('searchModal');
        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
        if (modal.style.display === 'block') {
            document.getElementById('searchInput').focus();
        }
    }
    
    // Toggle Notifications
    function toggleNotifications() {
        var modal = document.getElementById('notifModal');
        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    }
    
    // Toggle Messages
    function toggleMessages() {
        var modal = document.getElementById('msgModal');
        modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    }
    
    // Fermer les modals en cliquant ailleurs
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.top-icon-btn') && !e.target.closest('#searchModal') && !e.target.closest('#notifModal') && !e.target.closest('#msgModal')) {
            document.getElementById('searchModal').style.display = 'none';
            document.getElementById('notifModal').style.display = 'none';
            document.getElementById('msgModal').style.display = 'none';
        }
    });
    
    // Search function
    document.getElementById('searchInput')?.addEventListener('input', function() {
        var query = this.value;
        if (query.length > 2) {
            fetch('/search?q=' + query)
                .then(response => response.json())
                .then(data => {
                    var results = document.getElementById('searchResults');
                    results.innerHTML = '';
                    data.forEach(item => {
                        results.innerHTML += '<a href="' + item.url + '" style="display: block; padding: 10px; color: #fff; text-decoration: none; border-bottom: 1px solid rgba(255,255,255,0.1);">' + item.title + '</a>';
                    });
                });
        }
    });
</script>
@endpush