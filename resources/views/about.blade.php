@extends('layouts.guest')

@section('title', 'À Propos - TPI Sidi Bennour')

@push('styles')
<style>
    /* ===== HERO AVEC IMAGE DE FOND ===== */
    .about-hero-pro {
        position: relative;
        min-height: 50vh;
        background-image: url('{{ asset("images/tribunal-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: #fff;
    }
    
    .about-hero-pro::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            135deg, 
            rgba(5, 10, 25, 0.92) 0%, 
            rgba(15, 30, 60, 0.88) 100%
        );
    }
    
    .about-hero-pro .content {
        position: relative;
        z-index: 2;
        padding: 140px 40px 80px;
    }
    
    .about-hero-pro .badge-top {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(201, 162, 39, 0.15);
        border: 1.5px solid rgba(201, 162, 39, 0.5);
        color: #c9a227;
        padding: 10px 28px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
    }
    
    .about-hero-pro h1 {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 15px;
        text-shadow: 0 4px 30px rgba(0,0,0,0.5);
        letter-spacing: -1px;
    }
    
    .about-hero-pro p {
        font-size: 1.2rem;
        color: rgba(255,255,255,0.7);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.7;
    }
    
    /* ===== CONTENT SUR FOND SOMBRE ===== */
    .about-dark-section {
        position: relative;
        background-image: url('{{ asset("images/tribunal-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #fff;
    }
    
    .about-dark-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 20, 40, 0.85);
    }
    
    .about-dark-section .container {
        position: relative;
        z-index: 2;
    }
    
    /* Cards sombres */
    .about-card-dark {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 50px 40px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }
    
    .about-card-dark:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(201, 162, 39, 0.3);
        transform: translateY(-10px);
        box-shadow: 0 30px 60px rgba(0,0,0,0.3);
    }
    
    .about-icon-dark {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(30, 58, 95, 0.6) 0%, rgba(21, 41, 66, 0.6) 100%);
        border: 2px solid rgba(201, 162, 39, 0.4);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        font-size: 28px;
        color: #c9a227;
        transition: all 0.3s;
    }
    
    .about-card-dark:hover .about-icon-dark {
        background: linear-gradient(135deg, rgba(201, 162, 39, 0.2) 0%, rgba(201, 162, 39, 0.1) 100%);
        border-color: #c9a227;
        transform: scale(1.1);
    }
    
    .about-card-dark h3 {
        font-weight: 700;
        color: #fff;
        margin-bottom: 20px;
        font-size: 1.4rem;
    }
    
    .about-card-dark p,
    .about-card-dark li {
        color: rgba(255,255,255,0.65);
        line-height: 1.8;
        font-size: 0.95rem;
    }
    
    .about-card-dark ul {
        padding-left: 20px;
        margin-top: 15px;
    }
    
    .about-card-dark li {
        margin-bottom: 12px;
        position: relative;
    }
    
    .about-card-dark li::marker {
        color: #c9a227;
    }
    
    /* ===== TIMELINE ===== */
    .timeline-dark-section {
        position: relative;
        background-image: url('{{ asset("images/tribunal-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 100px 0;
        color: #fff;
        border-top: 1px solid rgba(255,255,255,0.08);
    }
    
    .timeline-dark-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 20, 40, 0.90);
    }
    
    .timeline-dark-section .container {
        position: relative;
        z-index: 2;
    }
    
    .section-header-white {
        text-align: center;
        margin-bottom: 60px;
    }
    
    .section-header-white h2 {
        color: #fff;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }
    
    .section-header-white p {
        color: rgba(255,255,255,0.6);
        font-size: 1.1rem;
    }
    
    .section-header-white .line {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #c9a227, #e8d5a3);
        margin: 25px auto 0;
        border-radius: 2px;
    }
    
    /* Timeline items */
    .timeline-item-dark {
        display: flex;
        gap: 25px;
        margin-bottom: 50px;
        position: relative;
    }
    
    .timeline-item-dark::before {
        content: '';
        position: absolute;
        left: 28px;
        top: 70px;
        bottom: -50px;
        width: 2px;
        background: linear-gradient(180deg, rgba(201, 162, 39, 0.5), rgba(201, 162, 39, 0.1));
    }
    
    .timeline-item-dark:last-child::before {
        display: none;
    }
    
    .timeline-num-dark {
        width: 58px;
        height: 58px;
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%);
        color: #0a0e1a;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.3rem;
        flex-shrink: 0;
        position: relative;
        z-index: 2;
        box-shadow: 0 5px 20px rgba(201, 162, 39, 0.3);
    }
    
    .timeline-content-dark h4 {
        font-weight: 700;
        color: #fff;
        margin-bottom: 12px;
        font-size: 1.3rem;
    }
    
    .timeline-content-dark p {
        color: rgba(255,255,255,0.65);
        line-height: 1.8;
        font-size: 0.95rem;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .about-hero-pro h1 {
            font-size: 2.5rem;
        }
        
        .about-card-dark {
            padding: 35px 25px;
        }
        
        .timeline-item-dark::before {
            left: 24px;
        }
        
        .timeline-num-dark {
            width: 50px;
            height: 50px;
            font-size: 1.1rem;
        }
    }
</style>
@endpush

@section('content')

{{-- Hero avec image de fond --}}
<section class="about-hero-pro">
    <div class="content">
        <div class="badge-top">
            <i class="bi bi-shield-lock-fill"></i>
            Système de Gestion Judiciaire
        </div>
        
        <h1>À Propos de Notre Système</h1>
        <p>Découvrez la plateforme de gestion des pièces à conviction du Tribunal de Première Instance de Sidi Bennour</p>
    </div>
</section>

{{-- Content avec fond image --}}
<section class="about-dark-section">
    <div class="container py-5">
        <div class="row g-4 py-5">
            <div class="col-lg-6">
                <div class="about-card-dark">
                    <div class="about-icon-dark">
                        <i class="bi bi-bullseye"></i>
                    </div>
                    <h3>Notre Mission</h3>
                    <p>
                        Moderniser et sécuriser la gestion des biens saisis dans le cadre des procédures judiciaires 
                        pour assurer traçabilité, transparence et efficacité administrative.
                    </p>
                    <ul>
                        <li>Traçabilité complète des pièces</li>
                        <li>Sécurité renforcée des biens saisis</li>
                        <li>Transparence dans les procédures</li>
                        <li>Efficacité administrative optimale</li>
                    </ul>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="about-card-dark">
                    <div class="about-icon-dark">
                        <i class="bi bi-gear"></i>
                    </div>
                    <h3>Fonctionnalités Clés</h3>
                    <p>
                        Notre plateforme offre un ensemble complet d'outils pour la gestion efficace :
                    </p>
                    <ul>
                        <li>Enregistrement numérique des pièces</li>
                        <li>Génération de QR codes uniques</li>
                        <li>Suivi en temps réel des mouvements</li>
                        <li>Gestion des restitutions</li>
                        <li>Rapports et statistiques détaillés</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Timeline avec fond image --}}
<section class="timeline-dark-section">
    <div class="container">
        <div class="section-header-white">
            <h2>Processus de Gestion</h2>
            <p>Les étapes clés du cycle de vie d'une pièce à conviction</p>
            <div class="line"></div>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="timeline-item-dark">
                    <div class="timeline-num-dark">1</div>
                    <div class="timeline-content-dark">
                        <h4>Saisie</h4>
                        <p>Enregistrement de la pièce avec photos, description détaillée et génération automatique du QR code d'identification unique.</p>
                    </div>
                </div>
                
                <div class="timeline-item-dark">
                    <div class="timeline-num-dark">2</div>
                    <div class="timeline-content-dark">
                        <h4>Stockage</h4>
                        <p>Attribution d'un emplacement physique sécurisé dans les locaux du tribunal avec traçabilité complète et inventaire.</p>
                    </div>
                </div>
                
                <div class="timeline-item-dark">
                    <div class="timeline-num-dark">3</div>
                    <div class="timeline-content-dark">
                        <h4>Suivi</h4>
                        <p>Traçabilité complète des mouvements, changements de statut et historique des interventions en temps réel.</p>
                    </div>
                </div>
                
                <div class="timeline-item-dark">
                    <div class="timeline-num-dark">4</div>
                    <div class="timeline-content-dark">
                        <h4>Restitution</h4>
                        <p>Workflow de demande, approbation judiciaire et restitution conforme aux décisions de justice et aux procédures légales.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection