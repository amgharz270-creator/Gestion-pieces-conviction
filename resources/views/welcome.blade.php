@extends('layouts.guest')

@section('title', 'Accueil - TPI Sidi Bennour')

@push('styles')
<style>
    /* ===== HERO AVEC IMAGE DE FOND ===== */
   /* ===== HERO AVEC IMAGE DE FOND ===== */
.hero-full {
    position: relative;
    min-height: 100vh;
    background-image: url('{{ asset("images/tribunal-bg.jpg") }}');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    flex-direction: column;
}

/* Overlay plus subtil pour voir l'image */
.hero-full::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(
        180deg, 
        rgba(5, 10, 25, 0.85) 0%, 
        rgba(15, 30, 60, 0.80) 30%,
        rgba(15, 30, 60, 0.75) 60%,
        rgba(5, 10, 25, 0.90) 100%
    );
    z-index: 1;
}

/* Contenu par-dessus */
.hero-content-top {
    position: relative;
    z-index: 2;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 140px 40px 80px;
    color: #fff;
}

/* Badge en haut */
.hero-content-top .badge-top {
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
    margin-bottom: 35px;
    backdrop-filter: blur(10px);
}

/* TITRE PRINCIPAL - Plus professionnel */
.hero-content-top h1 {
    font-size: 4.5rem;
    font-weight: 900;
    margin-bottom: 15px;
    line-height: 1.1;
    text-shadow: 0 4px 30px rgba(0,0,0,0.5);
    letter-spacing: -1px;
}

/* "à Conviction" en doré avec effet */
.hero-content-top h1 span {
    color: #c9a227;
    display: block;
    font-size: 4rem;
    font-weight: 800;
    margin-top: 5px;
    text-shadow: 0 2px 20px rgba(201, 162, 39, 0.3);
}

/* Sous-titre institutionnel */
.hero-content-top .subtitle-institution {
    font-size: 1.3rem;
    font-weight: 500;
    color: rgba(255,255,255,0.9);
    margin-bottom: 8px;
    letter-spacing: 1px;
}

.hero-content-top .subtitle-ministere {
    font-size: 1rem;
    font-weight: 400;
    color: rgba(255,255,255,0.6);
    margin-bottom: 50px;
    letter-spacing: 0.5px;
}

/* BOUTONS - Style professionnel */
.hero-buttons {
    display: flex;
    gap: 25px;
    justify-content: center;
    flex-wrap: wrap;
}

/* Bouton principal doré */
.btn-gold-solid {
    background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%);
    color: #0a0e1a;
    padding: 18px 45px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 12px;
    border: none;
    box-shadow: 0 10px 40px rgba(201, 162, 39, 0.25);
    letter-spacing: 0.5px;
}

.btn-gold-solid:hover {
    background: linear-gradient(135deg, #e8d5a3 0%, #c9a227 100%);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 20px 50px rgba(201, 162, 39, 0.4);
    color: #0a0e1a;
}

.btn-gold-solid i {
    font-size: 1.1rem;
}

/* Bouton outline blanc */
.btn-gold-outline {
    background: rgba(255,255,255,0.05);
    color: #fff;
    padding: 18px 45px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 12px;
    border: 2px solid rgba(255,255,255,0.25);
    backdrop-filter: blur(10px);
    letter-spacing: 0.5px;
}

.btn-gold-outline:hover {
    background: rgba(255,255,255,0.95);
    color: #0a0e1a;
    border-color: #fff;
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 20px 50px rgba(255,255,255,0.15);
}

.btn-gold-outline i {
    font-size: 1.1rem;
}

/* ===== SECTIONS PAR-DESSUS ===== */
.content-overlay {
    position: relative;
    z-index: 2;
    background: rgba(10, 20, 40, 0.60);
    backdrop-filter: blur(8px);
}

/* Stats */
.stats-overlay {
    padding: 70px 0;
    border-top: 1px solid rgba(255,255,255,0.08);
    border-bottom: 1px solid rgba(255,255,255,0.08);
}

.stat-box-white {
    text-align: center;
    padding: 30px 20px;
    border-right: 1px solid rgba(255,255,255,0.08);
}

.stat-box-white:last-child {
    border-right: none;
}

.stat-box-white .number {
    font-size: 3rem;
    font-weight: 900;
    color: #c9a227;
    display: block;
    line-height: 1;
    text-shadow: 0 2px 10px rgba(201, 162, 39, 0.2);
}

.stat-box-white .label {
    color: rgba(255,255,255,0.6);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-top: 12px;
}

/* Features */
.features-overlay {
    padding: 100px 0;
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
    max-width: 600px;
    margin: 0 auto;
    font-size: 1.1rem;
}

.section-header-white .line {
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #c9a227, #e8d5a3);
    margin: 25px auto 0;
    border-radius: 2px;
}

.feature-card-dark {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 20px;
    padding: 45px 35px;
    text-align: center;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    height: 100%;
    backdrop-filter: blur(10px);
}

.feature-card-dark:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(201, 162, 39, 0.3);
    transform: translateY(-12px);
    box-shadow: 0 30px 60px rgba(0,0,0,0.4);
}

.feature-icon-dark {
    width: 75px;
    height: 75px;
    background: linear-gradient(135deg, rgba(30, 58, 95, 0.6) 0%, rgba(21, 41, 66, 0.6) 100%);
    border: 2px solid rgba(201, 162, 39, 0.4);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 30px;
    font-size: 32px;
    color: #c9a227;
    transition: all 0.3s;
}

.feature-card-dark:hover .feature-icon-dark {
    background: linear-gradient(135deg, rgba(201, 162, 39, 0.2) 0%, rgba(201, 162, 39, 0.1) 100%);
    border-color: #c9a227;
    transform: scale(1.1);
}

.feature-card-dark h4 {
    font-weight: 700;
    color: #fff;
    margin-bottom: 18px;
    font-size: 1.3rem;
}

.feature-card-dark p {
    color: rgba(255,255,255,0.6);
    line-height: 1.8;
    font-size: 0.95rem;
}

/* CTA */
.cta-overlay {
    padding: 120px 0;
    text-align: center;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.cta-overlay h2 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 20px;
    color: #fff;
    letter-spacing: -0.5px;
}

.cta-overlay p {
    font-size: 1.2rem;
    color: rgba(255,255,255,0.6);
    margin-bottom: 50px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.btn-white-solid {
    background: #fff;
    color: #0a0e1a;
    padding: 18px 50px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1.05rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 40px rgba(255,255,255,0.1);
    border: none;
    letter-spacing: 0.5px;
}

.btn-white-solid:hover {
    background: #c9a227;
    color: #0a0e1a;
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 20px 50px rgba(201, 162, 39, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-content-top {
        padding: 100px 25px 50px;
    }
    
    .hero-content-top h1 {
        font-size: 2.8rem;
    }
    
    .hero-content-top h1 span {
        font-size: 2.5rem;
    }
    
    .hero-content-top .subtitle-institution {
        font-size: 1.1rem;
    }
    
    .btn-gold-solid,
    .btn-gold-outline {
        padding: 15px 30px;
        font-size: 0.95rem;
    }
    
    .stat-box-white {
        border-right: none;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    
    .stat-box-white:last-child {
        border-bottom: none;
    }
    
    .cta-overlay h2 {
        font-size: 2.2rem;
    }
}
</style>
@endpush

@section('content')

{{-- Page complète avec image de fond --}}
<section class="hero-full">
    
    {{-- Partie haute : Titre et boutons --}}
 <div class="hero-content-top">
    <div>
        <div class="badge-top">
            <i class="bi bi-shield-lock-fill"></i>
            Système Sécurisé de Gestion Judiciaire
        </div>
        
        <h1>
            Gestion des Pièces
            <span>à Conviction</span>
        </h1>
        
        <div class="subtitle-institution">
            Tribunal de Première Instance de Sidi Bennour
        </div>
        <div class="subtitle-ministere">
            Ministère de la Justice du Royaume du Maroc
        </div>
        
        <div class="hero-buttons">
            <a href="{{ route('login') }}" class="btn-gold-solid">
                <i class="bi bi-box-arrow-in-right"></i>
                Accéder au Système
            </a>
            <a href="{{ route('about') }}" class="btn-gold-outline">
                <i class="bi bi-info-circle"></i>
                En Savoir Plus
            </a>
        </div>
    </div>
</div>
    
    {{-- Contenu par-dessus l'image (avec fond transparent) --}}
    <div class="content-overlay">
        
        {{-- Stats --}}
        <div class="stats-overlay">
            <div class="container">
                <div class="row g-0">
                    <div class="col-6 col-lg-3">
                        <div class="stat-box-white">
                            <span class="number">{{ $piecesCount ?? 0 }}+</span> 
                            <div class="label">Pièces Gérées</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="stat-box-white">
                            <span class="number">{{ $dossiersCount ?? 0 }}</span>
                            <div class="label">Dossiers Actifs</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="stat-box-white">
                            <span class="number">{{ $restitutionsCount ?? 0 }}</span>
                            <div class="label">Restitutions</div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="stat-box-white">
                            <span class="number">{{ $securityRate ?? '99%' }}</span>
                            <div class="label">Sécurité</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Features --}}
        <div class="features-overlay">
            <div class="container">
                <div class="section-header-white text-center mb-5">
                    <h2>Nos Services</h2>
                    <p>Un système complet pour la gestion des pièces à conviction</p>
                    <div class="line"></div>
                </div>
                
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card-dark">
                            <div class="feature-icon-dark">
                                <i class="bi bi-box-seam"></i>
                            </div>
                            <h4>Gestion des Pièces</h4>
                            <p>Enregistrement, suivi et localisation avec QR code unique pour chaque pièce.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card-dark">
                            <div class="feature-icon-dark">
                                <i class="bi bi-folder"></i>
                            </div>
                            <h4>Dossiers Judiciaires</h4>
                            <p>Gestion complète des affaires liées aux pièces saisies dans les procédures.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card-dark">
                            <div class="feature-icon-dark">
                                <i class="bi bi-arrow-return-left"></i>
                            </div>
                            <h4>Restitutions</h4>
                            <p>Workflow de demande et approbation conforme aux décisions judiciaires.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card-dark">
                            <div class="feature-icon-dark">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <h4>Inventaires</h4>
                            <p>Contrôles physiques réguliers avec génération automatique de rapports.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card-dark">
                            <div class="feature-icon-dark">
                                <i class="bi bi-qr-code"></i>
                            </div>
                            <h4>QR Codes</h4>
                            <p>Identification unique par QR code pour un suivi rapide et précis.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card-dark">
                            <div class="feature-icon-dark">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h4>Sécurité</h4>
                            <p>Authentification sécurisée avec gestion des rôles et permissions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- CTA --}}
        <div class="cta-overlay">
            <div class="container">
                <h2>Prêt à Digitaliser la Gestion ?</h2>
                <p>Accédez au système de gestion des pièces à conviction dès maintenant</p>
                <a href="{{ route('login') }}" class="btn-white-solid">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Connexion au Système
                </a>
            </div>
        </div>
        
    </div>
    
</section>

@endsection