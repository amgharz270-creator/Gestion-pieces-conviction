@extends('layouts.auth')

@section('title', 'Inscription - TPI Sidi Bennour')

@section('content')

<div class="login-wrapper">
    <div class="login-card">
        {{-- Header --}}
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h1>Inscription</h1>
            <p>Créez votre compte pour accéder au système</p>
        </div>
        
        {{-- Error Messages --}}
        @if($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
        
        {{-- Form --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf
            
            {{-- Nom Complet --}}
            <div class="form-group">
                <label class="form-label">Nom Complet *</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-person-fill input-icon"></i>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-input" 
                        placeholder="Votre nom complet"
                        value="{{ old('name') }}"
                        required 
                        autofocus
                    >
                </div>
            </div>
            
            {{-- Email --}}
            <div class="form-group">
                <label class="form-label">Adresse Email *</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="votre@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
            </div>
            
            {{-- Téléphone --}}
            <div class="form-group">
                <label class="form-label">Téléphone</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-telephone-fill input-icon"></i>
                    <input 
                        type="tel" 
                        name="phone" 
                        class="form-input" 
                        placeholder="+212 6XX-XXXXXX"
                        value="{{ old('phone') }}"
                    >
                </div>
            </div>
            
            {{-- Mot de passe --}}
            <div class="form-group">
                <label class="form-label">Mot de passe *</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input" 
                        id="passwordInput"
                        placeholder="Minimum 8 caractères"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('passwordInput', 'toggleIcon')">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            
            {{-- Confirmation mot de passe --}}
            <div class="form-group">
                <label class="form-label">Confirmer le mot de passe *</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-input" 
                        id="confirmPasswordInput"
                        placeholder="Confirmez votre mot de passe"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword('confirmPasswordInput', 'toggleIconConfirm')">
                        <i class="bi bi-eye-slash" id="toggleIconConfirm"></i>
                    </button>
                </div>
            </div>
            
            {{-- Terms --}}
            <div class="form-group">
                <label class="remember-me" style="font-size: 0.85rem; color: rgba(255,255,255,0.6);">
                    <input type="checkbox" name="terms" required>
                    <span>J'accepte les <a href="#" style="color: var(--secondary); text-decoration: none;">conditions d'utilisation</a></span>
                </label>
            </div>
            
            {{-- Submit --}}
            <button type="submit" class="btn-login-submit">
                <i class="bi bi-person-plus"></i>
                S'inscrire
            </button>
        </form>
        
        {{-- Divider --}}
        <div class="divider">
            <span>ou</span>
        </div>
        
        {{-- Login link --}}
        <div class="back-home">
            <span style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">
                Déjà un compte ? 
                <a href="{{ route('login') }}" style="color: var(--secondary); text-decoration: none; font-weight: 600;">
                    Se connecter
                </a>
            </span>
        </div>
        
        {{-- Back to home --}}
        <div class="back-home" style="margin-top: 15px;">
            <a href="{{ route('welcome') }}">
                <i class="bi bi-arrow-left"></i>
                Retour à l'accueil
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
@endpush