@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="login-wrapper" style="padding-top: 40px; min-height: auto;">
    <div class="big-card" style="max-width: 700px;">
        
        {{-- Add enctype to allow file uploads --}}
        <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row between center" style="margin-bottom: 30px; border-bottom: 1px solid #334155; padding-bottom: 20px;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    
                    {{-- IMAGE DISPLAY LOGIC --}}
                    <div style="position: relative;">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="Avatar" 
                                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #3b82f6;">
                        @else
                            <div style="width: 80px; height: 80px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold; color: white;">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        
                        {{-- Small camera icon overlay --}}
                        <label for="avatar-input" style="position: absolute; bottom: 0; right: 0; background: #2563eb; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid #1e293b;">
                            <i class="fa-solid fa-camera" style="font-size: 0.8rem; color: white;"></i>
                        </label>
                        <input type="file" name="avatar" id="avatar-input" style="display: none;" onchange="this.form.submit()"> 
                        {{-- Note: Auto-submit on change for instant preview effect, or remove onchange to submit via button --}}
                    </div>

                    <div>
                        <h1 style="margin: 0; font-size: 1.8rem;">{{ $user->name }}</h1>
                        <span class="pill active" style="margin-top: 5px;">{{ ucfirst($user->role) }}</span>
                    </div>
                </div>
            </div>

            <div class="grid2" style="gap: 20px;">
                <label style="font-size: 1rem; color: #cbd5e1;">Nom complet
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="big-input" required>
                </label>

                <label style="font-size: 1rem; color: #cbd5e1;">Email
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="big-input" required>
                </label>
            </div>

            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed #334155;">
                <h3 style="color: #94a3b8; margin-bottom: 15px;">Changer le mot de passe (Optionnel)</h3>
                
                <div class="grid2" style="gap: 20px;">
                    <label style="font-size: 1rem; color: #cbd5e1;">Nouveau mot de passe
                        <input type="password" name="password" class="big-input" placeholder="Laisser vide pour garder l'actuel">
                    </label>

                    <label style="font-size: 1rem; color: #cbd5e1;">Confirmer
                        <input type="password" name="password_confirmation" class="big-input" placeholder="Répéter le mot de passe">
                    </label>
                </div>
            </div>

            <div class="row" style="margin-top: 30px; justify-content: flex-end;">
                <button class="btn btn-big" type="submit">
                    <i class="fa-solid fa-save"></i> Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection