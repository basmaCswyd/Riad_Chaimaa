<!-- Le "marqueur" visible sur le côté gauche de la page -->
<div class="sidebar-marker" id="sidebar-marker" aria-label="Ouvrir le menu personnel"></div>

<!-- La barre de navigation latérale, initialement cachée -->
<aside class="sidebar-nav" id="sidebar-nav">
    <div class="sidebar-header">
        <h3>Espace Client</h3>
        <p>Bonjour, {{ Auth::user()->prenom }} !</p>
    </div>
    <nav>
        <ul>
            <li>
                <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-cog fa-fw"></i>
                    <span>Paramètres du Profil</span>
                </a>
            </li>
            <li>
                <a href="{{ route('client.reservations.index') }}" class="{{ request()->routeIs('client.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check fa-fw"></i>
                    <span>Mes Réservations</span>
                </a>
            </li>
            <li>
                <a href="{{ route('client.notifications.index') }}" class="{{ request()->routeIs('client.notifications.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope-open-text fa-fw"></i>
                    <span>Boîte de Messagerie</span>
                    
                    {{-- Optionnel: Afficher un compteur de notifications non lues --}}
                    @php
                        // $unreadNotifications = Auth::user()->unreadNotifications()->count();
                    @endphp
                    {{-- @if($unreadNotifications > 0)
                        <span class="notification-count">{{ $unreadNotifications }}</span>
                    @endif --}}
                </a>
            </li>
        </ul>
    </nav>
</aside>

{{-- 
Le script est mis dans une pile pour être chargé à la fin du body.
Ceci est une bonne pratique pour ne pas bloquer le rendu de la page. 
--}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar-nav');
    const marker = document.getElementById('sidebar-marker');
    let enterTimeout, leaveTimeout;

    if (sidebar && marker) {
        // Fonction pour ouvrir la sidebar
        const openSidebar = () => {
            clearTimeout(leaveTimeout); // Annule une éventuelle fermeture programmée
            sidebar.classList.add('is-visible');
        };

        // Fonction pour fermer la sidebar
        const closeSidebar = () => {
            sidebar.classList.remove('is-visible');
        };

        // Ouvre la sidebar quand on passe la souris sur le marqueur ou sur la sidebar elle-même
        marker.addEventListener('mouseenter', openSidebar);
        sidebar.addEventListener('mouseenter', openSidebar);

        // Ferme la sidebar quand la souris quitte la zone combinée du marqueur et de la sidebar
        marker.addEventListener('mouseleave', () => {
            leaveTimeout = setTimeout(closeSidebar, 200); // Délai pour permettre de passer du marqueur à la sidebar
        });
        sidebar.addEventListener('mouseleave', () => {
            leaveTimeout = setTimeout(closeSidebar, 200);
        });
    }
});
</script>
@endpush