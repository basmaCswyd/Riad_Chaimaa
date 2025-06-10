<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin - Riad')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/admin_style.css') }}">
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="container-fluid">
        
        {{-- Barre Latérale de Navigation Admin --}}
        @include('layouts.admin-sidebar')

        <!-- Contenu principal de l'admin -->
        <div class="main-content">
            
            {{-- Barre d'en-tête du contenu principal (Titre de page, infos utilisateur) --}}
            <header class="admin-header-bar">
                <h2 class="page-title">@yield('title')</h2>
                <div class="user-info">
                    <span>Connecté en tant que : <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong></span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: 15px;">
                        @csrf
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); this.closest('form').submit();">
                           <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                        </a>
                    </form>
                </div>
            </header>

            {{-- Affichage des messages flash --}}
            @if (session('success'))
                <div class="flash-message success" style="max-width: none; text-align: left;">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="flash-message error" style="max-width: none; text-align: left;">{{ session('error') }}</div>
            @endif

            {{-- Le contenu spécifique à la page sera injecté ici --}}
            @yield('content')
            
        </div>
    </div>

    {{-- Scripts spécifiques à une page admin (si nécessaire) --}}
    @stack('scripts')
</body>
</html>