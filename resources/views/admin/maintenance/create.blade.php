@extends('layouts.app')

@section('title', 'Planifier une maintenance')

@section('content')
  <h1>Planifier une maintenance</h1>

  <form class="card narrow" method="post" action="{{ route('admin.maintenance.store') }}">
    @csrf
    <label>Ressource
      <select name="resource_id" required>
        @foreach($resources as $r)
          <option value="{{ $r->id }}">{{ $r->name }}</option>
        @endforeach
      </select>
    </label>

    <label>Début
      <input type="datetime-local" name="start_at" required>
    </label>

    <label>Fin
      <input type="datetime-local" name="end_at" required>
    </label>

    <label>Raison
      <textarea name="reason" rows="4" required></textarea>
    </label>

    <button class="btn" type="submit">Créer</button>
  </form>
@endsection
