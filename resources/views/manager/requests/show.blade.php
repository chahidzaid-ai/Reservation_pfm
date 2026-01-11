@extends('layouts.app')

@section('title', 'Demande #'.$reservation->id)

@section('content')
  <div class="row between center">
    <h1>Demande #{{ $reservation->id }}</h1>
    <span class="pill {{ $reservation->status }}">{{ $reservation->status }}</span>
  </div>

  @if(session('conflicts'))
    <div class="card warn">
      <strong>Conflits détectés :</strong>
      <ul class="list">
        @foreach(session('conflicts') as $c)
          <li>
            <span class="tag">{{ $c['type'] }}</span>
            Ressource ID: {{ $c['resource_id'] }}
            <div class="muted small">{{ $c['message'] }}</div>
          </li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid2">
    <div class="card">
      <h2>Demandeur</h2>
      <div><strong>{{ $reservation->user?->name }}</strong></div>
      <div class="muted">{{ $reservation->user?->email }}</div>

      <h3 class="mt">Période</h3>
      <div>{{ $reservation->start_at->format('Y-m-d H:i') }} → {{ $reservation->end_at->format('Y-m-d H:i') }}</div>

      <h3 class="mt">Justification</h3>
      <p>{{ $reservation->justification }}</p>
    </div>

    <div class="card">
      <h2>Ressources</h2>
      <ul class="list">
        @foreach($reservation->items as $it)
          <li><strong>{{ $it->resource?->name }}</strong></li>
        @endforeach
      </ul>

      <h3 class="mt">Décision</h3>
      <form method="post" action="{{ route('manager.requests.approve', $reservation) }}" class="mb">
        @csrf
        <label>Note (optionnelle)
          <textarea name="manager_note" rows="3"></textarea>
        </label>
        <button class="btn" type="submit">Approuver</button>
      </form>

      <form method="post" action="{{ route('manager.requests.refuse', $reservation) }}">
        @csrf
        <label>Justification du refus (obligatoire)
          <textarea name="manager_note" rows="3" required></textarea>
        </label>
        <button class="btn danger" type="submit">Refuser</button>
      </form>
    </div>
  </div>
@endsection
