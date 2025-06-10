<header class="client-header">
    <div class="container">
        {{-- Lien vers l'accueil sur le logo --}}
        <div class="logo">
            <h1><a href="{{ route('home') }}">Riad</a></h1>
        </div>
        
        {{-- Navigation principale --}}
        <nav>
            <ul>
                {{-- Liens toujours visibles --}}
                <li>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home', 'menu.show') ? 'active' : '' }}">
                        Menu
                    </a>
                </li>
                <li>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                        À Propos
                    </a>
                </li>
                
                {{-- @auth est la directive Blade pour vérifier si l'utilisateur est connecté --}}
                @auth
                    {{-- ===== SECTION POUR UTILISATEUR CONNECTÉ ===== --}}
                    
                    <li>
                        <a href="{{ route('client.feedback.create') }}" class="{{ request()->routeIs('client.feedback.create') ? 'active' : '' }}">
                            Feedback
                        </a>
                    </li>
                    <li>
                        {{-- Bouton qui mène directement au formulaire de réservation --}}
                        <a href="{{ route('client.reservations.create') }}" class="btn btn-reserve">
                            Réserver
                        </a>
                    </li>
                    
                    {{-- Formulaire de déconnexion --}}
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault(); this.closest('form').submit();"
                               title="Se déconnecter">
                                Se Déconnecter
                            </a>
                        </form>
                    </li>

                @else
                    {{-- ===== SECTION POUR VISITEUR (NON CONNECTÉ) ===== --}}
                    
                    <li>
                        {{-- Lien qui redirige vers la page de login --}}
                        <a href="{{ route('login') }}">
                            Feedback
                        </a>
                    </li>
                    <li>
                        {{-- Lien qui redirige vers la page de login --}}
                        <a href="{{ route('login') }}" class="btn btn-reserve">
                            Réserver
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">
                            Se Connecter
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">
                            S'inscrire
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
    </div>
</header>