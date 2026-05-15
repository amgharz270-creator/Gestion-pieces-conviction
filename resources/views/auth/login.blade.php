@extends('layouts.auth')

@section('title', 'Connexion - TPI Sidi Bennour')

@section('content')

<div class="login-wrapper">
    <div class="login-card">
        {{-- Header --}}
        <div class="login-header">
            <div class="login-logo">
                <i class="bi bi-shield-lock-fill"></i>
            </div>
            <h1>Connexion</h1>
            <p>Accédez au système de gestion des pièces à conviction</p>
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
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            {{-- Email --}}
            <div class="form-group">
                <label class="form-label">Adresse Email</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-envelope-fill input-icon"></i>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="votre@email.com"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                </div>
            </div>
            
            {{-- Password --}}
            <div class="form-group">
                <label class="form-label">Mot de passe</label>
                <div class="input-icon-wrapper">
                    <i class="bi bi-lock-fill input-icon"></i>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input" 
                        id="passwordInput"
                        placeholder="Votre mot de passe"
                        required
                    >
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="bi bi-eye-slash" id="toggleIcon"></i>
                    </button>
                </div>
            </div>
            
            {{-- Options --}}
            <div class="login-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span>Se souvenir de moi</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>
            
            {{-- Submit --}}
            <button type="submit" class="btn-login-submit">
                <i class="bi bi-box-arrow-in-right"></i>
                Se Connecter
            </button>
        </form>
        
        {{-- Divider --}}
        <div class="divider">
            <span>ou</span>
        </div>
        
        {{-- Register link --}}
        <div class="back-home">
            <span style="color: rgba(255,255,255,0.5); font-size: 0.9rem;">
                Pas de compte ? 
                <a href="{{ route('register') }}" style="color: var(--secondary); text-decoration: none; font-weight: 600;">
                    S'inscrire
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
    function togglePassword() {
        const input = document.getElementById('passwordInput');
        const icon = document.getElementById('toggleIcon');
        
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