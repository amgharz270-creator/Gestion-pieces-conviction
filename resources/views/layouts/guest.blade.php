<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TPI Sidi Bennour')</title>
    
    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    {{-- Google Fonts - Poppins (plus professionnel) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #1e3a5f;
            --primary-dark: #152942;
            --secondary: #c9a227;
            --secondary-light: #e8d5a3;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --white: #ffffff;
            --border: #e9ecef;
        }
        
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            background: var(--bg-light);
            line-height: 1.6;
        }
        
        /* ===== NAVBAR PROFESSIONNELLE ===== */
        .navbar-pro {
            background: var(--white);
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 3px solid var(--secondary);
        }
        
        .navbar-pro .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 80px;
        }
        
        .navbar-brand-pro {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }
        
        .navbar-brand-pro .logo-icon {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 24px;
        }
        
        .navbar-brand-pro .logo-text {
            display: flex;
            flex-direction: column;
        }
        
        .navbar-brand-pro .logo-text .title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            line-height: 1.2;
        }
        
        .navbar-brand-pro .logo-text .subtitle {
            font-size: 0.75rem;
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 5px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-menu .nav-link {
            color: var(--text-dark);
            text-decoration: none;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 6px;
            transition: all 0.3s;
            position: relative;
        }
        
        .nav-menu .nav-link:hover,
        .nav-menu .nav-link.active {
            color: var(--primary);
            background: rgba(30, 58, 95, 0.05);
        }
        
        .nav-menu .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 20px;
            right: 20px;
            height: 2px;
            background: var(--secondary);
        }
        
        .btn-login {
            background: var(--primary);
            color: var(--white) !important;
            padding: 10px 25px !important;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(30, 58, 95, 0.3);
        }
        
        /* ===== MAIN SPACER ===== */
        main {
            margin-top: 80px;
            min-height: calc(100vh - 380px);
        }
        
        /* ===== FOOTER PROFESSIONNEL ===== */
        .footer-pro {
            background: var(--primary-dark);
            color: rgba(255,255,255,0.7);
            padding: 60px 0 0;
            font-size: 0.9rem;
        }
        
        .footer-pro h5 {
            color: var(--white);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--secondary);
            display: inline-block;
        }
        
        .footer-pro p {
            line-height: 1.8;
            margin-bottom: 15px;
        }
        
        .footer-pro a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            display: block;
            padding: 8px 0;
            transition: all 0.3s;
        }
        
        .footer-pro a:hover {
            color: var(--secondary);
            padding-left: 10px;
        }
        
        .footer-pro a i {
            margin-right: 10px;
            color: var(--secondary);
            font-size: 0.8rem;
        }
        
        .footer-contact-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .footer-contact-item i {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--secondary);
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        
        .footer-contact-item div strong {
            color: var(--white);
            font-weight: 600;
            display: block;
            margin-bottom: 3px;
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 50px;
            padding: 25px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .footer-bottom p {
            margin: 0;
            font-size: 0.85rem;
        }
        
        .footer-bottom .social-links {
            display: flex;
            gap: 10px;
        }
        
        .footer-bottom .social-links a {
            width: 36px;
            height: 36px;
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-size: 0.9rem;
            padding: 0;
            transition: all 0.3s;
        }
        
        .footer-bottom .social-links a:hover {
            background: var(--secondary);
            color: var(--primary-dark);
            padding-left: 0;
        }
        
        /* ===== UTILITAIRES ===== */
        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-header h2 {
            font-weight: 700;
            color: var(--primary);
            font-size: 2.2rem;
            margin-bottom: 15px;
        }
        
        .section-header p {
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .section-header .line {
            width: 60px;
            height: 3px;
            background: var(--secondary);
            margin: 20px auto 0;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .nav-menu {
                display: none;
            }
            
            .navbar-pro .container {
                height: 70px;
            }
            
            main {
                margin-top: 70px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar-pro">
        <div class="container">
          <a href="{{ route('welcome') }}" class="navbar-brand-pro">
    <img src="{{ asset('images/logo-maroc.png') }}" 
         alt="Royaume du Maroc" 
         style="width: 50px; height: 50px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
    <div class="logo-text">
        <span class="title">TPI Sidi Bennour</span>
        <span class="subtitle">Ministère de la Justice</span>
    </div>
</a>
            
            <ul class="nav-menu d-none d-lg-flex">
                <li><a href="{{ route('welcome') }}" class="nav-link {{ request()->routeIs('welcome') ? 'active' : '' }}">Accueil</a></li>
                <li><a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">À Propos</a></li>
                <li><a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                <li><a href="{{ route('login') }}" class="nav-link btn-login">Connexion</a></li>
            </ul>
            
            <button class="navbar-toggler d-lg-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                <i class="bi bi-list fs-2" style="color: var(--primary);"></i>
            </button>
        </div>
        
        {{-- Mobile Menu --}}
        <div class="collapse d-lg-none" id="mobileNav">
            <div class="bg-white p-3 border-top">
                <a href="{{ route('welcome') }}" class="d-block p-2 text-decoration-none text-dark">Accueil</a>
                <a href="{{ route('about') }}" class="d-block p-2 text-decoration-none text-dark">À Propos</a>
                <a href="{{ route('contact') }}" class="d-block p-2 text-decoration-none text-dark">Contact</a>
                <a href="{{ route('login') }}" class="d-block p-2 text-decoration-none text-dark fw-bold">Connexion</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer-pro">
        <div class="container">
            <div class="row g-4">
                {{-- Col 1: About --}}
                <div class="col-lg-4 col-md-6">
                    <h5>À Propos</h5>
                    <p>
                        Le Tribunal de Première Instance de Sidi Bennour assure la gestion 
                        numérique des pièces à conviction pour une justice moderne et transparente.
                    </p>
                </div>
                
                {{-- Col 2: Liens --}}
                <div class="col-lg-2 col-md-6">
                    <h5>Navigation</h5>
                    <a href="{{ route('welcome') }}"><i class="bi bi-chevron-right"></i>Accueil</a>
                    <a href="{{ route('about') }}"><i class="bi bi-chevron-right"></i>À Propos</a>
                    <a href="{{ route('contact') }}"><i class="bi bi-chevron-right"></i>Contact</a>
                    <a href="{{ route('login') }}"><i class="bi bi-chevron-right"></i>Connexion</a>
                </div>
                
                {{-- Col 3: Services --}}
                <div class="col-lg-3 col-md-6">
                    <h5>Nos Services</h5>
                    <a href="#"><i class="bi bi-chevron-right"></i>Gestion des Pièces</a>
                    <a href="#"><i class="bi bi-chevron-right"></i>Restitutions</a>
                    <a href="#"><i class="bi bi-chevron-right"></i>Inventaires</a>
                    <a href="#"><i class="bi bi-chevron-right"></i>Rapports</a>
                </div>
                
                {{-- Col 4: Contact --}}
                <div class="col-lg-3 col-md-6">
                    <h5>Contact</h5>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            <strong>Adresse</strong>
                            <span>Sidi Bennour, Maroc</span>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <strong>Téléphone</strong>
                            <span>+212 705877129</span>
                        </div>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <strong>Email</strong>
                            <span>contact@tpi-sidibennour.ma</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© 2026 Tribunal de Première Instance de Sidi Bennour. Tous droits réservés.</p>
                <div class="social-links">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-twitter"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>