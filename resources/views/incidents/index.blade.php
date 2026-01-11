@extends('layouts.app')

@section('title', 'Incidents')

@section('content')
  <div class="row between center">
    <h1>Incidents</h1>
    <a class="btn" href="{{ route('incidents.create') }}">+ Signaler</a>
  </div>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Statut</th>
          <th>Ressource</th>
          <th>Réservation</th>
          <th>Déclarant</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($incidents as $i)
          <tr>
            <td>#{{ $i->id }}</td>
            <td><span class="pill {{ $i->status }}">{{ $i->status }}</span></td>
            <td>{{ $i->resource?->name ?? '—' }}</td>
            <td>{{ $i->reservation_id ? '#'.$i->reservation_id : '—' }}</td>
            <td>{{ $i->reporter?->name }}</td>
            <td>{{ $i->created_at->format('Y-m-d H:i') }}</td>
            <td><a href="{{ route('incidents.show', $i) }}">Détails</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pad">{{ $incidents->links() }}</div>
@endsection
