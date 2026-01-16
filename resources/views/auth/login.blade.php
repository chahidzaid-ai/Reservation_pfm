@extends('layouts.app')

@section('title', 'Connexion')

@section('content')

{{-- Wrapper to center and add top spacing --}}
<div class="login-wrapper">

    {{-- The Big Card Container --}}
    <div class="big-card">
        <h1>Connexion</h1>
        
        <form method="post" action="{{ route('login.post') }}">
            @csrf
            
            {{-- Email Input --}}
            <label style="font-size: 1.1rem; color: #cbd5e1;">Email
                <input type="email" name="email" value="{{ old('email') }}" required 
                       class="big-input" 
                       placeholder="exemple@datacenter.com">
            </label>

            {{-- Password Input --}}
            <label style="font-size: 1.1rem; color: #cbd5e1;">Mot de passe
                <input type="password" name="password" required 
                       class="big-input" 
                       placeholder="••••••••">
            </label>

            {{-- Checkbox --}}
            <label class="row gap" style="margin-bottom: 30px; cursor: pointer; align-items: center;">
                <input type="checkbox" name="remember" value="1" style="width: 20px; height: 20px; margin: 0;">
                <span style="font-size: 1.1rem; margin-left: 10px;">Se souvenir de moi</span>
            </label>

            {{-- Buttons Area --}}
            <div class="row between center">
                <button class="btn btn-big" type="submit">
                    Se connecter
                </button>
                
                <a href="{{ route('account.request') }}" style="color: #60a5fa; font-size: 1.1rem; text-decoration: none;">
                    Demander un compte
                </a>
            </div>

        </form>
    </div>
</div>

@endsection