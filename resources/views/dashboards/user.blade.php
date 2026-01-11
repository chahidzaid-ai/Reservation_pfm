@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
  <h1>Tableau de bord</h1>

  <div class="grid3">
    <div class="card stat"><div class="muted">En attente</div><div class="big">{{ $stats['my_pending'] }}</div></div>
    <div class="card stat"><div class="muted">Approuvées</div><div class="big">{{ $stats['my_approved'] }}</div></div>
    <div class="card stat"><div class="muted">Terminées</div><div class="big">{{ $stats['my_finished'] }}</div></div>
  </div>

  <div class="card">
    <h2>Actions rapides</h2>
    <div class="row gap">
      <a class="btn" href="{{ route('reservations.create') }}">Nouvelle réservation</a>
      <a class="btn secondary" href="{{ route('resources.index') }}">Parcourir ressources</a>
    </div>
  </div>
@endsection
