@extends('layouts.app')

@section('title', 'Signaler un incident')

@section('content')
  <h1>Signaler un incident</h1>

  <form class="card" method="post" action="{{ route('incidents.store') }}">
    @csrf

    <div class="grid2">
      <label>Ressource (optionnel)
        <select name="resource_id">
          <option value="">—</option>
          @foreach($resources as $r)
            <option value="{{ $r->id }}">{{ $r->name }}</option>
          @endforeach
        </select>
      </label>

      <label>Réservation (optionnel)
        <select name="reservation_id">
          <option value="">—</option>
          @foreach($reservations as $res)
            <option value="{{ $res->id }}">#{{ $res->id }} ({{ $res->status }})</option>
          @endforeach
        </select>
      </label>
    </div>

    <label>Description
      <textarea name="description" rows="6" required>{{ old('description') }}</textarea>
    </label>

    <button class="btn" type="submit">Envoyer</button>
  </form>
@endsection
