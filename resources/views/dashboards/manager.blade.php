@extends('layouts.app')

@section('title', 'Dashboard Responsable')

@section('content')
  <h1>Dashboard Responsable</h1>

  <div class="grid3">
    <div class="card stat"><div class="muted">Ressources gérées</div><div class="big">{{ $stats['managed_resources'] }}</div></div>
    <div class="card stat"><div class="muted">Demandes en attente</div><div class="big">{{ $stats['pending_requests'] }}</div></div>
    <div class="card stat"><div class="muted">Demandes approuvées</div><div class="big">{{ $stats['approved_requests'] }}</div></div>
  </div>

  <div class="card">
    <h2>Top ressources (par demandes)</h2>
    <canvas id="chart" width="900" height="280" data-chart='@json($chartData)'></canvas>
    <p class="muted small">Graphique simple en JavaScript (sans librairie).</p>
  </div>

  @push('scripts')
    <script>window.renderSimpleBarChart('chart');</script>
  @endpush
@endsection
