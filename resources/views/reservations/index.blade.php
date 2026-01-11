@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')
  <div class="row between center">
    <h1>Mes réservations</h1>
    <a class="btn" href="{{ route('reservations.create') }}">+ Nouvelle demande</a>
  </div>

  <form class="filters card" method="get" action="{{ route('reservations.index') }}">
    <div class="grid3">
      <label>Statut
        <select name="status">
          <option value="">Tous</option>
          <option value="pending" @selected(request('status')==='pending')>En attente</option>
          <option value="approved" @selected(request('status')==='approved')>Approuvée</option>
          <option value="refused" @selected(request('status')==='refused')>Refusée</option>
          <option value="active" @selected(request('status')==='active')>Active</option>
          <option value="finished" @selected(request('status')==='finished')>Terminée</option>
        </select>
      </label>
      <div></div><div></div>
    </div>
    <div class="row gap">
      <button class="btn" type="submit">Filtrer</button>
      <a class="btn secondary" href="{{ route('reservations.index') }}">Réinitialiser</a>
    </div>
  </form>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Période</th>
          <th>Ressources</th>
          <th>Statut</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($reservations as $r)
          <tr>
            <td>#{{ $r->id }}</td>
            <td>{{ $r->start_at->format('Y-m-d H:i') }} → {{ $r->end_at->format('Y-m-d H:i') }}</td>
            <td>
              @foreach($r->items as $it)
                <span class="tag">{{ $it->resource?->name }}</span>
              @endforeach
            </td>
            <td><span class="pill {{ $r->status }}">{{ $r->status }}</span></td>
            <td><a href="{{ route('reservations.show', $r) }}">Détails</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pad">
    {{ $reservations->links() }}
  </div>
@endsection
