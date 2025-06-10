<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Inscription - Riad</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Notre CSS d'authentification -->
    <link rel="stylesheet" href="{{ asset('css/auth_style.css') }}">
</head>
<body class="auth-page">
    <div class="auth-container">
        <div class="auth-header">
            <div class="logo"><a href="{{ route('home') }}">Riad</a></div>
            <h2>Créez votre compte pour réserver votre table</h2>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Prénom et Nom -->
            <div class="form-grid">
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required autofocus autocomplete="given-name" class="@error('prenom') input-error @enderror">
                    @error('prenom')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required autocomplete="family-name" class="@error('nom') input-error @enderror">
                    @error('nom')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="@error('email') input-error @enderror">
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Téléphone -->
            <div class="form-group">
                <label for="num_telephone">Numéro de téléphone</label>
                <input id="num_telephone" type="tel" name="num_telephone" value="{{ old('num_telephone') }}" required autocomplete="tel" class="@error('num_telephone') input-error @enderror">
                 @error('num_telephone')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Année de naissance et CIN -->
            <div class="form-grid">
                <div class="form-group">
                    <label for="annee_naissance">Année de naissance</label>
                    <input id="annee_naissance" type="number" name="annee_naissance" value="{{ old('annee_naissance') }}" required placeholder="Ex: 1990" class="@error('annee_naissance') input-error @enderror">
                    @error('annee_naissance')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cin">CIN</label>
                    <input id="cin" type="text" name="cin" value="{{ old('cin') }}" required autocomplete="off" class="@error('cin') input-error @enderror">
                    @error('cin')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="@error('password') input-error @enderror">
                 @error('password')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmation du mot de passe -->
            <div class="form-group">
                <label for="password_confirmation">Confirmer le mot de passe</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn-auth">
                S'inscrire
            </button>

            <div class="auth-footer">
                <p>Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
            </div>
        </form>
    </div>
</body>
</html>