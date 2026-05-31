@extends('layouts.admin')

@section('title', 'Pièces à Conviction - TPI Sidi Bennour')

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
    .main-content { margin-left: 280px; flex: 1; background: linear-gradient(135deg, #0f1e3a 0%, #0a0e1a 100%); min-height: 100vh; padding: 30px; }
    .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
    .page-header h1 { color: var(--text-light); font-weight: 800; font-size: 1.8rem; }
    .btn-gold { background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); color: #0a0e1a; padding: 12px 25px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; border: none; }
    .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3); color: #0a0e1a; }
    .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 20px; padding: 30px; overflow-x: auto; }
    .table-dark-custom { width: 100%; border-collapse: separate; border-spacing: 0 8px; }
    .table-dark-custom thead th { color: var(--accent-gold); font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 1px; padding: 15px 20px; text-align: left; border-bottom: 2px solid rgba(201, 162, 39, 0.2); }
    .table-dark-custom tbody tr { background: rgba(255,255,255,0.03); transition: all 0.3s; }
    .table-dark-custom tbody tr:hover { background: rgba(255,255,255,0.06); }
    .table-dark-custom tbody td { padding: 18px 20px; color: var(--text-muted); font-size: 0.9rem; border-top: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05); }
    .table-dark-custom tbody td:first-child { border-radius: 12px 0 0 12px; border-left: 1px solid rgba(255,255,255,0.05); }
    .table-dark-custom tbody td:last-child { border-radius: 0 12px 12px 0; border-right: 1px solid rgba(255,255,255,0.05); }
    .status-badge { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
    .status-depot { background: rgba(23, 162, 184, 0.15); color: var(--info); }
    .status-saisie { background: rgba(201, 162, 39, 0.15); color: var(--accent-gold); }
    .status-restituee { background: rgba(40, 167, 69, 0.15); color: var(--success); }
    .status-expertise { background: rgba(255, 193, 7, 0.15); color: var(--warning); }
    .action-btns { display: flex; gap: 8px; }
    .btn-icon-sm { width: 35px; height: 35px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.05); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; text-decoration: none; }
    .btn-icon-sm:hover { background: rgba(201, 162, 39, 0.15); border-color: var(--accent-gold); color: var(--accent-gold); }
    .alert-success-custom { background: rgba(40, 167, 69, 0.15); border: 1px solid rgba(40, 167, 69, 0.3); color: #75b798; border-radius: 12px; padding: 15px 20px; margin-bottom: 25px; }
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
               <a href="{{ route('pieces.index') }}" class="menu-item active">
    <i class="bi bi-box-seam"></i>
    <span>Pièces</span>
</a>
                <a href="{{ route('dossiers.index') }}" class="menu-item"><i class="bi bi-folder"></i><span>Dossiers</span></a>
                <a href="{{ route('emplacements.index') }}" class="menu-item"><i class="bi bi-geo-alt"></i><span>Emplacements</span></a>
            </div>
        </nav>
    </aside>

    <main class="main-content">
        @if(session('success'))
        <div class="alert-success-custom"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
        @endif

        <div class="page-header">
            <div>
                <h1><i class="bi bi-box-seam" style="color: var(--accent-gold); margin-right: 12px;"></i>Pièces à Conviction</h1>
            </div>
            <a href="{{ route('pieces.create') }}" class="btn-gold"><i class="bi bi-plus-lg"></i>Nouvelle Pièce</a>
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
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pieces as $piece)
                    @php
                        $statusClass = 'status-depot';
                        if($piece->statut == 'saisie') $statusClass = 'status-saisie';
                        elseif($piece->statut == 'restituee') $statusClass = 'status-restituee';
                        elseif($piece->statut == 'expertise') $statusClass = 'status-expertise';
                    @endphp
                    <tr>
                        <td style="color: var(--text-light); font-weight: 600;">{{ $piece->reference }}</td>
                        <td>{{ ucfirst($piece->categorie) }}</td>
                        <td>{{ $piece->dossier->numero_dossier ?? 'N/A' }}</td>
                        <td>{{ $piece->emplacement->salle ?? 'N/A' }}</td>
                        <td><span class="status-badge {{ $statusClass }}">{{ ucfirst($piece->statut) }}</span></td>
                        <td>{{ $piece->date_saisie ? $piece->date_saisie->format('d/m/Y') : 'N/A' }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="{{ route('pieces.show', $piece) }}" class="btn-icon-sm" title="Voir"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('pieces.edit', $piece) }}" class="btn-icon-sm" title="Modifier"><i class="bi bi-pencil"></i></a>
                                <form action="{{ route('pieces.destroy', $piece) }}" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-icon-sm" title="Supprimer" style="border:none;"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" style="text-align: center; padding: 50px; color: var(--text-muted);"><i class="bi bi-inbox" style="font-size: 3rem; display: block; margin-bottom: 15px;"></i>Aucune pièce</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">{{ $pieces->links() }}</div>
        </div>
    </main>
</div>

@endsection