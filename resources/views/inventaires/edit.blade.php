@extends('layouts.admin')

@section('title', 'Constater Inventaire - TPI Sidi Bennour')

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
        --warning: #ffc107;
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
    .page-header a { color: var(--text-muted); text-decoration: none; font-size: 0.9rem; }
    .page-header a:hover { color: var(--accent-gold); }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; margin-top: 15px; }
    .progress-bar-container { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 20px; margin-bottom: 25px; }
    .progress { background: rgba(255,255,255,0.1); height: 8px; border-radius: 4px; }
    .progress-bar { background: var(--accent-gold); height: 8px; border-radius: 4px; transition: width 0.3s; }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 15px 20px; color: var(--text-muted); font-size: 0.85rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); }
    .btn-outline { background: transparent; color: var(--text-muted); border: 2px solid rgba(255,255,255,0.2); padding: 12px 25px; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
    .btn-outline:hover { border-color: var(--accent-gold); color: var(--accent-gold); }
    .statut-select { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); border-radius: 8px; padding: 6px 10px; color: #fff; font-size: 0.8rem; cursor: pointer; }
    .statut-select:hover { border-color: var(--accent-gold); }
    .statut-presente { background: rgba(40, 167, 69, 0.2); color: var(--success); }
    .statut-manquante { background: rgba(220, 53, 69, 0.2); color: var(--danger); }
    .statut-endommagee { background: rgba(255, 193, 7, 0.2); color: var(--warning); }
    .statut-deplacee { background: rgba(23, 162, 184, 0.2); color: var(--info); }
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
                <a href="{{ route('emplacements.index') }}" class="menu-item"><i class="bi bi-geo-alt"></i><span>Emplacements</span></a>
            </div>
            <div class="menu-section">
                <div class="menu-section-title">Gestion</div>
                <a href="{{ route('restitutions.index') }}" class="menu-item"><i class="bi bi-arrow-return-left"></i><span>Restitutions</span></a>
                <a href="{{ route('mouvements.index') }}" class="menu-item"><i class="bi bi-arrow-left-right"></i><span>Mouvements</span></a>
                <a href="{{ route('inventaires.index') }}" class="menu-item active"><i class="bi bi-clipboard-check"></i><span>Inventaires</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}"><i class="bi bi-house-door"></i> Accueil</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <a href="{{ route('inventaires.index') }}">Inventaires</a>
                <i class="bi bi-chevron-right" style="margin: 0 8px;"></i>
                <span>{{ $inventaire->reference }} - Constatation</span>
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
                <a href="{{ route('inventaires.index') }}"><i class="bi bi-arrow-left"></i> Retour</a>
                <h1><i class="bi bi-clipboard-check" style="color: var(--accent-gold); margin-right: 12px;"></i>{{ $inventaire->reference }} - Constatation</h1>
            </div>
            <div>
                <form action="{{ route('inventaires.terminer', $inventaire) }}" method="POST" id="terminerForm">
                    @csrf @method('PATCH')
                    <button type="button" class="btn-gold" onclick="terminerInventaire()">
                        <i class="bi bi-check-lg"></i> Terminer l'inventaire
                    </button>
                </form>
            </div>
        </div>

        <!-- Progression -->
        <div class="progress-bar-container">
            @php
                $total = $inventaire->lignes->count();
                $constatees = $inventaire->lignes->where('statut', '!=', 'presente')->count();
                $pourcentage = $total > 0 ? round(($constatees / $total) * 100) : 0;
            @endphp
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-check-circle" style="color: var(--success);"></i> Constatées: {{ $constatees }}/{{ $total }}</span>
                <span>{{ $pourcentage }}%</span>
            </div>
            <div class="progress">
                <div class="progress-bar" style="width: {{ $pourcentage }}%;"></div>
            </div>
            <small class="text-muted mt-2 d-block" style="color: var(--text-muted);">
                <i class="bi bi-info-circle"></i> Cliquez sur le statut d'une ligne pour le modifier
            </small>
        </div>

        <!-- Liste des pièces avec sélection de statut -->
        <div class="table-card">
            <form id="updateLignesForm" method="POST" action="">
                @csrf
                @method('PATCH')
                <table class="table-dark-custom">
                    <thead>
                        <tr>
                            <th>Référence</th>
                            <th>Description</th>
                            <th>Emplacement système</th>
                            <th>Nouvel emplacement</th>
                            <th>Statut</th>
                            <th>Observations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventaire->lignes as $ligne)
                        <tr id="ligne-{{ $ligne->id }}">
                            <td style="color: var(--text-light); font-weight: 600;">{{ $ligne->piece->reference ?? 'N/A' }}</td>
                            <td>{{ Str::limit($ligne->piece->description ?? 'N/A', 40) }}</td>
                            <td>{{ $ligne->piece->emplacement->salle ?? 'N/A' }}<br><small>{{ $ligne->piece->emplacement->armoire ?? '' }}</small></td>
                            <td>
                                <select name="emplacement_constate_id" class="form-select-dark" style="padding: 6px 10px; font-size: 0.8rem;" onchange="updateLigne({{ $ligne->id }}, 'emplacement', this.value)">
                                    <option value="">Non constaté</option>
                                    @foreach($emplacements ?? [] as $emplacement)
                                    <option value="{{ $emplacement->id }}" {{ $ligne->emplacement_constate_id == $emplacement->id ? 'selected' : '' }}>
                                        {{ $emplacement->salle }} - {{ $emplacement->armoire }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="statut-select" onchange="updateLigne({{ $ligne->id }}, 'statut', this.value)">
                                    <option value="presente" {{ $ligne->statut == 'presente' ? 'selected' : '' }} class="statut-presente">✓ Présente</option>
                                    <option value="manquante" {{ $ligne->statut == 'manquante' ? 'selected' : '' }} class="statut-manquante">✗ Manquante</option>
                                    <option value="endommagee" {{ $ligne->statut == 'endommagee' ? 'selected' : '' }} class="statut-endommagee">⚠ Endommagée</option>
                                    <option value="deplacee" {{ $ligne->statut == 'deplacee' ? 'selected' : '' }} class="statut-deplacee">🔄 Déplacée</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control-dark" style="padding: 6px 10px; font-size: 0.8rem;" placeholder="Observations..." 
                                       value="{{ $ligne->observations }}" onblur="updateLigne({{ $ligne->id }}, 'observations', this.value)">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </main>
</div>

<script>
function updateLigne(ligneId, field, value) {
    let url = "{{ route('inventaires.updateLigne', ':id') }}".replace(':id', ligneId);
    let data = {};
    
    if (field === 'statut') {
        data.statut = value;
    } else if (field === 'emplacement') {
        data.emplacement_constate_id = value;
    } else if (field === 'observations') {
        data.observations = value;
    }
    
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Afficher une petite notification
            showToast('✅ Ligne mise à jour');
            // Recharger la page pour mettre à jour la progression
            location.reload();
        } else {
            showToast('❌ Erreur: ' + data.error);
        }
    })
    .catch(error => {
        showToast('❌ Erreur de connexion');
    });
}

function terminerInventaire() {
    if (confirm('Êtes-vous sûr de vouloir terminer cet inventaire ? Cette action est irréversible.')) {
        document.getElementById('terminerForm').submit();
    }
}

function showToast(message) {
    // Créer un toast simple
    let toast = document.createElement('div');
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.background = '#1e3a5f';
    toast.style.color = '#fff';
    toast.style.padding = '12px 24px';
    toast.style.borderRadius = '12px';
    toast.style.border = '1px solid #c9a227';
    toast.style.zIndex = '9999';
    toast.innerText = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 2000);
}
</script>
@endsection