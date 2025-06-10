<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion - Riad</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Notre CSS d'authentification -->
    <link rel="stylesheet" href="{{ asset('css/auth_style.css') }}">
</head>
<body class="auth-page">
    <div class="auth-container" style="max-width: 420px;">
        <div class="auth-header">
            <div class="logo"><a href="{{ route('home') }}">Riad</a></div>
            <h2>Accédez à votre espace ou à l'administration</h2>
        </div>
        
        <!-- Affichage des messages de statut (ex: après réinitialisation mdp) -->
        @if (session('status'))
            <div style="margin-bottom: 1rem; font-size: 0.9rem; color: #1b5e20; background: #e9f5e9; padding: 10px; border-radius: 6px;">
                {{ session('status') }}
            </div>
        @endif

        <!-- Affichage des erreurs de connexion (ex: identifiants incorrects) -->
        @if ($errors->any())
            <div style="margin-bottom: 1rem;">
                <div style="font-weight: 500; color: #b71c1c;">Oups! Quelque chose s'est mal passé.</div>
                <ul style="margin-top: 0.5rem; list-style: disc; padding-left: 1.5rem; font-size: 0.9rem; color: #b71c1c;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <!-- Se souvenir de moi -->
            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; font-size: 0.9rem;">
                <label for="remember_me" style="display: flex; align-items: center; margin:0; font-weight: normal;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: auto; margin-right: 8px;">
                    <span>Se souvenir de moi</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="auth-footer-link">
                        Mot de passe oublié ?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-auth">
                Se Connecter
            </button>

            <div class="auth-footer">
                <p>Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous</a></p>
            </div>
        </form>
    </div>
</body>
</html>