<section>
    <header>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 1.6rem; margin-bottom: 5px; color: #b71c1c;">
            Supprimer le Compte
        </h2>
        <p style="color: #777; margin-top: 0; margin-bottom: 20px;">
            Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées.
        </p>
    </header>
    
    {{-- Le bouton ouvre une modale de confirmation, gérée par Alpine.js (inclus dans Breeze) --}}
    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn" style="background-color: #d9534f; border-color: #d9534f;"
    >Supprimer mon Compte</button>

    {{-- La modale de confirmation --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 25px;">
            @csrf
            @method('delete')
            <h2 style="font-family: 'Playfair Display', serif; font-size: 1.4rem;">
                Êtes-vous sûr de vouloir supprimer votre compte ?
            </h2>
            <p style="color: #777; margin-top: 10px;">
                Veuillez entrer votre mot de passe pour confirmer la suppression définitive de votre compte.
            </p>
            <div class="form-group" style="margin-top: 20px;">
                <label for="password" class="sr-only">Mot de passe</label>
                <input id="password" name="password" type="password" placeholder="Mot de passe">
                @error('password', 'userDeletion') <p class="error-message">{{ $message }}</p> @enderror
            </div>
            <div class="button-group" style="justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" x-on:click="$dispatch('close')">Annuler</button>
                <button type="submit" class="btn" style="background-color: #d9534f; border-color: #d9534f; margin-left: 10px;">Supprimer le Compte</button>
            </div>
        </form>
    </x-modal>
</section>