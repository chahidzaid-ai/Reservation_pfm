@extends('layouts.app')

@section('title', 'Incident #'.$incident->id)

@section('content')
  <div class="row between center">
    <h1>Incident #{{ $incident->id }}</h1>
    <span class="pill {{ $incident->status }}">{{ $incident->status }}</span>
  </div>

  <div class="card">
    <dl class="dl">
      <div><dt>Déclarant</dt><dd>{{ $incident->reporter?->name }}</dd></div>
      <div><dt>Ressource</dt><dd>{{ $incident->resource?->name ?? '—' }}</dd></div>
      <div><dt>Réservation</dt><dd>{{ $incident->reservation_id ? '#'.$incident->reservation_id : '—' }}</dd></div>
      <div><dt>Description</dt><dd>{{ $incident->description }}</dd></div>
    </dl>
  </div>
@endsection
