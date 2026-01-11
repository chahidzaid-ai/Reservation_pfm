@extends('layouts.app')

@section('title', 'Créer un compte')

@section('content')
  <div class="card narrow">
    <h1>Créer un compte (démo)</h1>
    <form method="post" action="{{ route('register.post') }}">
      @csrf
      <label>Nom complet
        <input type="text" name="name" value="{{ old('name') }}" required>
      </label>

      <label>Email
        <input type="email" name="email" value="{{ old('email') }}" required>
      </label>

      <label>Mot de passe
        <input type="password" name="password" required>
      </label>

      <label>Confirmer le mot de passe
        <input type="password" name="password_confirmation" required>
      </label>

      <button class="btn" type="submit">Créer</button>
    </form>
  </div>
@endsection
