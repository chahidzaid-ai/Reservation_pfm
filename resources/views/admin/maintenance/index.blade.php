@extends('layouts.app')

@section('title', 'Maintenance')

@section('content')
  <div class="row between center">
    <h1>Maintenances</h1>
    <a class="btn" href="{{ route('admin.maintenance.create') }}">+ Planifier</a>
  </div>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>Ressource</th>
          <th>Période</th>
          <th>Raison</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($maintenances as $m)
          <tr>
            <td>{{ $m->resource?->name }}</td>
            <td>{{ $m->start_at->format('Y-m-d H:i') }} → {{ $m->end_at->format('Y-m-d H:i') }}</td>
            <td>{{ $m->reason }}</td>
            <td>
              <form method="post" action="{{ route('admin.maintenance.delete', $m) }}">
                @csrf
                <button class="linklike danger" type="submit" onclick="return confirm('Supprimer ?')">Supprimer</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pad">{{ $maintenances->links() }}</div>
@endsection
