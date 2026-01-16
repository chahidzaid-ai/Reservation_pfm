@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
  <h1>Dashboard Administrateur</h1>

  <div class="grid4">
    <div class="card stat"><div class="muted">Ressources</div><div class="big">{{ $stats['resources_total'] }}</div></div>
    <div class="card stat"><div class="muted">Disponibles</div><div class="big">{{ $stats['resources_available'] }}</div></div>
    <div class="card stat"><div class="muted">Demandes en attente</div><div class="big">{{ $stats['reservations_pending'] }}</div></div>
    <div class="card stat"><div class="muted">Approuvées</div><div class="big">{{ $stats['reservations_approved'] }}</div></div>
  </div>

  <div class="card">
    <h2>Utilisation par catégorie (approx.)</h2>
    <canvas id="chart" width="900" height="280" data-chart='@json($chartData)'></canvas>
    <p class="muted small">Graphique simple en JavaScript (sans librairie).</p>
  </div>



  @push('scripts')
    <script>window.renderSimpleBarChart('chart');</script>
  @endpush
@endsection
