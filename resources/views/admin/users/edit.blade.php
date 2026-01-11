@extends('layouts.app')

@section('title', 'Modifier utilisateur')

@section('content')
  <h1>Modifier utilisateur</h1>

  <div class="card narrow">
    <div class="muted small">{{ $user->email }}</div>

    <form method="post" action="{{ route('admin.users.update', $user) }}">
      @csrf
      <label>Rôle
        <select name="role" required>
          <option value="guest" @selected($user->role==='guest')>Invité</option>
          <option value="user" @selected($user->role==='user')>Utilisateur</option>
          <option value="manager" @selected($user->role==='manager')>Responsable</option>
          <option value="admin" @selected($user->role==='admin')>Admin</option>
        </select>
      </label>

      <label>Actif
        <select name="is_active" required>
          <option value="1" @selected($user->is_active)>Oui</option>
          <option value="0" @selected(!$user->is_active)>Non</option>
        </select>
      </label>

      <button class="btn" type="submit">Enregistrer</button>
      <a class="btn secondary" href="{{ route('admin.users.index') }}">Retour</a>
    </form>
  </div>
@endsection
