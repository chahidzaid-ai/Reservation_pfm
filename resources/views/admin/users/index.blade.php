@extends('layouts.app')

@section('title', 'Admin - Utilisateurs')

@section('content')
  <h1>Utilisateurs</h1>

  <form class="filters card" method="get" action="{{ route('admin.users.index') }}">
    <div class="grid3">
      <label>Rôle
        <select name="role">
          <option value="">Tous</option>
          <option value="guest" @selected(request('role')==='guest')>Invité</option>
          <option value="user" @selected(request('role')==='user')>Utilisateur</option>
          <option value="manager" @selected(request('role')==='manager')>Responsable</option>
          <option value="admin" @selected(request('role')==='admin')>Admin</option>
        </select>
      </label>
      <label>Actif
        <select name="active">
          <option value="">Tous</option>
          <option value="1" @selected(request('active')==='1')>Actif</option>
          <option value="0" @selected(request('active')==='0')>Inactif</option>
        </select>
      </label>
      <label>Recherche
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom / email">
      </label>
    </div>
    <div class="row gap">
      <button class="btn" type="submit">Filtrer</button>
      <a class="btn secondary" href="{{ route('admin.users.index') }}">Réinitialiser</a>
    </div>
  </form>

  <div class="card">
    <table class="table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Rôle</th>
          <th>Actif</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
          <tr>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td><span class="tag">{{ $u->role }}</span></td>
            <td>{{ $u->is_active ? 'Oui' : 'Non' }}</td>
            <td><a href="{{ route('admin.users.edit', $u) }}">Modifier</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="pad">{{ $users->links() }}</div>
@endsection
