@extends('layouts.admin')

@section('title', 'Scanner QR Code - TPI Sidi Bennour')

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
    .scanner-container { max-width: 600px; margin: 0 auto; text-align: center; }
    .qr-input-area {
        background: var(--card-bg);
        border: 2px dashed var(--card-border);
        border-radius: 20px;
        padding: 40px;
        margin: 20px 0;
        cursor: pointer;
        transition: all 0.3s;
    }
    .qr-input-area:hover {
        border-color: var(--accent-gold);
        background: rgba(255,255,255,0.03);
    }
    .qr-input-area input {
        display: none;
    }
    .qr-input-area i {
        font-size: 4rem;
        color: var(--accent-gold);
        margin-bottom: 15px;
    }
    .result-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 25px;
        margin-top: 20px;
        text-align: left;
    }
    .btn-gold {
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%);
        color: #0a0e1a;
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }
    .piece-info {
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        padding: 15px;
        margin-top: 10px;
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
    .loading {
        display: none;
        text-align: center;
        padding: 20px;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid rgba(255,255,255,0.1);
        border-top-color: var(--accent-gold);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    @media (max-width: 768px) { .admin-sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
</style>
@endpush

@section('content')
<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="sidebar-header">
            <div class="sidebar-logo"><i class="bi bi-shield-lock-fill"></i></div>
            <h3>TPI Sidi Bennour</h3>
            <p>Système de Gestion Judiciaire</p>
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
                <a href="{{ route('inventaires.index') }}" class="menu-item"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
                <a href="{{ route('mouvements.index') }}" class="menu-item"><i class="bi bi-arrow-left-right"></i><span>Mouvements</span></a>
            </div>
            <div class="menu-section">
                <div class="menu-section-title">Administration</div>
                <a href="{{ route('users.index') }}" class="menu-item"><i class="bi bi-people"></i><span>Utilisateurs</span></a>
                <a href="{{ route('roles.index') }}" class="menu-item"><i class="bi bi-shield-check"></i><span>Rôles & Permissions</span></a>
                <a href="{{ route('rapports.index') }}" class="menu-item"><i class="bi bi-graph-up"></i><span>Rapports & Stats</span></a>
                <a href="{{ route('parametres.index') }}" class="menu-item"><i class="bi bi-gear"></i><span>Paramètres</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}">Accueil</a> / Scanner QR Code
            </div>
            <div class="top-bar-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="top-icon-btn"><i class="bi bi-box-arrow-right"></i></button>
                </form>
            </div>
        </div>

        <div style="padding: 30px;">
            <div class="scanner-container">
                <h1 style="color: var(--accent-gold); margin-bottom: 20px;">
                    <i class="bi bi-qr-code-scan"></i> Scanner QR Code
                </h1>
                <p style="color: var(--text-muted); margin-bottom: 20px;">
                    Téléchargez une image du QR code ou entrez le code manuellement
                </p>

                <div class="qr-input-area" onclick="document.getElementById('qrImage').click()">
                    <i class="bi bi-cloud-upload"></i>
                    <p>Cliquez pour télécharger une image du QR code</p>
                    <p style="font-size: 0.8rem;">PNG, JPG, JPEG</p>
                    <input type="file" id="qrImage" accept="image/*" style="display: none;">
                </div>

                <div style="margin: 20px 0;">
                    <div style="display: flex; gap: 10px;">
                        <input type="text" id="qrCodeInput" placeholder="Ou entrez le code QR manuellement" 
                               style="flex: 1; padding: 15px; background: rgba(255,255,255,0.05); border: 2px solid rgba(255,255,255,0.1); border-radius: 12px; color: #fff; font-size: 1rem;">
                        <button onclick="searchByCode()" style="background: var(--accent-gold); color: #0a0e1a; border: none; border-radius: 12px; padding: 0 25px; cursor: pointer; font-weight: 600;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>

                <div class="loading" id="loading">
                    <div class="spinner"></div>
                    <p style="margin-top: 10px;">Traitement en cours...</p>
                </div>

                <div id="result" style="display: none;">
                    <div class="result-card">
                        <div id="result-content"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Version simplifiée - juste entrer le code manuellement
    document.getElementById('qrImage').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        const loading = document.getElementById('loading');
        loading.style.display = 'block';
        
        // Solution simple: extraire le nom du fichier comme code
        // Ou demander à l'utilisateur d'entrer le code manuellement
        setTimeout(() => {
            loading.style.display = 'none';
            alert("Pour scanner une image, veuillez utiliser l'application mobile ou entrer le code manuellement.\n\nCode suggéré: " + file.name.split('.')[0]);
        }, 500);
    });
    
    function searchByCode() {
        const code = document.getElementById('qrCodeInput').value.trim();
        if (code === '') {
            alert("Veuillez entrer un code QR");
            return;
        }
        
        const loading = document.getElementById('loading');
        loading.style.display = 'block';
        
        document.getElementById('result').style.display = 'none';
        
        fetch('/api/piece-by-qr/' + encodeURIComponent(code))
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                
                if (data.success) {
                    document.getElementById('result').style.display = 'block';
                    document.getElementById('result-content').innerHTML = `
                        <h3><i class="bi bi-check-circle-fill" style="color: #28a745;"></i> Pièce trouvée</h3>
                        <div class="piece-info">
                            <p><strong>Référence:</strong> ${data.piece.reference}</p>
                            <p><strong>Description:</strong> ${data.piece.description}</p>
                            <p><strong>Catégorie:</strong> ${data.piece.categorie}</p>
                            <p><strong>Statut:</strong> ${data.piece.statut}</p>
                            <p><strong>Emplacement:</strong> ${data.piece.emplacement || 'Non assigné'}</p>
                            <a href="/pieces/${data.piece.id}" class="btn-gold" style="display: inline-block; margin-top: 15px;">
                                Voir les détails complets
                            </a>
                        </div>
                    `;
                } else {
                    document.getElementById('result').style.display = 'block';
                    document.getElementById('result-content').innerHTML = `
                        <h3><i class="bi bi-exclamation-triangle-fill" style="color: #dc3545;"></i> Pièce non trouvée</h3>
                        <div class="piece-info">
                            <p>Code scanné: <strong>${code}</strong></p>
                            <p>Aucune pièce trouvée avec ce code QR.</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                document.getElementById('result').style.display = 'block';
                document.getElementById('result-content').innerHTML = `
                    <h3><i class="bi bi-exclamation-triangle-fill" style="color: #dc3545;"></i> Erreur</h3>
                    <div class="piece-info">
                        <p>Erreur de connexion au serveur.</p>
                    </div>
                `;
            });
    }
    
    // Search on Enter key
    document.getElementById('qrCodeInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchByCode();
        }
    });
</script>
@endsection