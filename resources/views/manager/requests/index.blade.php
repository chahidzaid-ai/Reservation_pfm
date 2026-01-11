@extends('layouts.app')

@section('title', 'Demandes')

@section('content')
  <h1>Demandes liées à mes ressources</h1>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Demandeur</th>
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
            <td>{{ $r->user?->name }}</td>
            <td>{{ $r->start_at->format('Y-m-d H:i') }} → {{ $r->end_at->format('Y-m-d H:i') }}</td>
            <td>
              @foreach($r->items as $it)
                <span class="tag">{{ $it->resource?->name }}</span>
              @endforeach
            </td>
            <td><span class="pill {{ $r->status }}">{{ $r->status }}</span></td>
            <td><a href="{{ route('manager.requests.show', $r) }}">Ouvrir</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pad">{{ $reservations->links() }}</div>
@endsection
