@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
  <div class="card narrow">
    <h1>Connexion</h1>
    <form method="post" action="{{ route('login.post') }}">
      @csrf
      <label>Email
        <input type="email" name="email" value="{{ old('email') }}" required>
      </label>

      <label>Mot de passe
        <input type="password" name="password" required>
      </label>

      <label class="row gap">
        <input type="checkbox" name="remember" value="1">
        <span>Se souvenir de moi</span>
      </label>

      <div class="row between center">
        <button class="btn" type="submit">Se connecter</button>
        <a href="{{ route('register') }}">Créer un compte (démo)</a>
      </div>

      <p class="muted small">
        Pour une vraie demande d’ouverture de compte, utilisez « Demander un compte ».
      </p>
    </form>
  </div>
@endsection
