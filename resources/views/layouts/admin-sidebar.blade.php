<aside class="admin-sidebar">
    {{-- Section du logo en haut de la sidebar --}}
    <div class="sidebar-header">
        <h1>
            <a href="{{ route('admin.dashboard') }}" title="Retour au Tableau de Bord">
                <i class="fas fa-shield-alt"></i>
                <span>Riad Admin</span>
            </a>
        </h1>
    </div>

    {{-- Navigation principale de l'administration --}}
    <nav>
        <ul class="sidebar-nav">
            <li>
                {{-- La classe 'active' est ajoutée si la route actuelle est 'admin.dashboard' --}}
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    <span>Tableau de Bord</span>
                </a>
            </li>
            <li>
                {{-- La classe 'active' est ajoutée si la route actuelle commence par 'admin.reservations.' --}}
                <a href="{{ route('admin.reservations.index') }}" class="{{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check fa-fw"></i>
                    <span>Gérer les Réservations</span>
                </a>
            </li>
            <li>
                {{-- La classe 'active' est ajoutée si la route actuelle commence par 'admin.menu.' --}}
                <a href="{{ route('admin.menu.index') }}" class="{{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils fa-fw"></i>
                    <span>Gérer les Plats</span>
                </a>
            </li>
            <li>
                {{-- La classe 'active' est ajoutée si la route actuelle commence par 'admin.tables.' --}}
                <a href="{{ route('admin.tables.index') }}" class="{{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                    <i class="fas fa-chair fa-fw"></i>
                    <span>Gestion des Tables</span>
                </a>
            </li>
            <li>
                {{-- La classe 'active' est ajoutée si la route actuelle commence par 'admin.messages.' --}}
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-headset fa-fw"></i>
                    <span>Boîte de Messagerie</span>
                </a>
            </li>
        </ul>
    </nav>

    {{-- Section en bas de la sidebar pour des liens utiles --}}
    <div class="sidebar-footer">
        <a href="{{ route('home') }}" target="_blank" title="Ouvrir le site public dans un nouvel onglet">
            <i class="fas fa-globe"></i>
            <span>Voir le site public</span>
        </a>
    </div>
</aside>