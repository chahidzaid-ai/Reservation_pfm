<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Data Center')</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
      /* --- GLOBAL LAYOUT --- */
      body {
          display: flex;
          flex-direction: column;
          min-height: 100vh;
          margin: 0;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
          background-color: #f1f5f9;
      }
      main {
          flex: 1;
          margin-top: 20px;
      }

      /* --- NAVBAR STYLING --- */
      .topbar {
          background-color: #1e293b; /* Dark Slate Blue */
          color: white;
          padding: 0 30px;
          height: 70px;
          box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
          display: flex;
          align-items: center;
          justify-content: space-between;
      }

      .nav-left {
          display: flex;
          align-items: center;
          gap: 12px;
          font-size: 1.2rem;
          font-weight: bold;
          min-width: 200px;
      }
      .nav-left a { color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; }

      .nav-center {
          display: flex;
          gap: 25px; 
      }
      .nav-link {
          color: #cbd5e1;
          text-decoration: none;
          font-weight: 600;
          font-size: 0.95rem;
          padding-bottom: 5px;
          transition: all 0.3s;
          border-bottom: 2px solid transparent;
          display: flex;
          align-items: center;
          gap: 8px;
      }
      .nav-link:hover { color: white; }
      .nav-link.active { color: white; border-bottom: 2px solid #38bdf8; }

      .nav-right {
          display: flex;
          align-items: center;
          gap: 20px;
          min-width: 200px;
          justify-content: flex-end;
      }
      
      .lang-switch { font-size: 0.85rem; color: #94a3b8; font-weight: 600; letter-spacing: 1px; }
      .lang-switch span.active { color: white; }
      .profile-link { color: white; text-decoration: none; font-weight: 600; }

      .btn-logout {
          background-color: #ef4444;
          color: white;
          border: none;
          padding: 8px 24px;
          border-radius: 9999px;
          font-weight: bold;
          cursor: pointer;
          transition: background 0.3s;
      }
      .btn-logout:hover { background-color: #dc2626; }

      /* --- FOOTER --- */
      .footer-section { background-color: #1e293b; color: #cbd5e1; padding: 2rem 0; margin-top: auto; }
      .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 2rem; border-bottom: 1px solid #334155; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
      .footer-col h4 { color: #fff; margin-bottom: 1rem; }
      .footer-col ul { list-style: none; padding: 0; }
      .footer-col ul li { margin-bottom: 0.5rem; }
      .footer-col a { color: #cbd5e1; text-decoration: none; transition: 0.3s; }
      .footer-col a:hover { color: #fff; }
  </style>
</head>
<body>

  {{-- HEADER --}}
  <header class="topbar">
      
      {{-- 1. LEFT --}}
      <div class="nav-left">
          <a href="{{ route('home') }}">
              <i class="fa-solid fa-server fa-lg"></i>
              <span>DC-Manager</span>
          </a>
      </div>

      {{-- 2. CENTER --}}
      <nav class="nav-center">
          <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
              Home
          </a>

          <a href="{{ route('rules') }}" class="nav-link {{ request()->routeIs('rules') ? 'active' : '' }}">
            Rules
          </a>
          
          <a href="{{ route('resources.index') }}" class="nav-link {{ request()->routeIs('resources.*') ? 'active' : '' }}">
              Ressources
          </a>

          @auth
              <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  Tableau de bord
              </a>

              {{-- FIXED WIDTH ICONS (fa-fw) FOR ALIGNMENT --}}
              <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                  <i class="fa-solid fa-bell fa-fw"></i> Notifications
              </a>

              <a href="{{ route('incidents.index') }}" class="nav-link {{ request()->routeIs('incidents.*') ? 'active' : '' }}">
                  <i class="fa-solid fa-triangle-exclamation fa-fw"></i> Incidents
              </a>

              {{-- ADMIN LINKS --}}
              @if(auth()->user()->role === 'admin')
                  <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                      Utilisateurs
                  </a>
                  
                  <a href="{{ route('admin.maintenance.index') }}" class="nav-link {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                      Maintenances
                  </a>
              @endif

              {{-- MANAGER AREA --}}
              @if(auth()->user()->role === 'manager')
                <a href="{{ route('manager.requests.index') }}" class="nav-link {{ request()->routeIs('manager.*') ? 'active' : '' }}">
                    Manager Area
                </a>
              @endif
          @endauth
      </nav>

      {{-- 3. RIGHT --}}
      <div class="nav-right">
          
          @auth
              <a href="{{ route('profile.edit') }}" class="profile-link" style="display: flex; align-items: center; gap: 10px;">
                @if(auth()->user()->avatar)
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                        style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #3b82f6;">
                @else
                    <div style="width: 35px; height: 35px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem; color: white;">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                @endif
                <span>{{ auth()->user()->name }}</span>
            </a>

              <form method="post" action="{{ route('logout') }}" style="margin:0;">
                  @csrf
                  <button type="submit" class="btn-logout">Logout</button>
              </form>
          @else
              <a href="{{ route('login') }}" class="profile-link">Login</a>
              <a href="{{ route('account.request') }}" class="btn-logout" style="background-color: #3b82f6;">Join</a>
          @endauth
      </div>

  </header>

  {{-- MAIN --}}
  <main class="container pad">
    @if(session('success'))
      <div class="toast success" style="background:#22c55e; color:white; padding:15px; border-radius:5px; margin-bottom:15px;">
        <i class="fa-solid fa-check"></i> {{ session('success') }}
      </div>
    @endif
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="footer-section">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-col">
            <h4><i class="fa-solid fa-server"></i> Data Center</h4>
            <p class="small">Gestion professionnelle des ressources.</p>
        </div>
        <div class="footer-col">
            <h4>Navigation</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('resources.index') }}">Ressources</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Contact</h4>
            <ul>
                <li><i class="fa-solid fa-envelope"></i> admin@dc-manager.com</li>
            </ul>
        </div>
      </div>
      <div class="small center" style="text-align: center;">
        © {{ date('Y') }} DC-Manager.
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>