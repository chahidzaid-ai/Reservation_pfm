@extends('layouts.app')

@section('title', 'Demande de compte')

@section('content')
  <div class="card narrow">
    <h1>Demande d’ouverture de compte</h1>
    <p class="muted">Votre compte sera créé en attente d’activation par l’administrateur.</p>

    <form method="post" action="{{ route('account.request.post') }}">
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

      <label>Justification
        <textarea name="reason" rows="4" required>{{ old('reason') }}</textarea>
      </label>

      <button class="btn" type="submit">Envoyer la demande</button>
    </form>
  </div>
@endsection
