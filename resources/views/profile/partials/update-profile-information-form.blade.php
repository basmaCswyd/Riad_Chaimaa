<section>
    <header>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.6rem; margin-bottom: 5px;">
            Informations du Profil
        </h2>
        <p style="color: #777; margin-top: 0; margin-bottom: 20px;">
            Mettez à jour les informations de votre compte.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-grid">
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input id="prenom" name="prenom" type="text" value="{{ old('prenom', $user->prenom) }}" required autofocus autocomplete="given-name">
                {{-- Affiche l'erreur si elle existe --}}
                @error('prenom') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="nom">Nom</label>
                <input id="nom" name="nom" type="text" value="{{ old('nom', $user->nom) }}" required autocomplete="family-name">
                @error('nom') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="num_telephone">Numéro de téléphone</label>
                <input id="num_telephone" name="num_telephone" type="tel" value="{{ old('num_telephone', $user->num_telephone) }}" required>
                @error('num_telephone') <p class="error-message">{{ $message }}</p> @enderror
            </div>
             <div class="form-group">
                <label for="cin">CIN</label>
                <input id="cin" name="cin" type="text" value="{{ old('cin', $user->cin) }}" required>
                @error('cin') <p class="error-message">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="form-group">
            <label for="annee_naissance">Année de naissance</label>
            <input id="annee_naissance" name="annee_naissance" type="number" value="{{ old('annee_naissance', $user->annee_naissance) }}" required>
            @error('annee_naissance') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 1rem; margin-top: 20px;">
            {{-- Affiche un message de succès si le profil a été mis à jour --}}
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="color: #1b5e20; font-weight: 500;"
                >Enregistré.</p>
            @endif

            <button type="submit" class="btn">Enregistrer</button>
        </div>
    </form>
</section>