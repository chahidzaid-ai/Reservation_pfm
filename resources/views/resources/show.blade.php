@extends('layouts.app')

@section('title', $resource->name)

@section('content')
  <div class="row between center">
    <div>
      <h1>{{ $resource->name }}</h1>
      <div class="muted">{{ $resource->category?->name }} • {{ $resource->location ?? '—' }}</div>
    </div>

    <div class="row gap center">
      <span class="pill {{ $resource->state }}">{{ $resource->state }}</span>
      @auth
        @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'manager' && auth()->user()->id === $resource->manager_id))
          <a class="btn secondary" href="{{ route('admin.resources.edit', $resource) }}">Modifier</a>
        @endif
        <a class="btn" href="{{ route('reservations.create', ['resource' => $resource->id]) }}">Réserver</a>
      @endauth
    </div>
  </div>

  <div class="grid2">
    <div class="card">
      <h2>Caractéristiques</h2>
      <dl class="dl">
        <div><dt>Responsable</dt><dd>{{ $resource->manager?->name ?? '—' }}</dd></div>
        <div><dt>Notes</dt><dd>{{ $resource->notes ?? '—' }}</dd></div>
      </dl>

      <h3 class="mt">Specs</h3>
      @php($specs = $resource->specs ?? [])
      @if(count($specs) === 0)
        <p class="muted">Aucune spécification.</p>
      @else
        <ul class="list">
          @foreach($specs as $k => $v)
            <li><strong>{{ $k }}</strong> : {{ $v }}</li>
          @endforeach
        </ul>
      @endif
    </div>

    <div class="card">
      <h2>Maintenance planifiée</h2>
      @if($resource->maintenances->count() === 0)
        <p class="muted">Aucune maintenance.</p>
      @else
        <ul class="list">
          @foreach($resource->maintenances as $m)
            <li>
              <strong>{{ $m->start_at->format('Y-m-d H:i') }}</strong> → {{ $m->end_at->format('Y-m-d H:i') }}
              <div class="muted small">{{ $m->reason }}</div>
            </li>
          @endforeach
        </ul>
      @endif
    </div>
  </div>
@endsection
