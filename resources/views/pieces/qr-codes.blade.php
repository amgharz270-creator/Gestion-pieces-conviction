@extends('layouts.admin')

@section('title', 'QR Codes des Pièces')

@section('content')
<div class="admin-wrapper">
    @include('partials.admin-sidebar')
    <main class="main-content">
        <div class="top-bar">
            <div class="breadcrumb-custom">
                <a href="{{ route('dashboard') }}">Accueil</a> / QR Codes
            </div>
        </div>
        
        <div style="padding: 30px;">
            <h1 style="color: var(--accent-gold);">QR Codes des Pièces</h1>
            
            <div class="row">
                @foreach($pieces as $piece)
                <div class="col-md-3" style="margin-bottom: 20px;">
                    <div style="background: var(--card-bg); border-radius: 16px; padding: 15px; text-align: center;">
                        <div style="margin: 10px auto;">
                            {!! QrCode::size(150)->generate($piece->qr_code) !!}
                        </div>
                        <p><strong>{{ $piece->reference }}</strong></p>
                        <p style="font-size: 10px;">{{ $piece->qr_code }}</p>
                        <a href="{{ route('pieces.show', $piece) }}" class="btn-sm">Voir</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
</div>
@endsection