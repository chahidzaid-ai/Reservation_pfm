@extends('layouts.app')

@section('title', 'Réservation #'.$reservation->id)

@section('content')
  <div class="row between center">
    <h1>Réservation #{{ $reservation->id }}</h1>
    <span class="pill {{ $reservation->status }}">{{ $reservation->status }}</span>
  </div>

  <div class="grid2">
    <div class="card">
      <h2>Détails</h2>
      <dl class="dl">
        <div><dt>Période</dt><dd>{{ $reservation->start_at->format('Y-m-d H:i') }} → {{ $reservation->end_at->format('Y-m-d H:i') }}</dd></div>
        <div><dt>Demandeur</dt><dd>{{ $reservation->user?->name }}</dd></div>
        <div><dt>Justification</dt><dd>{{ $reservation->justification }}</dd></div>
        <div><dt>Note responsable</dt><dd>{{ $reservation->manager_note ?? '—' }}</dd></div>
      </dl>
    </div>

    <div class="card">
      <h2>Ressources</h2>
      <ul class="list">
        @foreach($reservation->items as $it)
          <li>
            <strong>{{ $it->resource?->name }}</strong>
            <div class="muted small">{{ $it->resource?->category?->name }} • {{ $it->resource?->location }}</div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
@endsection
