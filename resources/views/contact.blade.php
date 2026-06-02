@extends('layouts.guest')

@section('title', 'Contact - TPI Sidi Bennour')

@push('styles')
<style>
    /* ===== HERO AVEC IMAGE DE FOND ===== */
    .contact-hero-pro {
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

    .contact-hero-pro::before {
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

    .contact-hero-pro .content {
        position: relative;
        z-index: 2;
        padding: 140px 40px 80px;
    }

    .contact-hero-pro .badge-top {
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

    .contact-hero-pro h1 {
        font-size: 3.5rem;
        font-weight: 900;
        margin-bottom: 15px;
        text-shadow: 0 4px 30px rgba(0,0,0,0.5);
        letter-spacing: -1px;
    }

    .contact-hero-pro p {
        font-size: 1.2rem;
        color: rgba(255,255,255,0.7);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* ===== SECTION CONTACT SOMBRE ===== */
    .contact-dark-section {
        position: relative;
        background-image: url('{{ asset("images/tribunal-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 80px 0;
    }

    .contact-dark-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 20, 40, 0.85);
    }

    .contact-dark-section .container {
        position: relative;
        z-index: 2;
    }

    /* Cards sombres */
    .contact-info-dark {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 45px 35px;
        height: 100%;
        backdrop-filter: blur(10px);
        transition: all 0.4s;
    }

    .contact-info-dark:hover {
        background: rgba(255,255,255,0.08);
        border-color: rgba(201, 162, 39, 0.3);
        transform: translateY(-5px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
    }

    .contact-info-dark h3 {
        font-weight: 700;
        color: #fff;
        margin-bottom: 35px;
        font-size: 1.3rem;
        padding-bottom: 15px;
        border-bottom: 2px solid #c9a227;
        display: inline-block;
    }

    .info-row-dark {
        display: flex;
        gap: 18px;
        margin-bottom: 28px;
        align-items: flex-start;
    }

    .info-row-dark i {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, rgba(30, 58, 95, 0.6) 0%, rgba(21, 41, 66, 0.6) 100%);
        border: 2px solid rgba(201, 162, 39, 0.3);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #c9a227;
        font-size: 1.2rem;
        flex-shrink: 0;
        transition: all 0.3s;
    }

    .info-row-dark:hover i {
        background: linear-gradient(135deg, rgba(201, 162, 39, 0.2) 0%, rgba(201, 162, 39, 0.1) 100%);
        border-color: #c9a227;
        transform: scale(1.1);
    }

    .info-row-dark div strong {
        color: #fff;
        font-weight: 600;
        display: block;
        margin-bottom: 6px;
        font-size: 1rem;
    }

    .info-row-dark div span {
        color: rgba(255,255,255,0.6);
        font-size: 0.9rem;
        line-height: 1.6;
    }

    /* Formulaire sombre */
    .contact-form-dark {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px;
        padding: 45px 35px;
        backdrop-filter: blur(10px);
        transition: all 0.4s;
    }

    .contact-form-dark:hover {
        background: rgba(255,255,255,0.07);
        border-color: rgba(201, 162, 39, 0.2);
    }

    .contact-form-dark h3 {
        font-weight: 700;
        color: #fff;
        margin-bottom: 35px;
        font-size: 1.3rem;
        padding-bottom: 15px;
        border-bottom: 2px solid #c9a227;
        display: inline-block;
    }

    .form-control-dark {
        background: rgba(255,255,255,0.05);
        border: 2px solid rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 16px 20px;
        font-size: 0.95rem;
        color: #fff;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }

    .form-control-dark::placeholder {
        color: rgba(255,255,255,0.4);
    }

    .form-control-dark:focus {
        background: rgba(255,255,255,0.08);
        border-color: #c9a227;
        box-shadow: 0 0 0 0.2rem rgba(201, 162, 39, 0.15);
        color: #fff;
    }

    .form-label-dark {
        font-weight: 600;
        color: rgba(255,255,255,0.8);
        margin-bottom: 10px;
        font-size: 0.9rem;
    }

    .btn-submit-dark {
        background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%);
        color: #0a0e1a;
        padding: 16px 40px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        width: 100%;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Poppins', sans-serif;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 30px rgba(201, 162, 39, 0.2);
    }

    .btn-submit-dark:hover {
        background: linear-gradient(135deg, #e8d5a3 0%, #c9a227 100%);
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(201, 162, 39, 0.35);
    }

    /* Alert sur fond sombre */
    .alert-success-custom {
        background: rgba(25, 135, 84, 0.2);
        border: 1px solid rgba(25, 135, 84, 0.3);
        color: #75b798;
        border-radius: 12px;
    }

    /* ===== MAP SECTION ===== */
    .map-dark-section {
        position: relative;
        background-image: url('{{ asset("images/tribunal-bg.jpg") }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        padding: 80px 0;
        border-top: 1px solid rgba(255,255,255,0.08);
    }

    .map-dark-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(10, 20, 40, 0.88);
    }

    .map-dark-section .container {
        position: relative;
        z-index: 2;
    }

    .section-header-white {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-header-white h3 {
        color: #fff;
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 12px;
    }

    .section-header-white p {
        color: rgba(255,255,255,0.6);
        font-size: 1.1rem;
    }

    .section-header-white .line {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #c9a227, #e8d5a3);
        margin: 20px auto 0;
        border-radius: 2px;
    }

    /* CORRECTION: Dimensions fixes obligatoires pour Leaflet */
    #leaflet-map {
        width: 100%;
        height: 450px;
        min-height: 450px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
        background: #1e3a5f;
    }

    /* S'assurer que le conteneur Leaflet prend toute la place */
    #leaflet-map .leaflet-container {
        width: 100% !important;
        height: 100% !important;
        border-radius: 20px;
    }

    .btn-itineraire-dark {
        background: transparent;
        color: #c9a227;
        border: 2px solid #c9a227;
        padding: 14px 35px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.4s;
        margin-top: 10px;
    }

    .btn-itineraire-dark:hover {
        background: #c9a227;
        color: #0a0e1a;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(201, 162, 39, 0.3);
    }

    /* Leaflet popup style */
    .leaflet-popup-content-wrapper {
        border-radius: 16px;
        padding: 0;
        background: rgba(21, 41, 66, 0.95);
        border: 1px solid rgba(201, 162, 39, 0.3);
    }

    .leaflet-popup-content {
        margin: 0;
        padding: 20px;
        font-family: 'Poppins', sans-serif;
    }

    .leaflet-popup-tip {
        background: rgba(21, 41, 66, 0.95);
    }

    .popup-dark h5 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .popup-dark p {
        color: rgba(255,255,255,0.7);
        margin-bottom: 6px;
        font-size: 0.9rem;
    }

    .popup-dark a {
        color: #c9a227;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .popup-dark a:hover {
        color: #e8d5a3;
    }

    .popup-dark hr {
        border-color: rgba(255,255,255,0.1);
        margin: 12px 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .contact-hero-pro h1 {
            font-size: 2.5rem;
        }

        .contact-info-dark,
        .contact-form-dark {
            padding: 30px 25px;
        }

        #leaflet-map {
            height: 350px;
            min-height: 350px;
        }
    }
</style>
@endpush

@section('content')

{{-- Hero avec image de fond --}}
<section class="contact-hero-pro">
    <div class="content">
        <div class="badge-top">
            <i class="bi bi-envelope-fill"></i>
            Contactez-Nous
        </div>

        <h1>Contact</h1>
        <p>Pour toute question ou assistance concernant le système de gestion des pièces à conviction</p>
    </div>
</section>

{{-- Contact Section Sombre --}}
<section class="contact-dark-section">
    <div class="container">
        <div class="row g-4">
            {{-- Info --}}
            <div class="col-lg-5">
                <div class="contact-info-dark">
                    <h3><i class="bi bi-geo-alt me-2"></i>Informations</h3>

                    <div class="info-row-dark">
                        <i class="bi bi-geo-alt-fill"></i>
                        <div>
                            <strong>Adresse</strong>
                            <span>Tribunal de Première Instance<br>Sidi Bennour, Maroc</span>
                        </div>
                    </div>

                    <div class="info-row-dark">
                        <i class="bi bi-telephone-fill"></i>
                        <div>
                            <strong>Téléphone</strong>
                            <span>+212 705877129<br>+212 715372117</span>
                        </div>
                    </div>

                    <div class="info-row-dark">
                        <i class="bi bi-envelope-fill"></i>
                        <div>
                            <strong>Email</strong>
                            <span>contact@tpi-sidibennour.ma<br>support@tpi-sidibennour.ma</span>
                        </div>
                    </div>

                    <div class="info-row-dark">
                        <i class="bi bi-clock-fill"></i>
                        <div>
                            <strong>Horaires</strong>
                            <span>Lundi - Vendredi: 8h30 - 16h30</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="col-lg-7">
                <div class="contact-form-dark">
                    <h3><i class="bi bi-envelope-paper me-2"></i>Envoyez un Message</h3>

                    @if(session('success'))
                        <div class="alert alert-success-custom alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-dark">Nom Complet *</label>
                                <input type="text" name="name" class="form-control form-control-dark" required placeholder="Votre nom complet">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-dark">Email *</label>
                                <input type="email" name="email" class="form-control form-control-dark" required placeholder="votre@email.com">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-dark">Téléphone</label>
                                <input type="tel" name="phone" class="form-control form-control-dark" placeholder="+212 6XX-XXXXXX">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label-dark">Sujet *</label>
                                <select name="subject" class="form-select form-control-dark" required>
                                    <option value="">Choisir un sujet</option>
                                    <option value="support">Support Technique</option>
<option value="information">Demande d'Information</option>
<option value="bug">Signaler un Bug</option>
<option value="autre">Autre</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label-dark">Message *</label>
                                <textarea name="message" class="form-control form-control-dark" rows="5" required placeholder="Décrivez votre demande..."></textarea>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn-submit-dark">
                                    <i class="bi bi-send-fill me-2"></i>Envoyer le Message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Map Section avec Leaflet --}}
<section class="map-dark-section">
    <div class="container">
        <div class="section-header-white">
            <h3><i class="bi bi-geo-alt-fill me-2" style="color: #c9a227;"></i>Notre Localisation</h3>
            <p>Tribunal de Première Instance de Sidi Bennour</p>
            <div class="line"></div>
        </div>

        <div id="leaflet-map"></div>

        <div class="text-center mt-5">
            <a href="https://www.openstreetmap.org/directions?from=&to=32.6558%2C-8.4273" 
               target="_blank" 
               class="btn-itineraire-dark">
                <i class="bi bi-sign-turn-right me-2"></i>
                Obtenir l'Itinéraire
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- Leaflet CSS et JS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // CORRECTION: Verifier que le conteneur existe et est visible
        const mapContainer = document.getElementById('leaflet-map');
        if (!mapContainer) {
            console.error('Conteneur #leaflet-map non trouvé');
            return;
        }

        // S assurer que le conteneur a des dimensions avant d initialiser
        if (mapContainer.offsetWidth === 0 || mapContainer.offsetHeight === 0) {
            console.warn('Conteneur de carte sans dimensions, attente...');
            // Attendre que le DOM soit completement rendu
            setTimeout(initLeafletMap, 500);
        } else {
            initLeafletMap();
        }

        function initLeafletMap() {
            const tribunalLat = 32.6558;
            const tribunalLng = -8.4273;

            // CORRECTION: Creer la carte avec les options completes
            const map = L.map('leaflet-map', {
                center: [tribunalLat, tribunalLng],
                zoom: 15,
                zoomControl: true,
                attributionControl: true
            });

            // CORRECTION: Ajouter les tuiles avec les bons parametres
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19,
                subdomains: ['a', 'b', 'c']
            }).addTo(map);

            // Marqueur personnalise
            const tribunalIcon = L.divIcon({
                className: 'custom-marker',
                html: '<div style="background: linear-gradient(135deg, #c9a227 0%, #b8941f 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0a0e1a; font-size: 22px; border: 3px solid #fff; box-shadow: 0 4px 20px rgba(201, 162, 39, 0.4); font-weight: bold;">⚖️</div>',
                iconSize: [45, 45],
                iconAnchor: [22, 45],
                popupAnchor: [0, -45]
            });

            const marker = L.marker([tribunalLat, tribunalLng], { icon: tribunalIcon }).addTo(map);

            const popupContent = `
                <div class="popup-dark">
                    <h5>⚖️ Tribunal de Première Instance</h5>
                    <p><strong>Sidi Bennour, Maroc</strong></p>
                    <p>📍 Avenue Hassan II</p>
                    <p>📞 +212 705877129</p>
                    <hr>
                    <a href="https://www.openstreetmap.org/directions?from=&to=${tribunalLat}%2C${tribunalLng}" target="_blank">
                        📍 Itinéraire →
                    </a>
                </div>
            `;

            marker.bindPopup(popupContent).openPopup();

            // Cercle autour du tribunal
            L.circle([tribunalLat, tribunalLng], {
                color: '#c9a227',
                fillColor: '#c9a227',
                fillOpacity: 0.15,
                radius: 200
            }).addTo(map);

            // CORRECTION: Forcer le recalcul de la taille apres l'initialisation
            // Cela resout le probleme de tuiles fragmentees/disposees
            setTimeout(function() {
                map.invalidateSize();
            }, 300);

            // CORRECTION: Recalculer aussi au redimensionnement de la fenetre
            window.addEventListener('resize', function() {
                map.invalidateSize();
            });
        }
    });
</script>
@endpush