<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Riad - Restaurant & Réservations')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/client_style.css') }}">
    
    <!-- Scripts (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Permet d'injecter des styles spécifiques depuis d'autres vues --}}
    @stack('styles')
</head>
<body>
    
    <div class="client-app-wrapper">
        
        {{-- On inclut notre barre de navigation personnalisée --}}
        @include('partials.client-navigation')

        {{-- Barre Latérale pour Utilisateur Connecté (n'apparaît que si l'utilisateur est authentifié) --}}
        @auth
            @include('partials.client-sidebar')
        @endauth

        <!-- Contenu principal de la Page -->
        <main>
            <div class="container">
                
                {{-- Affichage des messages flash (notifications de succès, erreur, info) --}}
                @if (session('success'))
                    <div class="flash-message success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="flash-message error">{{ session('error') }}</div>
                @endif
                @if (session('info'))
                    <div class="flash-message info">{{ session('info') }}</div>
                @endif

                {{-- La section où le contenu de chaque page sera injecté --}}
                @yield('content')
            </div>
        </main>
        
        {{-- On inclut notre pied de page personnalisé --}}
        @include('partials.client-footer')

    </div>

    {{-- Permet d'injecter des scripts spécifiques depuis d'autres vues --}}
    @stack('scripts')
</body>
</html>