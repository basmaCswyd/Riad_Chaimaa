<aside class="admin-sidebar">
    <div class="sidebar-header">
        <h1>
            <a href="{{ route('admin.dashboard') }}">
                <i class="fas fa-shield-alt"></i>
                <span>Riad Admin</span>
            </a>
        </h1>
    </div>

    <nav>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt fa-fw"></i>
                    <span>Tableau de Bord</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.reservations.index') }}" class="{{ request()->routeIs('admin.reservations.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check fa-fw"></i>
                    <span>Gérer les Réservations</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.menu.index') }}" class="{{ request()->routeIs('admin.menu.*') ? 'active' : '' }}">
                    <i class="fas fa-utensils fa-fw"></i>
                    <span>Gérer les Plats</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.tables.index') }}" class="{{ request()->routeIs('admin.tables.*') ? 'active' : '' }}">
                    <i class="fas fa-chair fa-fw"></i>
                    <span>Gestion des Tables</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.messages.index') }}" class="{{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-headset fa-fw"></i>
                    <span>Boîte de Messagerie</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" target="_blank">
            <i class="fas fa-globe"></i>
            <span>Voir le site public</span>
        </a>
    </div>
</aside>