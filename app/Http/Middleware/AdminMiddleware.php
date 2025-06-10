<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Vérifie si l'utilisateur est authentifié ET si la propriété 'is_admin' est à true
        if (Auth::check() && Auth::user()->is_admin) {
            // Si c'est un admin, on le laisse passer à la requête suivante (le contrôleur).
            return $next($request);
        }

        // 2. Si l'utilisateur n'est pas un admin (soit non connecté, soit un client normal),
        // on le redirige.
        
        // On peut le déconnecter pour éviter toute confusion de session
        Auth::logout();
        
        // On le redirige vers la page de login avec un message d'erreur.
        return redirect()->route('login')
            ->with('error', 'Accès non autorisé. Veuillez vous connecter avec un compte administrateur.');
    }
}