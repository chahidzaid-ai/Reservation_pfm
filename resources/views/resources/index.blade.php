@extends('layouts.app')

@section('title', 'Ressources')

@section('content')
  <div class="row between center">
    <h1>Ressources</h1>
    @auth
      @if(auth()->user()->role === 'admin')
        <a class="btn" href="{{ route('admin.resources.create') }}">+ Ajouter une ressource</a>
      @endif
    @endauth
  </div>

  <form class="filters card" method="get" action="{{ route('resources.index') }}">
    <div class="grid3">
      <label>Catégorie
        <select name="category">
          <option value="">Toutes</option>
          @foreach($categories as $c)
            <option value="{{ $c->slug }}" @selected(request('category')===$c->slug)>{{ $c->name }}</option>
          @endforeach
        </select>
      </label>

      <label>État
        <select name="status"> {{-- Updated name to match your DB column 'status' --}}
          <option value="">Tous</option>
          <option value="available" @selected(request('status')==='available')>Disponible</option>
          <option value="maintenance" @selected(request('status')==='maintenance')>Maintenance</option>
          <option value="disabled" @selected(request('status')==='disabled')>Désactivée</option>
        </select>
      </label>

      <label>Recherche
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom / emplacement">
      </label>
    </div>
    <div class="row gap">
      <button class="btn" type="submit">Filtrer</button>
      <a class="btn secondary" href="{{ route('resources.index') }}">Réinitialiser</a>
    </div>
  </form>

  <div class="grid cards">
    @foreach($resources as $r)
      <a class="card cardlink" href="{{ route('resources.show', $r) }}">
        <div class="row between">
    <strong>{{ $r->name }}</strong>
   
    {{-- CORRECT BADGE LOGIC --}}
    @if($r->status === 'maintenance')
        {{-- Priority 1: Maintenance --}}
        <span class="pill maintenance">
            <i class="fa-solid fa-screwdriver-wrench"></i> Maintenance
        </span>
    
    
@elseif($r->is_reserved)
    <span class="pill refused"><i class="fa-solid fa-lock"></i> Occupé</span>

{{-- NEW: Check for FUTURE reservations today --}}
@elseif($r->reservations()->where('start_at', '>', now())->where('start_at', '<', now()->endOfDay())->exists())
    <span class="pill" style="background: #e0f2fe; color: #0284c7; border: 1px solid #7dd3fc;">
        <i class="fa-regular fa-clock"></i> Réservé bientôt
    </span>
    @elseif($r->status === 'disabled')
        <span class="pill disabled">Désactivé</span>

    @else
        {{-- Priority 3: Available --}}
        <span class="pill available">
            <i class="fa-solid fa-check"></i> Disponible
        </span>
        
    @endif
</div>
        <div class="muted small">{{ $r->category?->name }}</div>
        <div class="small">Emplacement : {{ $r->location ?? '—' }}</div>
        <div class="small">Responsable : {{ $r->manager?->name ?? '—' }}</div>
      </a>
    @endforeach
  </div>

  <div class="pad">
    {{ $resources->links() }}
  </div>
@endsection