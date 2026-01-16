@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
<div class="row between center">
    <h1><i class="fa-solid fa-bell"></i> Mes Notifications</h1>
    
    {{-- Button to Mark All as Read --}}
    @if($notifications->count() > 0)
        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button type="submit" class="btn secondary small">
                <i class="fa-solid fa-check-double"></i> Tout marquer comme lu
            </button>
        </form>
    @endif
</div>

<div class="card" style="padding: 0; overflow: hidden;">
    @forelse($notifications as $n)
        <div style="padding: 20px; border-bottom: 1px solid #334155; background: {{ $n->read_at ? 'transparent' : 'rgba(59, 130, 246, 0.1)' }}; display: flex; gap: 15px; align-items: start;">
            
            {{-- Icon based on Type --}}
            <div style="font-size: 1.5rem; color: {{ $n->read_at ? '#94a3b8' : '#3b82f6' }}; margin-top: 5px;">
                @if($n->type === 'alert')
                    <i class="fa-solid fa-triangle-exclamation" style="color: #ef4444;"></i>
                @elseif($n->type === 'reservation')
                    <i class="fa-solid fa-calendar-check"></i>
                @else
                    <i class="fa-solid fa-circle-info"></i>
                @endif
            </div>

            <div style="flex: 1;">
                <div class="row between">
                    <strong style="font-size: 1.1rem; {{ $n->read_at ? 'color: #94a3b8;' : 'color: white;' }}">
                        {{ $n->title }}
                    </strong>
                    <small class="muted">{{ $n->created_at->diffForHumans() }}</small>
                </div>
                
                <p style="margin: 5px 0; color: #cbd5e1;">{{ $n->message }}</p>

                @if(!$n->read_at)
                    <form action="{{ route('notifications.read', $n->id) }}" method="POST" style="margin-top: 10px;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: #3b82f6; cursor: pointer; padding: 0; font-size: 0.9rem;">
                            Marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div style="padding: 40px; text-align: center; color: #94a3b8;">
            <i class="fa-regular fa-bell-slash" style="font-size: 2rem; margin-bottom: 10px; display: block;"></i>
            Aucune notification pour le moment.
        </div>
    @endforelse
</div>

<div class="pad">
    {{ $notifications->links() }}
</div>
@endsection