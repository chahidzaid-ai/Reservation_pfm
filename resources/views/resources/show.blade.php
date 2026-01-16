@extends('layouts.app')

@section('title', $resource->name)

@section('content')
  <div class="row between center">
      <div class="row gap">
        <a href="{{ route('resources.index') }}" class="btn secondary">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1>{{ $resource->name }}</h1>
            <div class="muted">{{ $resource->category->name }} • {{ $resource->location }}</div>
        </div>
      </div>

      <div class="row gap center">
          {{-- DYNAMIC BADGE LOGIC (Matches List View) --}}
          @if($resource->status === 'maintenance')
            <span class="pill maintenance" style="font-size: 1rem; padding: 5px 15px;">
                <i class="fa-solid fa-screwdriver-wrench"></i> Maintenance
            </span>
          @elseif($resource->is_reserved)
            <span class="pill refused" style="font-size: 1rem; padding: 5px 15px;">
                <i class="fa-solid fa-lock"></i> Occupé
            </span>
          @elseif($resource->status === 'disabled')
            <span class="pill disabled" style="font-size: 1rem; padding: 5px 15px;">Désactivé</span>
          @else
            <span class="pill available" style="font-size: 1rem; padding: 5px 15px;">
                <i class="fa-solid fa-check"></i> Disponible
            </span>
          @endif

          {{-- Action Buttons --}}
          @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.resources.edit', $resource) }}" class="btn secondary">
                    <i class="fa-solid fa-pen"></i> Modifier
                </a>
            @endif
            
            <a href="{{ route('reservations.create', ['resource' => $resource->id]) }}" class="btn">
                Réserver
            </a>
          @endauth
      </div>
  </div>

  <div class="grid2" style="margin-top: 30px; gap: 30px; align-items: start;">
      
      {{-- LEFT COLUMN: Details --}}
      <div class="card">
          <h3>Caractéristiques</h3>
          
          <div class="grid2" style="margin-bottom: 20px;">
              <div class="muted">Responsable</div>
              <div>{{ $resource->manager ? $resource->manager->name : 'Aucun' }}</div>

              <div class="muted">Notes</div>
              <div>{{ $resource->notes ?? 'Aucune note.' }}</div>
          </div>

          @if($resource->specs)
            <div style="background: #1e293b; padding: 15px; border-radius: 8px;">
                <h4 style="margin-top: 0;">Specs</h4>
                <ul style="margin-bottom: 0; padding-left: 20px;">
                    @foreach($resource->specs as $key => $val)
                        <li><strong>{{ ucfirst($key) }} :</strong> {{ $val }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
      </div>

      {{-- RIGHT COLUMN: Maintenance & Reservations --}}
      <div style="display: flex; flex-direction: column; gap: 20px;">
          
          {{-- Active Maintenance Warning --}}
          @if($resource->status === 'maintenance')
            <div class="card" style="border: 1px solid #eab308; background: rgba(234, 179, 8, 0.1);">
                <h3 style="color: #eab308;"><i class="fa-solid fa-triangle-exclamation"></i> En Maintenance</h3>
                <p>Cette ressource est actuellement indisponible.</p>
            </div>
          @endif

          <div class="card">
              <h3>Maintenance planifiée</h3>
              @forelse($resource->maintenances->where('end_at', '>', now()) as $m)
                <div style="border-bottom: 1px solid #334155; padding-bottom: 10px; margin-bottom: 10px;">
                    <div class="row between">
                        <strong>{{ $m->start_at }}</strong>
                        <span class="muted">jusqu'au {{ $m->end_at }}</span>
                    </div>
                    <div class="small muted">{{ $m->reason }}</div>
                </div>
              @empty
                <div class="muted">Aucune maintenance future.</div>
              @endforelse
          </div>

      </div>
  </div>
@endsection