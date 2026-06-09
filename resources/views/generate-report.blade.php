@extends('layouts.admin')

@section('title', 'Générer Rapport - TPI Sidi Bennour')

@push('styles')
<style>
    .report-form {
        max-width: 600px;
        margin: 0 auto;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 20px;
        padding: 30px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        color: var(--text-light);
        font-weight: 600;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        width: 100%;
        padding: 12px 15px;
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        color: #fff;
    }
    .form-control:focus, .form-select:focus {
        outline: none;
        border-color: var(--accent-gold);
    }
    .btn-gold {
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%);
        color: #0a0e1a;
        padding: 14px 30px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        width: 100%;
    }
    .btn-outline {
        background: transparent;
        border: 2px solid var(--accent-gold);
        color: var(--accent-gold);
        padding: 14px 30px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        width: 100%;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="admin-wrapper">
    <aside class="admin-sidebar">@include('partials.admin-sidebar')</aside>
    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}">Accueil</a> / Générer Rapport
            </div>
        </div>

        <div style="padding: 30px;">
            <div class="report-form">
                <h2 style="color: var(--accent-gold); margin-bottom: 25px; text-align: center;">
                    <i class="bi bi-file-earmark-text"></i> Générer un rapport
                </h2>

                <form action="{{ route('rapports.export-pdf') }}" method="GET" target="_blank">
                    <div class="form-group">
                        <label>Type de rapport</label>
                        <select name="type" class="form-select" required>
                            <option value="pieces">📦 Rapport des pièces</option>
                            <option value="dossiers">📁 Rapport des dossiers</option>
                            <option value="restitutions">🔄 Rapport des restitutions</option>
                            <option value="inventaires">📋 Rapport des inventaires</option>
                            <option value="mouvements">🚚 Rapport des mouvements</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Format</label>
                        <select name="format" class="form-select" required>
                            <option value="pdf">📄 PDF</option>
                            <option value="excel">📊 Excel</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Date début</label>
                        <input type="date" name="date_debut" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Date fin</label>
                        <input type="date" name="date_fin" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Statut (optionnel)</label>
                        <select name="statut" class="form-select">
                            <option value="">Tous</option>
                            <option value="saisie">Saisie</option>
                            <option value="depot">Dépôt</option>
                            <option value="restituee">Restituée</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-gold">
                        <i class="bi bi-download"></i> Générer et télécharger
                    </button>
                </form>

                <hr style="border-color: rgba(255,255,255,0.1); margin: 25px 0;">

                <form action="{{ route('rapports.export-excel') }}" method="GET">
                    <button type="submit" class="btn-outline">
                        <i class="bi bi-file-spreadsheet"></i> Rapport complet Excel
                    </button>
                </form>
            </div>
        </div>
    </main>
</div>
@endsection