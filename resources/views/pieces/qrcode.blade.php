@extends('layouts.admin')

@section('title', 'QR Code - ' . $piece->reference)

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
    .qr-container {
        max-width: 500px;
        margin: 0 auto;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 30px;
        text-align: center;
    }
    .qr-code-box {
        background: white;
        padding: 20px;
        border-radius: 16px;
        display: inline-block;
        margin: 20px auto;
    }
    .qr-code-text {
        font-family: monospace;
        font-size: 18px;
        padding: 20px;
        background: #fff;
        color: #000;
        border-radius: 8px;
        word-break: break-all;
    }
    .btn-gold {
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%);
        color: #0a0e1a;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        border: none;
        cursor: pointer;
    }
    .btn-outline {
        background: transparent;
        border: 2px solid var(--accent-gold);
        color: var(--accent-gold);
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }
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
        margin: -30px -30px 30px -30px;
    }
    .breadcrumb-custom { color: var(--text-muted); font-size: 0.9rem; }
    .breadcrumb-custom a { color: var(--accent-gold); text-decoration: none; }
    .top-icon-btn { width: 42px; height: 42px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 1.1rem; cursor: pointer; transition: all 0.3s; border: none; }
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
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}">Accueil</a> / 
                <a href="{{ route('pieces.index') }}">Pièces</a> / 
                <span>QR Code</span>
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div style="padding: 30px;">
            <div class="qr-container">
                <h2 style="color: var(--accent-gold); margin-bottom: 20px;">
                    <i class="bi bi-qr-code"></i> QR Code
                </h2>
                <p><strong>{{ $piece->reference }}</strong></p>
                <p style="color: var(--text-muted);">{{ $piece->description }}</p>
                
                <div class="qr-code-box">
                    <div class="qr-code-text">
                        {{ $piece->qr_code }}
                    </div>
                </div>
                
                <p style="color: var(--text-muted); margin-top: 10px;">
                    <small>Code: {{ $piece->qr_code }}</small>
                </p>
                
                <div style="display: flex; gap: 15px; justify-content: center; margin-top: 25px;">
                    <a href="{{ route('pieces.show', $piece) }}" class="btn-gold">
                        <i class="bi bi-arrow-left"></i> Retour
                    </a>
                    <button onclick="window.print()" class="btn-outline">
                        <i class="bi bi-printer"></i> Imprimer
                    </button>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection