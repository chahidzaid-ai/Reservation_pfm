@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
  <h1>Notifications</h1>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>État</th>
          <th>Titre</th>
          <th>Message</th>
          <th>Date</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($notifications as $n)
          <tr>
            <td>{{ $n->read_at ? 'Lu' : 'Non lu' }}</td>
            <td><strong>{{ $n->title }}</strong></td>
            <td>{{ $n->body }}</td>
            <td>{{ $n->created_at->format('Y-m-d H:i') }}</td>
            <td>
              @if(!$n->read_at)
                <form method="post" action="{{ route('notifications.read', $n) }}">
                  @csrf
                  <button class="linklike" type="submit">Marquer lu</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pad">{{ $notifications->links() }}</div>
@endsection
