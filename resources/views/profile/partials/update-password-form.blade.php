<section>
    <header>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.6rem; margin-bottom: 5px;">
            Mettre à jour le Mot de Passe
        </h2>
        <p style="color: #777; margin-top: 0; margin-bottom: 20px;">
            Assurez-vous d'utiliser un mot de passe long et aléatoire pour rester en sécurité.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Mot de passe actuel</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password">
            @error('current_password', 'updatePassword') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">Nouveau mot de passe</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password">
            @error('password', 'updatePassword') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Confirmer le mot de passe</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <p class="error-message">{{ $message }}</p> @enderror
        </div>

        <div style="display: flex; align-items: center; justify-content: flex-end; gap: 1rem; margin-top: 20px;">
             @if (session('status') === 'password-updated')
                <p x-data="{...}" ... >Enregistré.</p>
            @endif
            <button type="submit" class="btn">Enregistrer</button>
        </div>
    </form>
</section>