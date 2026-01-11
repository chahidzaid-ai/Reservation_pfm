<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Data Center')</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
  <header class="topbar">
    <div class="container row between center">
      <a class="brand" href="{{ route('home') }}">DC-Réservations</a>
      <nav class="nav">
        <a href="{{ route('resources.index') }}">Ressources</a>
        @auth
          <a href="{{ route('dashboard') }}">Tableau de bord</a>
          <a href="{{ route('reservations.index') }}">Mes réservations</a>
          <a href="{{ route('notifications.index') }}">Notifications</a>
          <a href="{{ route('incidents.index') }}">Incidents</a>
          @if(in_array(auth()->user()->role, ['manager','admin']))
            <a href="{{ route('manager.requests.index') }}">Demandes</a>
          @endif
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}">Admin</a>
          @endif
          <form method="post" action="{{ route('logout') }}" class="inline">
            @csrf
            <button class="linklike" type="submit">Déconnexion</button>
          </form>
        @else
          <a href="{{ route('login') }}">Connexion</a>
          <a class="btn" href="{{ route('account.request') }}">Demander un compte</a>
        @endauth
      </nav>
    </div>
  </header>

  <main class="container pad">
    @if(session('success'))
      <div class="toast success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="toast error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
      <div class="toast error">
        <strong>Erreurs :</strong>
        <ul>
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @yield('content')
  </main>

  <footer class="footer">
    <div class="container small">
      © {{ date('Y') }} Data Center — Gestion des ressources
    </div>
  </footer>

  <script src="{{ asset('js/app.js') }}"></script>
  @stack('scripts')
</body>
</html>
