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
        <select name="state">
          <option value="">Tous</option>
          <option value="available" @selected(request('state')==='available')>Disponible</option>
          <option value="maintenance" @selected(request('state')==='maintenance')>Maintenance</option>
          <option value="disabled" @selected(request('state')==='disabled')>Désactivée</option>
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
          <span class="pill {{ $r->state }}">{{ $r->state }}</span>
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
