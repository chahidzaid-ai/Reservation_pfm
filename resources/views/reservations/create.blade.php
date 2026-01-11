@extends('layouts.app')

@section('title', 'Nouvelle demande')

@section('content')
  <h1>Nouvelle demande de réservation</h1>

  @if(session('conflicts'))
    <div class="card warn">
      <strong>Conflits détectés :</strong>
      <ul class="list">
        @foreach(session('conflicts') as $c)
          <li>
            <span class="tag">{{ $c['type'] }}</span>
            Ressource ID: {{ $c['resource_id'] }}
            @if(isset($c['resource_name'])) — {{ $c['resource_name'] }} @endif
            <div class="muted small">{{ $c['message'] }}</div>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  <form class="card" method="post" action="{{ route('reservations.store') }}">
    @csrf
    <div class="grid2">
      <label>Date/heure début
        <input type="datetime-local" name="start_at" value="{{ old('start_at') }}" required>
      </label>
      <label>Date/heure fin
        <input type="datetime-local" name="end_at" value="{{ old('end_at') }}" required>
      </label>
    </div>

    <label>Justification
      <textarea name="justification" rows="4" required>{{ old('justification') }}</textarea>
    </label>

    <h2>Choisir des ressources</h2>
    <p class="muted small">Astuce: filtrez d’abord via la page Ressources si besoin.</p>

    <div class="grid cards">
      @foreach($resources as $res)
        <label class="card checkcard">
          <div class="row between center">
            <div>
              <strong>{{ $res->name }}</strong>
              <div class="muted small">{{ $res->category?->name }} • {{ $res->location ?? '—' }}</div>
            </div>
            <span class="pill {{ $res->state }}">{{ $res->state }}</span>
          </div>
          <div class="row gap center mt">
            <input type="checkbox" name="resource_ids[]" value="{{ $res->id }}"
              @checked(in_array($res->id, old('resource_ids', [])))>
            <span>Sélectionner</span>
          </div>
        </label>
      @endforeach
    </div>

    <div class="row gap">
      <button class="btn" type="submit">Envoyer la demande</button>
      <a class="btn secondary" href="{{ route('reservations.index') }}">Annuler</a>
    </div>
  </form>
@endsection
