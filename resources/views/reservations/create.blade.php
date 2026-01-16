@extends('layouts.app')

@section('title', 'Nouvelle Réservation')

@section('content')
<div class="row between center">
    <h1>Nouvelle demande de réservation</h1>
    <a href="{{ route('reservations.index') }}" class="btn secondary">
        <i class="fa-solid fa-arrow-left"></i> Retour
    </a>
</div>

<form action="{{ route('reservations.store') }}" method="POST" class="card">
    @csrf

    @if(session('error'))
        <div class="alert error" style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Date Inputs --}}
    <div class="grid2" style="gap: 20px; margin-bottom: 20px;">
        <label>Date/heure début
            <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" required class="big-input">
        </label>
        <label>Date/heure fin
            <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" required class="big-input">
        </label>
    </div>

    {{-- Justification --}}
    <label style="margin-bottom: 20px; display: block;">Justification
        <textarea name="justification" rows="3" required class="big-input" placeholder="Pour quel projet ?">{{ old('justification') }}</textarea>
    </label>

    {{-- Resources Grid --}}
    <h3>Choisir des ressources</h3>
    <p class="muted small" style="margin-bottom: 15px;">Les ressources occupées ou en maintenance ne peuvent pas être sélectionnées.</p>

    <div class="grid cards"> 
        @foreach($resources as $r)
            {{-- Determine if disabled: Maintenance, Disabled, OR Reserved --}}
            @php
                $isDisabled = ($r->status === 'maintenance' || $r->status === 'disabled' || $r->is_reserved);
            @endphp

            <label class="card checkbox-card" style="cursor: {{ $isDisabled ? 'not-allowed' : 'pointer' }}; border: 1px solid #334155; position: relative; transition: all 0.2s; opacity: {{ $isDisabled ? '0.6' : '1' }};">
                
                {{-- HEADER: Name + Badge --}}
                <div class="row between">
                    <strong>{{ $r->name }}</strong>
                    
                    {{-- DYNAMIC BADGE LOGIC --}}
                    @if($r->status === 'maintenance')
                        <span class="pill maintenance">
                            <i class="fa-solid fa-screwdriver-wrench"></i> Maint.
                        </span>
                    @elseif($r->is_reserved)
                        <span class="pill refused">
                            <i class="fa-solid fa-lock"></i> Occupé
                        </span>
                    @elseif($r->status === 'disabled')
                        <span class="pill disabled">Désactivé</span>
                    @else
                        <span class="pill available">
                            <i class="fa-solid fa-check"></i> Dispo
                        </span>
                    @endif
                </div>

                <div class="muted small" style="margin-top: 5px;">{{ $r->category->name }} • {{ $r->location }}</div>
                
                {{-- Checkbox Overlay/Input --}}
                <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #334155;">
                    <input type="checkbox" name="resource_ids[]" value="{{ $r->id }}" 
                        style="transform: scale(1.2); margin-right: 8px;"
                        @checked(is_array(old('resource_ids')) && in_array($r->id, old('resource_ids')))
                        @disabled($isDisabled)
                    >
                    <span style="{{ $isDisabled ? 'color: #ef4444; font-weight:bold;' : '' }}">
                        {{ $isDisabled ? 'Indisponible' : 'Sélectionner' }}
                    </span>
                </div>

            </label>
        @endforeach
    </div>

    {{-- Submit Buttons --}}
    <div class="row gap" style="margin-top: 30px;">
        <button type="submit" class="btn">Envoyer la demande</button>
        <a href="{{ route('reservations.index') }}" class="btn secondary">Annuler</a>
    </div>

</form>
@endsection